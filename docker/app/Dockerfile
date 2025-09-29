FROM php:8.3-fpm as app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    --no-install-recommends \
    curl \
    zip \
    unzip \
    pkg-config \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libwebp-dev

RUN  set -eux; \
    #### if you need GD library, uncomment the following line
    # pecl install imagick \
    # && docker-php-ext-enable imagick \
    # && docker-php-ext-install pdo mbstring exif pcntl bcmath zip curl mysqli pdo_mysql 
    #### If you need imageMagick, uncomment the following lines
    docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd 
    

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

    

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY ./docker/web/php/*.ini $PHP_INI_DIR/conf.d/
COPY ./composer.* ./
RUN chmod -R 777 storage bootstrap \
; rm -rf vendor && mkdir -p vendor && composer install --no-scripts --no-autoloader --no-progress --no-interaction \
# RUN chmod +x artisan
; composer dump-autoload --optimize --no-interaction --no-scripts \
;

COPY ./ /var/www
VOLUME /var/www/vendor

RUN sed -i "s|exec \"\$@\"||g" `which docker-php-entrypoint` \
  ; echo "rm -rf .env*;\nprintenv | sed 's/=\\(.*\\)/=\"\\\1\"/' > .env.example;" >> `which docker-php-entrypoint` \
  ; echo "chmod -R 777 storage bootstrap;\n" >> `which docker-php-entrypoint` \
  ; echo "if [ -z \"\$APP_KEY\" ]; then echo \"APP_KEY=\" >> .env.example;fi;\n" >> `which docker-php-entrypoint` \
  ; echo "composer run post-root-package-install;\n \
    composer run post-create-project-cmd;\n \
    composer run post-autoload-dump;\n \
    . \$PWD/.env;\n \
    if [ \"\$APP_KEY\" = \"\" ]; then php artisan key:generate --ansi; php artisan migrate; fi;\n \
    php artisan config:cache;\n \
    exec \"\$@\";" >> `which docker-php-entrypoint` \
  ;

FROM app as app_dev

ENV XDEBUG_MODE=debug
ENV APP_DEBUG=true

RUN  set -eux; \
    pecl install xdebug-3.4.0beta1; \
    docker-php-ext-enable xdebug