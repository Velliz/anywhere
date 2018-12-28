FROM alpine:3.8
LABEL Maintainer="Tim de Pater <code@trafex.nl>" \
      Description="Lightweight container with Nginx 1.14 & PHP-FPM 7.2 based on Alpine Linux."

# Install packages
RUN apk --no-cache add php7 php7-session php7-fpm php7-pdo php-pdo_mysql php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype \
    php7-mbstring php7-gd php7-soap php7-ldap nginx supervisor curl git

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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install

EXPOSE 80 443
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
