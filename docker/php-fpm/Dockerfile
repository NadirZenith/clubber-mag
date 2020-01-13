FROM php:7.3-fpm

RUN ln -fs /usr/share/zoneinfo/Europe/Paris /etc/localtime; \
    dpkg-reconfigure -f noninteractive tzdata

RUN curl -fsS -o /tmp/icu.tgz -L http://download.icu-project.org/files/icu4c/64.2/icu4c-64_2-src.tgz \
  && tar -zxf /tmp/icu.tgz -C /tmp \
  && cd /tmp/icu/source \
  && ./configure --prefix=/usr/local \
  && make \
  && make install \
# just to be certain things are cleaned up
  && rm -rf /tmp/icu*

# PHP_CPPFLAGS are used by the docker-php-ext-* scripts
ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"

RUN apt-get update && apt-get install -y gcc zlib1g-dev libjpeg-dev libpng-dev libzip-dev zip unzip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl --with-icu-dir=/usr/local && \
    docker-php-ext-configure gd --with-png-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ && \
    docker-php-ext-install intl zip mysqli pdo pdo_mysql gd

# @todo use entrypoint to copy production or development config
# or pass ENV variable to php.ini-$WP_ENV
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/conf.d/php.ini



# override parent entry point
# composer install & run tests
ADD bin/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]


WORKDIR  "/application"
VOLUME  "/application"
