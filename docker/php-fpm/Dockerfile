FROM php:7.0-fpm

RUN apt-get update && apt-get install -y gcc zlib1g-dev zip unzip && rm -rf /var/lib/apt/lists/*

RUN curl -fsS -o /tmp/icu.tgz -L http://download.icu-project.org/files/icu4c/59.1/icu4c-59_1-src.tgz \
  && tar -zxf /tmp/icu.tgz -C /tmp \
  && cd /tmp/icu/source \
  && ./configure --prefix=/usr/local \
  && make \
  && make install \
# just to be certain things are cleaned up
  && rm -rf /tmp/icu*

# PHP_CPPFLAGS are used by the docker-php-ext-* scripts
ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"

RUN docker-php-ext-configure intl --with-icu-dir=/usr/local && \
    docker-php-ext-install intl zip mysqli pdo pdo_mysql

#RUN usermod -u 1000 www-data

#ADD start.sh /start.sh

#RUN ls -l /application
#CMD ["php-fpm"]

WORKDIR  "/application"

#COPY run.sh /docker-php-entrypoint
#RUN echo "echo 'okapa';" >> ./web/index.php
#RUN ls -la /app
#ENTRYPOINT ["/start.sh"]
