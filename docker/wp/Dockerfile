FROM wordpress:5.4.2-php7.3-apache

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

COPY wp-entrypoint.sh /usr/local/bin/wp-entrypoint.sh
RUN chmod +x /usr/local/bin/wp-entrypoint.sh

# override entrypoint
ENTRYPOINT ["wp-entrypoint.sh"]
CMD ["apache2-foreground"]


