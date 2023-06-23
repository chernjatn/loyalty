FROM php:8.0.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN apt-get update && apt-get install -y procps && rm -rf /var/lib/apt/lists/*
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER root
USER $user

#FROM php:8.0.2-apache
#
#USER root
#
#WORKDIR /var/www
#
#RUN apt-get update && apt-get install -y \
#        libpng-dev \
#        zlib1g-dev \
#        libxml2-dev \
#        libzip-dev \
#        libonig-dev \
#        zip \
#        curl \
#        unzip \
#    && docker-php-ext-configure gd \
#    && docker-php-ext-install -j$(nproc) gd \
#    && docker-php-ext-install pdo_mysql \
#    && docker-php-ext-install mysqli \
#    && docker-php-ext-install zip \
#    && docker-php-source delete
#
#COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
#
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#
#RUN chown -R www-data:www-data /var/www \
#    && a2enmod rewrite
