ARG APP_ENV=prod
ARG VERSION
ARG COMPOSER_MEMORY_LIMIT=-1

FROM php:8.1-fpm as base

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update -q && \
    apt-get install -qy \
    libmcrypt-dev \
    libgmp-dev \
    libzip-dev \
    libmagickwand-dev \
    libicu-dev \
    zlib1g-dev \
    curl \
    nano \
    git \
    unzip \
    libxrender1 \
    libfontconfig1

RUN docker-php-ext-install -j$(nproc) \
    gmp \
    pdo_mysql \
    bcmath \
    intl \
    soap \
    zip \
    gd \
    opcache

RUN pecl install imagick redis && \
    docker-php-ext-enable imagick redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base as dev

COPY composer.json composer.lock ./
# Php related stuff.
COPY ci/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ci/docker/php/security.ini /usr/local/etc/php/conf.d/security.ini
COPY ci/docker/php/memory.ini /usr/local/etc/php/conf.d/memory.ini
COPY ci/docker/php/execution.ini /usr/local/etc/php/conf.d/execution.ini

RUN pecl install pcov && \
    docker-php-ext-enable pcov


WORKDIR /var/www/html

ADD . .

RUN composer install \
    --no-interaction \
    --no-ansi \
    --no-progress


RUN composer dump-autoload

RUN chmod 777 \
    storage/app \
    storage/framework \
    storage/framework/cache \
    storage/framework/cache/data \
    storage/framework/views \
    storage/logs


RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.client_host             = 10.254.254.254" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.client_port             = 9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.log                     = \"/tmp/xdebug.log\" " >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.mode                    = profile " >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.start_with_request      = trigger " >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.trigger_value           = xprofile " >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.output_dir              = \"/tmp/xdebug/\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini  && \
    echo "xdebug.use_compression         = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN chmod +x artisan


CMD ["php-fpm"]
