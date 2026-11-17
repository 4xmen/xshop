# ---- Stage 1: build front-end assets ----
FROM node:22-bookworm-slim AS frontend

WORKDIR /app
RUN corepack enable

COPY package.json pnpm-lock.yaml pnpm-workspace.yaml ./
RUN pnpm install --frozen-lockfile

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
# generator reads the default parts from the seeder
COPY database/seeders/PartSeeder.php ./database/seeders/PartSeeder.php
COPY docker/build/gen-client-assets.mjs ./docker/build/gen-client-assets.mjs

# build client.scss / client.js (what `php artisan client` does) then compile
RUN node docker/build/gen-client-assets.mjs && pnpm build


# ---- Stage 2: install PHP dependencies ----
FROM php:8.4-fpm-bookworm AS vendor

COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions \
        gd zip intl bcmath pcntl exif soap \
        pdo_mysql pdo_sqlite imagick redis opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app

# temporary .env so artisan can boot during composer scripts; production avoids
# the dev-only providers in config/app.php
COPY .env.example ./.env
RUN sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env

# dev deps are kept on purpose: seeders use fakerphp/faker at runtime
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

COPY . .
RUN composer dump-autoload --optimize \
 && composer run-script post-autoload-dump --no-interaction


# ---- Stage 3: runtime (nginx + php-fpm + supervisor) ----
FROM php:8.4-fpm-bookworm AS app

LABEL org.opencontainers.image.title="Avandora" \
      org.opencontainers.image.description="Open-source Laravel shopping system" \
      org.opencontainers.image.source="https://github.com/4xmen/avandora" \
      org.opencontainers.image.licenses="GPL-3.0-or-later"

ENV DEBIAN_FRONTEND=noninteractive \
    APP_HOME=/var/www/html \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx supervisor ca-certificates curl tzdata \
    && rm -rf /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions \
        gd zip intl bcmath pcntl exif soap \
        pdo_mysql pdo_sqlite imagick redis opcache

# kept for maintenance (artisan, migrate, ...)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR ${APP_HOME}

COPY docker/php/php.ini        /usr/local/etc/php/conf.d/zz-avandora.ini
COPY docker/php/www.conf       /usr/local/etc/php-fpm.d/zz-avandora.conf
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# app source, then vendor + compiled assets from the previous stages
COPY --chown=www-data:www-data . ${APP_HOME}
COPY --from=vendor   --chown=www-data:www-data /app/vendor          ${APP_HOME}/vendor
COPY --from=vendor   --chown=www-data:www-data /app/bootstrap/cache ${APP_HOME}/bootstrap/cache
COPY --from=frontend --chown=www-data:www-data /app/public/build    ${APP_HOME}/public/build

# default .env; runtime env vars override it
RUN cp -n .env.example .env || true

# writable dirs + permissions
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/testing \
        storage/logs \
        storage/app/public \
        storage/media-library/temp \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=40s --retries=3 \
    CMD curl -fsS http://127.0.0.1/up || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
