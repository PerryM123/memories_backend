FROM php:8.0-fpm

ENV TZ Asia/Tokyo

RUN apt-get update && \
    # System packages
	apt-get install -y \
		git \
		unzip \
		libzip-dev \
		libicu-dev \
		libonig-dev \
		libpng-dev \
		libjpeg-dev \
	# PHP extensions
	&& docker-php-ext-configure gd --enable-gd --with-jpeg \
	&& docker-php-ext-install \
		gd \
		intl \
		pdo_mysql \
		zip \
		bcmath

COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY ./src /app

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache
