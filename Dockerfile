FROM alpine:3.12

LABEL Maintainer="Tim de Pater <code@trafex.nl>" \
      Description="Lightweight container with Nginx 1.14 & PHP-FPM 7.2 based on Alpine Linux."

# Install packages anywhere
RUN apk --no-cache add php7 php7-session php7-common php7-fpm php7-pdo php7-xdebug php7-intl php7-bcmath \
    php7-gmp php7-iconv php-pdo_mysql php7-json php7-openssl php7-curl php7-mbstring php7-gd php7-zlib \
    php7-xml php7-phar php7-intl php7-dom php7-ctype php7-zip php7-xmlwriter php7-xmlrpc \
    git nginx supervisor curl zlib-dev zlib musl zip

# fix work iconv library with alphine
RUN apk add gnu-libiconv=1.15-r2 --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

# Configure nginx
COPY bootstrap/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY bootstrap/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY bootstrap/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord
COPY bootstrap/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add application
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html/

# Dir permissions
RUN chmod -R 777 /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install --ignore-platform-reqs --no-dev

EXPOSE 80 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
