FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    wget \
    zip \
    libzip-dev \
    curl \
    git-core \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer
