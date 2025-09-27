FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    --no-install-recommends \
    #### if you need GD library, uncomment the following line
    # && pecl install imagick \
    # && docker-php-ext-enable imagick \
    # && docker-php-ext-install pdo mbstring exif pcntl bcmath zip curl mysqli pdo_mysql 
    #### If you need imageMagick, uncomment the following lines
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd 
    #mbstring  exif pcntl bcmath zip unzip curl pdo

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY ./composer.* ./
RUN chmod -R 777 storage bootstrap \
; rm -rf vendor && mkdir -p vendor && composer install --no-scripts --no-autoloader --no-progress --no-interaction \
# RUN chmod +x artisan
; composer dump-autoload --optimize --no-interaction --no-scripts \
;

COPY ./app /var/www
VOLUME /var/www/vendor

RUN sed -i "s|exec \"\$@\"||g" `which docker-php-entrypoint` \
  ; echo "rm -rf .env*;\nprintenv | sed 's/=\\(.*\\)/=\"\\\1\"/' > .env.example;" >> `which docker-php-entrypoint` \
  ; echo "chmod -R 777 storage;\n" >> `which docker-php-entrypoint` \
  ; echo "if [ -z \"\$APP_KEY\" ]; then echo \"APP_KEY=\" >> .env.example;fi;\n" >> `which docker-php-entrypoint` \
  ; echo "composer run post-root-package-install;\n \
    composer run post-create-project-cmd;\n \
    composer run post-autoload-dump;\n \
    . \$PWD/.env;\n \
    if [ \"\$APP_KEY\" = \"\" ]; then php artisan key:generate --ansi; fi;\n \
    php artisan config:cache;\n \
    exec \"\$@\";" >> `which docker-php-entrypoint` \
  ;



# #optional
# RUN apt-get clean && rm -rf /var/lib/apt/list/*

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Create system user to run Composer and Artisan Commands
# RUN useradd -u $uid -ms /bin/bash -g www-data $user

# #Change permission
# COPY --chown=user:www-data . /var/www

# # RUN composer install --no-autoloader

# USER  $user
# EXPOSE 9000

# CMD [ "php-fpm" ]







