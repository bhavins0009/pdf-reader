# cd-annual-converter - creditDevice B.V.

## Setup

* install VirtualBox (https://www.virtualbox.org)
* install Vagrant (http://www.vagrantup.com)
* install vagrant-vbguest (https://github.com/dotless-de/vagrant-vbguest)
* open a terminal
* navigate to this repository
* execute the following commands and follow the instructions

```
vagrant up
vagrant ssh
sudo su
bash /vagrant/vm/provision.sh
```

*Use dos2unix if bash complains about line endings (Windows).*

```
cd /vagrant/vm
apt-get install dos2unix
dos2unix provision.sh
```

## Provides

* PHP 7.2
* MariaDB 10.1
* Nginx 1.14
