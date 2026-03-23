FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libicu-dev \
    g++ \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mysqli \
        zip \
        intl \
        mbstring \
        exif \
        pcntl \
        bcmath \
        soap \
        sockets \
        opcache \
    && pecl install redis \
    && pecl install xdebug \
    && docker-php-ext-enable redis xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN { \
      echo "memory_limit = 2G"; \
      echo "upload_max_filesize = 128M"; \
      echo "post_max_size = 128M"; \
      echo "max_execution_time = 300"; \
      echo "opcache.enable=1"; \
      echo "opcache.memory_consumption=256"; \
      echo "opcache.interned_strings_buffer=16"; \
      echo "opcache.max_accelerated_files=20000"; \
    } > /usr/local/etc/php/conf.d/custom.ini

RUN { \
      echo "[xdebug]"; \
      echo "xdebug.mode = develop,debug,coverage"; \
      echo "xdebug.start_with_request = trigger"; \
      echo "xdebug.client_host = host.docker.internal"; \
      echo "xdebug.client_port = 9003"; \
      echo "xdebug.discover_client_host = 1"; \
      echo "xdebug.log = /tmp/xdebug.log"; \
      echo "xdebug.log_level = 7"; \
    } > /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html

RUN groupadd -g 1000 app \
 && useradd -u 1000 -g app -m -s /bin/bash app \
 && chown -R app:app /var/www/html

USER app

CMD ["php-fpm"]
