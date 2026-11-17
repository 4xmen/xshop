# 🐳 Avandora — Docker Guide

A single, all-in-one image that runs **Nginx + PHP-FPM 8.4 + Supervisor**
(with a queue worker and the Laravel scheduler), plus a ready-made
`docker-compose` stack with **MariaDB** and **Redis**.

---

## 1. Quick start (recommended — Docker Compose)

```bash
# 1. (optional) create your env file — sensible defaults work out of the box
cp .env.example .env

# 2. build & start everything.
#    On the VERY FIRST run add AUTO_SEED=true so the admin user and the default
#    theme parts get created (otherwise the shop comes up empty and returns 500):
AUTO_SEED=true docker compose up -d --build

# 3. open the shop
#    http://localhost:8080       (admin panel: /dashboard)
```

On the **first run** the container automatically:

- creates `.env` (if missing) and generates `APP_KEY`,
- waits for the database, runs `php artisan migrate`,
- with `AUTO_SEED=true`, seeds the admin user + default theme/settings,
- links `public/storage`, caches config/routes/views.

> **Note:** the image always runs with `APP_ENV=production` (it is the only
> supported mode — dev-only providers in `config/app.php` are skipped). Later
> runs can drop `AUTO_SEED` so data is not re-seeded.

> Default admin logins (after seeding): `developer@example.com` /
> `admin@example.com` — password `password`.

---

## 2. Build the image only

```bash
docker build -t avandora:latest .
```

---

## 3. Run with plain `docker run`

### a) Self-contained (SQLite, zero dependencies)

```bash
docker run -d --name avandora \
  -p 8080:80 \
  -e DB_CONNECTION=sqlite \
  -v avandora_storage:/var/www/html/storage \
  avandora:latest
```

### b) With an external database, passing a full env file

```bash
docker run -d --name avandora \
  -p 8080:80 \
  --env-file .env \
  -e DB_CONNECTION=mysql \
  -e DB_HOST=my-db-host -e DB_PORT=3306 \
  -e DB_DATABASE=avandora -e DB_USERNAME=avandora -e DB_PASSWORD=secret \
  -v avandora_storage:/var/www/html/storage \
  -v avandora_upload:/var/www/html/public/upload \
  avandora:latest
```

---

## 4. Configuration — all via environment variables

Any variable from `.env.example` can be passed with `-e`, `--env-file`, or the
compose `environment:` block. **Environment variables always override the
`.env` file inside the container.** Common ones:

| Variable            | Default                   | Description                                   |
|---------------------|---------------------------|-----------------------------------------------|
| `APP_URL`           | `http://localhost:8080`   | Public URL of the shop                        |
| `APP_ENV`           | `local`                   | Set to `production` for live                  |
| `APP_DEBUG`         | `true`                    | Set to `false` for live                       |
| `APP_KEY`           | *(auto-generated)*        | Leave empty to auto-generate on first boot    |
| `DB_CONNECTION`     | `sqlite`                  | `mysql` / `mariadb` / `pgsql` / `sqlite`      |
| `DB_HOST` …         | —                         | Standard Laravel DB settings                  |
| `REDIS_HOST`        | `redis` (compose)         | Redis host                                    |
| `CACHE_STORE`       | `database`                | `database` / `redis` / `file`                 |
| `SESSION_DRIVER`    | `database`                | `database` / `redis` / `file`                 |
| `QUEUE_CONNECTION`  | `database`                | `database` / `redis`                          |
| `PANEL_PREFIX`      | `dashboard`               | Admin panel URL prefix                        |
| Payment / SMS keys  | —                         | `ZARINPAL_*`, `ZIBAL_*`, `PAYPAL_*`, `SMS_*`… |

### Container-only control flags (handled by the entrypoint / Supervisor)

| Variable            | Default | Description                                         |
|---------------------|---------|-----------------------------------------------------|
| `AUTO_MIGRATE`      | `true`  | Run `migrate --force` on start                      |
| `AUTO_SEED`         | `false` | Run `db:seed --force` on start                      |
| `WAIT_FOR_DB`       | `true`  | Wait for the DB TCP port before migrating           |
| `OPTIMIZE`          | `true`  | Cache config/routes/views on start                  |
| `RUN_QUEUE_WORKER`  | `true`  | Start the `queue:work` worker                       |
| `QUEUE_WORKERS`     | `1`     | Number of parallel queue workers                    |
| `RUN_SCHEDULER`     | `true`  | Start the Laravel scheduler (`schedule:work`)       |

---

## 5. Volumes (persistent data)

| Container path                      | Holds                                            |
|-------------------------------------|--------------------------------------------------|
| `/var/www/html/storage`             | uploads, media library, logs, sessions, cache    |
| `/var/www/html/public/upload`       | legacy public upload folder                       |
| `/var/www/html/database` *(sqlite)* | the `database.sqlite` file (mount if using sqlite)|

In the compose file these map to the named volumes
`storage_data`, `upload_data`, `db_data`, `redis_data`.

---

## 6. Useful commands

```bash
# Tail logs
docker compose logs -f app

# Run artisan inside the running container
docker compose exec app php artisan about
docker compose exec app php artisan migrate:fresh --seed

# Open a shell
docker compose exec app bash

# Rebuild after code changes
docker compose up -d --build

# Stop / remove (keep data)
docker compose down
# Remove data too
docker compose down -v
```

---

## 7. Production notes

- Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong, fixed `APP_KEY`.
- Put a TLS-terminating reverse proxy (Traefik / Nginx / Caddy) in front, or
  publish behind your load balancer; the container serves plain HTTP on port 80.
- Use managed MySQL/MariaDB + Redis and point the `DB_*` / `REDIS_*` vars at them.
- For zero-downtime deploys keep `AUTO_MIGRATE=false` and run migrations as a
  separate one-off step:
  `docker compose run --rm app php artisan migrate --force`.
- The image exposes a health check at `/up` (used by `HEALTHCHECK`).
