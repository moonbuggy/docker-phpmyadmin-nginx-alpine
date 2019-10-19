FROM alpine:3.10
LABEL description="phpMyAdmin + php-fpm + nginx in Alpine."

ENV PMA_VERSION 4.9.1

ENV HTML_PATH /var/www/html
ENV PMA_CONFIG_PATH /etc/phpmyadmin

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session \
    php7-mbstring php7-gd nginx supervisor curl \
    php7-bz2 libzip php7-zip

# Prepare folders
RUN mkdir -p ${HTML_PATH}; \
    mkdir -p ${PMA_CONFIG_PATH}

# Install phpMyAdmin
RUN curl --output phpMyAdmin.tar.xz --location https://files.phpmyadmin.net/phpMyAdmin/${PMA_VERSION}/phpMyAdmin-${PMA_VERSION}-all-languages.tar.xz; \
    tar -xf phpMyAdmin.tar.xz -C ${HTML_PATH} --strip 1; \
    rm -f phpMyAdmin.tar.xz; \
    rm -rf ${HTML_PATH}/setup/ ${HTML_PATH}/examples/ ${HTML_PATH}/test/ ${HTML_PATH}/po/ ${HTML_PATH}/composer.json ${HTML_PATH}/RELEASE-DATE-${PMA_VERSION}; \
    mkdir -p ${HTML_PATH}/tmp; \
    chmod -R 777 ${HTML_PATH}/tmp

# Configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY config/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure phpMyAdmin
COPY config/config.inc.php ${PMA_CONFIG_PATH}/config.inc.php
COPY config/config.secret.inc.php ${PMA_CONFIG_PATH}/config.secret.inc.php

RUN sed -i "s@define('CONFIG_DIR'.*@define('CONFIG_DIR', '${PMA_CONFIG_PATH}/');@" ${HTML_PATH}/libraries/vendor_config.php; \
    sed -i "s/BLOWFISH_SECRET/$(tr -dc 'a-zA-Z0-9~!@#%^&*_()+}{?><;.,[]=-' < /dev/urandom | fold -w 32 | head -n 1)/" ${PMA_CONFIG_PATH}/config.secret.inc.php; \
    touch ${PMA_CONFIG_PATH}/config.user.inc.php; \
    mkdir -p /var/nginx/client_body_temp; \
    mkdir /sessions;


# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /run && \
    chown -R nobody.nobody /var/lib/nginx && \
    chown -R nobody.nobody /var/tmp/nginx && \
    chown -R nobody.nobody /var/log/nginx 

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
