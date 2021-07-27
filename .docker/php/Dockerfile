ARG PHP_VERSION
FROM $PHP_VERSION

# Realiza instalaciones necesarias
RUN docker-php-ext-install pdo pdo_mysql \
    && apt-get update && apt-get install -y \
    locales \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    zlib1g-dev libicu-dev g++ \
    openssl libssl-dev libcurl4-openssl-dev \
    && pecl config-set php_ini "${PHP_INI_DIR}/php.ini" \
    && pecl install -o -f \
        redis \
    && docker-php-ext-enable \
        redis \
    && docker-php-ext-install intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setea el servidor en español
RUN sed -i '/es_MX.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen

ENV LANG es_MX.UTF-8
ENV LANGUAGE es_MX:es
ENV LC_ALL es_MX.UTF-8

# Crea el directorio de los logs
RUN mkdir -p /var/log/php-fpm \
    && echo '' >> /var/log/php-fpm/www-error.log \
    && chmod 777 /var/log/php-fpm/www-error.log

WORKDIR /var/www
