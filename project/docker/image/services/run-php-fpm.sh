#!/usr/bin/with-contenv bash
set -e
exec php-fpm7.1 --nodaemonize --fpm-config /etc/php/7.1/fpm/php-fpm.conf
