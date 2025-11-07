# Docker Laravel 12 Application

A fully containerized Laravel 12 application with Docker, featuring a complete development and production environment setup with MySQL, Redis, Nginx, and PHP-FPM.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Architecture Overview

This project implements a multi-container Docker architecture with the following services:

### Services

- **App Container** (`app`) - PHP 8.3-FPM with Laravel 12
- **Web Container** (`web`) - Nginx 1.29 web server
- **Database** (`db`) - MySQL 8.0 server
- **Redis Cache** (`redis_cache`) - Redis for caching, sessions, and queues
- **phpMyAdmin** (`phpmyadmin_app`) - Database management interface (dev only)
- **MailHog** (`mailhog`) - Email testing service (dev only)

### Technology Stack

- **PHP**: 8.3 with FPM
- **Laravel**: 12.0
- **Database**: MySQL 8.0
- **Cache/Session/Queue**: Redis with Predis client
- **Web Server**: Nginx 1.29
- **Frontend Build**: Vite 7 with Tailwind CSS 4
- **Development Tools**: Xdebug 3.4 (dev environment), Laravel Pail, Laravel Pint

## Project Structure

```
docker_laravel12/
├── app/                    # Laravel application code
│   ├── Http/              # Controllers, Requests
│   ├── Models/            # Eloquent models (Message, User)
│   └── Providers/         # Service providers
├── docker/                # Docker configuration
│   ├── app/              # PHP-FPM Dockerfile
│   └── web/              # Nginx Dockerfile & config
├── resources/            # Views, CSS, JS
│   ├── css/             # Tailwind CSS
│   ├── js/              # JavaScript assets
│   └── views/           # Blade templates
├── routes/              # Application routes
├── database/            # Migrations, seeders, factories
├── config/              # Laravel configuration
├── docker-compose-dev.yaml   # Development environment
└── docker-compose-prod.yaml  # Production environment
```

## Prerequisites

- Docker Engine 20.10+
- Docker Compose 2.0+
- Git

## Quick Start

### Development Environment

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd docker_laravel12
   ```

2. **Create environment file**
   ```bash
   cp .env.example .env
   ```

3. **Start Docker containers**
   ```bash
   docker-compose -f docker-compose-dev.yaml up -d
   ```

4. **Install dependencies** (if needed)
   ```bash
   docker exec -it app_laravel composer install
   docker exec -it app_laravel npm install
   ```

5. **Run migrations**
   ```bash
   docker exec -it app_laravel php artisan migrate
   ```

6. **Access the application**
   - **Application**: http://localhost
   - **phpMyAdmin**: http://localhost:8080
   - **MailHog UI**: http://localhost:8025

### Production Environment

```bash
docker-compose -f docker-compose-prod.yaml up -d
```

## Environment Configuration

### Development Environment Variables

```env
APP_ENV=local
APP_DEBUG=true
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password

REDIS_HOST=redis_cache
REDIS_PORT=6379
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

XDEBUG_MODE=debug (or off)
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Database Credentials

- **Database**: laravel_db
- **User**: laravel_user
- **Password**: laravel_password
- **Root Password**: root_password

## Docker Container Details

### App Container (PHP-FPM)

- **Base Image**: PHP 8.3-FPM
- **Extensions**: PDO, MySQL, GD, mbstring, zip, curl
- **Development**: Xdebug 3.4 enabled
- **Production**: Optimized without Xdebug
- **Composer**: Version 2.4
- **Working Directory**: `/var/www`
- **Auto-setup**: Migrations, key generation, config caching

### Web Container (Nginx)

- **Base Image**: Nginx 1.29
- **Configuration**: Optimized for Laravel
- **Port**: 80
- **Document Root**: `/var/www/public`

### Database Container (MySQL)

- **Version**: MySQL 8.0
- **Port**: 3306
- **Persistent Volume**: `dbdata`
- **Character Set**: utf8mb4

### Redis Container

- **Version**: Latest
- **Port**: 6379
- **Persistence**: AOF (Append Only File) enabled
- **Usage**: Cache, sessions, queue driver

