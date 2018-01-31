#!/usr/bin/perl
# Подменяем GUID и UID для www-data текущим пользователем
use strict;

use File::stat;

my $path = '/home/project.ru/web/app.php';
my $stat = File::stat::stat($path);

if ($stat->uid && $stat->gid) {
    system(sprintf("usermod -u %s www-data", $stat->uid));
    system(sprintf("groupmod -g %s www-data", $stat->gid));
}

system("mkdir -p /home/project.ru/var/cache/prod");

system("chown -R www-data:www-data /run/php");
system("chown -R www-data:www-data /var/www");

system("chown -R www-data:www-data /home/project.ru");
system("ssh-keyscan -p 20022 gl.neva-center.ru >> /var/www/.ssh/known_hosts");

system("find /home/project.ru/var -type d -exec chmod 700 {} \\;");
system("find /home/project.ru/var -type f -exec chmod 600 {} \\;");
system("find /run/php -type d -exec chmod 700 {} \\;");
system("find /run/php -type f -exec chmod 600 {} \\;");
system("find /var/www -type d -exec chmod 755 {} \\;");
