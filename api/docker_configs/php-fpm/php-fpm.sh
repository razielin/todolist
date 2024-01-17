#!/bin/sh
# `/sbin/setuser memcache` runs the given command as the user `memcache`.
# If you omit that part, the command will be run as root.
exec php-fpm8.1 -F -c /etc/php/8.1/fpm/php-fpm.conf