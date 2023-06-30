#!/bin/bash

cd /var/www && \
    composer install && \
    composer require symfony/apache-pack && \
    # Change owner and permissions of the log directory
    chown -R www-data:www-data /var/www/var/log && chmod -R 755 /var/www/var/log && \

#    php bin/console doctrine:migrations:diff && \
#    php bin/console doctrine:migrations:migrate && \
    exec apache2-foreground