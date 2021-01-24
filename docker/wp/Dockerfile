FROM wordpress:5.4.2-php7.3-apache

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

COPY wp-entrypoint.sh /usr/local/bin/wp-entrypoint.sh
RUN chmod +x /usr/local/bin/wp-entrypoint.sh

# override entrypoint
ENTRYPOINT ["wp-entrypoint.sh"]
CMD ["apache2-foreground"]


