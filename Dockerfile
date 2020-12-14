FROM php:8.0-fpm

# SYSTEM PACKAGES
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libjpeg-dev \
    libpng-dev \
    librabbitmq-dev \
    librdkafka-dev \
    libxslt-dev \
    libzip-dev \
    libpq-dev \
    exim4-daemon-light \
    git \
    nginx \
    procps \
    supervisor \
    unzip \
    nano

# PHP PACKAGES
RUN docker-php-ext-configure gd --with-jpeg \
    && pecl install \
        redis \
    && docker-php-ext-install \
        opcache \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        bcmath \
        gd \
        intl \
        pcntl \
        zip \
    && docker-php-ext-enable \
        redis

# CLEAN UP CONTAINER
RUN apt purge -y $PHPSIZE_DEPS \
    && apt autoremove -y --purge \
    && apt clean all

# COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer


# PHP RUNTIME
WORKDIR /app
RUN chown -R www-data:www-data /app
USER www-data
COPY --chown=www-data:www-data . .

USER root

# PHP-FPM
COPY docker/php.ini $PHP_INI_DIR/php.ini
RUN rm /usr/local/etc/php-fpm.d/* && chown -R www-data:www-data /usr/local/etc/php/conf.d
COPY docker/fpm.conf /usr/local/etc/php-fpm.d/www.conf

# NGINX
RUN rm /etc/nginx/nginx.conf && chown -R www-data:www-data /var/www/html /run /var/lib/nginx /var/log/nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

USER www-data

EXPOSE 8080
ENTRYPOINT [ "/app/docker/entrypoint.sh" ]