## Development Tools

### Running Tests

```bash
docker exec -it app_laravel composer test
# or
docker exec -it app_laravel php artisan test
```

### Code Formatting

```bash
docker exec -it app_laravel ./vendor/bin/pint
```

### View Logs

```bash
docker exec -it app_laravel php artisan pail
```

### Build Frontend Assets

```bash
# Development
docker exec -it app_laravel npm run dev

# Production
docker exec -it app_laravel npm run build
```

### Debugging with Xdebug

Set `XDEBUG_MODE` environment variable:
- `debug` - Enable step debugging
- `coverage` - Enable code coverage
- `off` - Disable Xdebug (recommended for production)

## Application Features

This Laravel application includes:

- **Message Management**: Create and list messages with soft delete support
- **Form Validation**: Custom request validation (`SubmitMessageRequest`)
- **Blade Components**: Reusable UI components
- **Tailwind CSS 4**: Modern utility-first CSS framework
- **Vite Integration**: Fast frontend tooling

### Routes

- `GET /` - Show message form (home)
- `POST /` - Submit message
- `GET /messages` - List all messages

## Database Migrations

The application includes the following migrations:

- `create_users_table` - User authentication
- `create_cache_table` - Cache storage
- `create_jobs_table` - Queue jobs
- `create_messages_table` - Messages feature
- `add_deleted_at_messages_table` - Soft delete support

## Volumes

- **dbdata**: Persistent MySQL data storage
- **vendor**: Composer dependencies (mounted)
- **Application files**: Mounted from host for development

## Useful Commands

### Container Management

```bash
# View running containers
docker-compose -f docker-compose-dev.yaml ps

# View logs
docker-compose -f docker-compose-dev.yaml logs -f

# Stop containers
docker-compose -f docker-compose-dev.yaml down

# Rebuild containers
docker-compose -f docker-compose-dev.yaml up -d --build
```

### Laravel Artisan

```bash
# Run artisan commands
docker exec -it app_laravel php artisan <command>

# Clear caches
docker exec -it app_laravel php artisan cache:clear
docker exec -it app_laravel php artisan config:clear
docker exec -it app_laravel php artisan view:clear

# Create new resources
docker exec -it app_laravel php artisan make:controller ControllerName
docker exec -it app_laravel php artisan make:model ModelName -m
```

### Database Operations

```bash
# Run migrations
docker exec -it app_laravel php artisan migrate

# Rollback migrations
docker exec -it app_laravel php artisan migrate:rollback

# Seed database
docker exec -it app_laravel php artisan db:seed

# Fresh migration with seeding
docker exec -it app_laravel php artisan migrate:fresh --seed
```

### Composer

```bash
# Install dependencies
docker exec -it app_laravel composer install

# Update dependencies
docker exec -it app_laravel composer update

# Dump autoload
docker exec -it app_laravel composer dump-autoload
```

## Performance Optimization

### Production Optimizations

The production Docker image includes:
- Optimized Composer autoloader
- Pre-built configuration cache
- Disabled debug mode
- No Xdebug overhead
- Minimized image layers

### Caching

```bash
# Cache configuration
docker exec -it app_laravel php artisan config:cache

# Cache routes
docker exec -it app_laravel php artisan route:cache

# Cache views
docker exec -it app_laravel php artisan view:cache
```

## Troubleshooting

### Permission Issues

```bash
docker exec -it app_laravel chmod -R 777 storage bootstrap/cache
```

### Clear All Caches

```bash
docker exec -it app_laravel php artisan optimize:clear
```

### Restart Services

```bash
docker-compose -f docker-compose-dev.yaml restart
```

### View Container Logs

```bash
docker logs app_laravel
docker logs mysql_server
docker logs redis_cache
```

## Security Notes

- Change default passwords in production
- Use environment variables for sensitive data
- Keep Docker images updated
- Review and restrict container capabilities
- Implement proper firewall rules
- Enable SSL/TLS for production

## License

This Laravel application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
