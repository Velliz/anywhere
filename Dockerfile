FROM alpine:3.8

LABEL Maintainer="Tim de Pater <code@trafex.nl>" \
      Description="Lightweight container with Nginx 1.14 & PHP-FPM 7.2 based on Alpine Linux."

ENV LC_ALL="en_GB.UTF-8"
ENV MYSQL_ROOT_PASSWORD="root"
ENV MYSQL_ALLOW_EMPTY_PASSWORD="true"
ENV MYSQL_RANDOM_ROOT_PASSWORD="root"
ENV MYSQL_DATABASE="anywhere"
ENV MYSQL_USER="root"

RUN mkdir /docker-entrypoint-initdb.d && \
    apk -U upgrade && \
    apk add --no-cache mariadb mariadb-client && \
    apk add --no-cache tzdata && \
    # clean up
rm -rf /var/cache/apk/*

# comment out a few problematic configuration values
RUN sed -Ei 's/^(bind-address|log)/#&/' /etc/mysql/my.cnf && \
    # don't reverse lookup hostnames, they are usually another container
    sed -i '/^\[mysqld]$/a skip-host-cache\nskip-name-resolve' /etc/mysql/my.cnf && \
    # always run as user mysql
    sed -i '/^\[mysqld]$/a user=mysql' /etc/mysql/my.cnf && \
    # allow custom configurations
    echo -e '\n!includedir /etc/mysql/conf.d/' >> /etc/mysql/my.cnf && \
mkdir -p /etc/mysql/conf.d/

# Install packages anywhere
RUN apk --no-cache add php7 php7-session php7-common php7-fpm php7-pdo php7-xdebug php7-intl php7-bcmath \
    php7-gmp php7-iconv php-pdo_mysql php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-ctype \
    php7-mbstring php7-gd git nginx supervisor curl

# Configure nginx
COPY bootstrap/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY bootstrap/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY bootstrap/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord
COPY bootstrap/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod 777 /usr/local/bin/docker-entrypoint.sh \
    && ln -s /usr/local/bin/docker-entrypoint.sh /

VOLUME /var/lib/mysql

# Add application
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install

EXPOSE 80 443
EXPOSE 3306

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
CMD ["mysqld_safe"]

ENTRYPOINT ["docker-entrypoint.sh"]
