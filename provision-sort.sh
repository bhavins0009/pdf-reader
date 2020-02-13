if [ ! -d /var/bak ]; then
    mkdir -p /var/bak
    mv /etc/nginx/nginx.conf /var/bak/nginx.conf
    mv /etc/php5/fpm/php.ini /var/bak/php-7.2.ini
    mv /etc/php5/fpm/php-fpm.conf /var/bak/php-fpm-7.2.conf
fi

rm -f /etc/nginx/nginx.conf
rm -f /etc/php5/fpm/php.ini
rm -f /etc/php5/fpm/php-fpm.conf
rm -f /etc/nginx/common.conf
rm -f /etc/nginx/sites-available/app.conf
rm -f /etc/nginx/sites-enabled/app.conf
rm -f /etc/php5/fpm/pool.d/app.conf

cp /vagrant/vm/nginx.conf /etc/nginx/nginx.conf
cp /vagrant/vm/nginx-common.conf /etc/nginx/common.conf
cp /vagrant/vm/php.ini /etc/php5/fpm/php.ini
cp /vagrant/vm/php-fpm.conf /etc/php5/fpm/php-fpm.conf
cp /vagrant/vm/app/site.conf /etc/nginx/sites-available/app.conf
cp /vagrant/vm/app/pool.conf /etc/php5/fpm/pool.d/app.conf;