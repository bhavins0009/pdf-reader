#!/usr/bin/env bash

set -o errexit
set -o nounset

echo "Provisioning VM"

apt-get update
apt-get upgrade -y

apt-get install -y \
  ntp \
  git \
  vim \
  curl \
  screen \
  php-cli \
  php-curl \
  php-fpm \
  php-intl \
  php-json \
  php-mbstring \
  php-mysql \
  php-bcmath \
  php-xml \
  php-apcu \
  php-xdebug \
  nginx-full \
  mariadb-server \
  python-pip \
  poppler-utils

pip install sphinx_rtd_theme

wget https://github.com/mailhog/MailHog/releases/download/v1.0.0/MailHog_linux_amd64
mv MailHog_linux_amd64 /opt/mailhog
chmod +x /opt/mailhog
cp /vagrant/vm/mailhog.service /etc/systemd/system/mailhog.service
systemctl enable mailhog
systemctl start mailhog

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

if [ ! -d /var/bak ]; then
    mkdir -p /var/bak
    mkdir -p /var/bak/nginx/sites-available
    mkdir -p /var/bak/php/7.2/fpm/pool.d
    mv /etc/nginx/nginx.conf /var/bak/nginx/nginx.conf
    mv /etc/nginx/sites-available/default /var/bak/nginx/sites-available/default
    mv /etc/php/7.2/fpm/php.ini /var/bak/php/7.2/fpm/php.ini
    mv /etc/php/7.2/fpm/php-fpm.conf /var/bak/php/7.2/fpm/php-fpm.conf
    mv /etc/php/7.2/fpm/pool.d/www.conf /var/bak/php/7.2/fpm/pool.d/www.conf
fi

rm -f /etc/nginx/nginx.conf
rm -f /etc/nginx/common.conf
rm -f /etc/nginx/sites-available/default
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-available/app.conf
rm -f /etc/nginx/sites-enabled/app.conf
rm -f /etc/php/7.2/fpm/php.ini
rm -f /etc/php/7.2/fpm/php-fpm.conf
rm -f /etc/php/7.2/fpm/pool.d/www.conf
rm -f /etc/php/7.2/fpm/pool.d/app.conf

cp /vagrant/vm/nginx.conf /etc/nginx/nginx.conf
cp /vagrant/vm/nginx-common.conf /etc/nginx/common.conf
cp /vagrant/vm/nginx-app.conf /etc/nginx/sites-available/app.conf
cp /vagrant/vm/php.ini /etc/php/7.2/fpm/php.ini
cp /vagrant/vm/php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf
cp /vagrant/vm/php-fpm-pool.conf /etc/php/7.2/fpm/pool.d/app.conf

ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/app.conf

service php7.2-fpm restart
service nginx restart

echo "Finished!"
