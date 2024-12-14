# Environment file or `.env`

> **Note:** If you need to change any config, be careful. If you need to add spaces or special characters, you need to surround the value with `"` to follow the application name for better understanding when changing the `.env` file.

## Create `.env` 

> Create a new database and rename `.env.example` to `.env`, then update your `.env` configurations by running these commands (in the project directory):

### Linux or MacOSX platform

```bash
cp .env.example .env 
```

### Windows platform

```bash
copy .env.example .env 
```

## Application Configuration

### Application Name

```bash
APP_NAME=xShop2
```
Example after changing:
```bash
APP_NAME="My shop project"
```

### Application Environment

```bash
APP_ENV=local
```
Specify the environment. Common values are `local`, `production`, `testing`.

### Application Key

```bash
APP_KEY=
```
Set this value by running `php artisan key:generate` in your terminal.

### Application Debug Mode

```bash
APP_DEBUG=true
```
Set to `false` in production for security reasons.

### Application Timezone

```bash
APP_TIMEZONE=ASIA/TEHRAN
```
Set your application's timezone. Use `date.timezone` values from PHP.

### Application URL

```bash
APP_URL=http://127.0.0.1:8000
```
The URL of your application.

### Localization

```bash
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
```
Set the default locale and fallback locale for localization.

### Maintenance Mode

```bash
APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database
```
Settings for maintaining your application.

### Logging Configuration

```bash
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```
Determine the logging channels and level.

## Database Configuration

### SQLite

```bash
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```
For SQLite, create an empty database file as follows:
```bash
touch /path/to/database.sqlite
```

### MySQL

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xshop_db
DB_USERNAME=root
DB_PASSWORD=
```
Ensure you set the correct database name, username, and password.

## Session Configuration

```bash
SESSION_DRIVER=database
SESSION_LIFETIME=9999999
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```
Configure session handling using the database.

## Broadcasting

```bash
BROADCAST_CONNECTION=log
```
Set the broadcasting connection.

## Filesystem

```bash
FILESYSTEM_DISK=local
```
Set the default disk for file storage.

## Cache Configuration

```bash
CACHE_STORE=database
CACHE_PREFIX=
```
Set cache configuration.

## Redis Configuration

```bash
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
Configure Redis for caching and sessions.

## Mail Configuration

```bash
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Set mail settings for your application.

## Media Configuration

```bash
MEDIA_WATERMARK_SIZE=15
MEDIA_WATERMARK_OPACITY=50
```
Configure media settings, such as watermarking.

## AWS Configuration

```bash
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```
Set your AWS S3 configuration if needed.

## Multi-language Support

```bash
XLANG_ACTIVE=false
XLANG_MAIN=en
XLANG_API_URL="http://5.255.98.77:3001"
```
Enable multi-language support.

## Currency Configuration

```bash
CURRENCY_SYMBOL="$"
CURRENCY_FACTOR=1
CURRENCY_CODE=USD
```

- **CURRENCY_FACTOR** is used for currency conversion; for example, to convert Toman to Rial, it should be set to 10.

## SMS Configuration

```bash
SMS_SING=true
SMS_DRIVER=Kavenegar
SMS_TOKEN=
SMS_USER=
SMS_PASSWORD=
SMS_URL="https://api.kavenegar.com/v1/TOKEN/verify/lookup.json"
SMS_NUMBER=
```
Settings for sending SMS.

## Payment Gateway Configuration

```bash
ZARINPAL_MERCHANT=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
ZIBAL_MERCHANT=zibal
PAY_GATEWAY=zibal
```
Settings for payment gateways, for example, ZarinPal and Zibal.

---
#### Note
Ensure you fill in the required values in the `.env` file according to your environment and needs.
