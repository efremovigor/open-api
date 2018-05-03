#!/usr/bin/with-contenv bash
set -e
exec php-fpm7.2 --nodaemonize --fpm-config /etc/php/7.2/fpm/php-fpm.conf
