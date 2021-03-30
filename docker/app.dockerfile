FROM php:7.4-fpm
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    incron \
    nano \
    libpng-dev \
    nodejs \
    mariadb-client \
    rsyslog \
    vim \
    cron \
    supervisor \
    zlib1g-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libzip-dev \
    libonig-dev

RUN docker-php-ext-configure gd \
    --with-webp \
    --with-jpeg \
    --with-xpm \
    --with-freetype 

RUN docker-php-ext-install gd pdo pdo_mysql zip mbstring exif

RUN apt-get update && apt-get install -y libmagickwand-dev imagemagick --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


COPY package.json .
COPY package-lock.json .

RUN chown -R www-data:www-data /var/www

COPY docker/entrypoint.sh /
RUN chmod +x /entrypoint.sh

COPY docker/php.ini /usr/local/etc/php/
