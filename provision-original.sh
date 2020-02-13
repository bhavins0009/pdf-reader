#!/usr/bin/env bash

set -o errexit
set -o nounset

export DEBIAN_FRONTEND=noninteractive

echo "Provisioning virtual machine..."

echo "LC_ALL=en_US.UTF-8" >> /etc/default/locale
locale-gen en_US.UTF-8
timedatectl set-timezone Europe/Amsterdam

sudo apt-get update
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php
apt-get update
apt-get upgrade -y

apt-get install -y \
  ntp \
  git \
  vim \
  curl \
  screen \
  zip \
  unzip \
  php7.2-cli \
  php7.2-curl \
  php7.2-fpm \
  php7.2-intl \
  php7.2-json \
  php7.2-mbstring \
  php7.2-mysql \
  php7.2-tidy \
  php7.2-xml \
  php-apcu \
  php-xdebug \
  mariadb-server \
  nginx \
  gdebi


if [ ! -f /usr/local/bin/composer ]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

if [ ! -f /usr/local/bin/mailhog ]; then
    curl -Lo /usr/local/bin/mailhog https://github.com/mailhog/MailHog/releases/download/v1.0.0/MailHog_linux_amd64 && chmod 0755 /usr/local/bin/mailhog
    cp /vagrant/vm/mailhog.service /etc/systemd/system/mailhog.service
    systemctl enable mailhog
    systemctl start mailhog
fi

if [ ! -d /var/bak ]; then
    mkdir -p /var/bak
    mv /etc/nginx/nginx.conf /var/bak/nginx.conf
    mv /etc/php/7.2/fpm/php.ini /var/bak/php-7.2.ini
    mv /etc/php/7.2/fpm/php-fpm.conf /var/bak/php-fpm-7.2.conf
fi

rm -f /etc/nginx/nginx.conf
rm -f /etc/php/7.2/fpm/php.ini
rm -f /etc/php/7.2/fpm/php-fpm.conf
rm -f /etc/nginx/common.conf
rm -f /etc/nginx/sites-available/app.conf
rm -f /etc/nginx/sites-enabled/app.conf
rm -f /etc/php/7.2/fpm/pool.d/app.conf

cp /vagrant/vm/nginx.conf /etc/nginx/nginx.conf
cp /vagrant/vm/nginx-common.conf /etc/nginx/common.conf
cp /vagrant/vm/php.ini /etc/php/7.2/fpm/php.ini
cp /vagrant/vm/php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf
cp /vagrant/vm/app/site.conf /etc/nginx/sites-available/app.conf
cp /vagrant/vm/app/pool.conf /etc/php/7.2/fpm/pool.d/app.conf

ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/app.conf


service php7.2-fpm restart
service nginx restart

echo "Finished!"
