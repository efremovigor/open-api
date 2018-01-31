#!/bin/bash
# HOME variable required for composer
export HOME=/home/project.ru/

set -e
cd /home/project.ru/
s6-setuidgid www-data php composer.phar install
# EOF
