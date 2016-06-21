#!/bin/bash
echo "=== apt-get update ==="
sudo apt-get update
echo "=== Installing and configuring Apache2 ==="
sudo apt-get install apache2 -y
sudo a2enmod rewrite
sudo echo "<VirtualHost *:80>
        <Directory /var/www/html>
              Options Indexes FollowSymLinks MultiViews
              AllowOverride All
              Order allow,deny
              allow from all
        </Directory>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
" > /etc/apache2/sites-enabled/000-default.conf

echo "=== Installing and configuring PHP ==="
sudo apt-get install php5 php5-pgsql php5-json -y
sudo service apache2 restart
echo "=== Installing and configuring PostgreSQL ==="
sudo apt-get install postgresql -y
sudo -u postgres psql -c "CREATE USER hubble_user;"
sudo -u postgres psql -c "ALTER ROLE hubble_user WITH CREATEDB;"
sudo -u postgres psql -c "CREATE DATABASE hubbledb OWNER hubble_user;"
sudo -u postgres psql -c "ALTER USER hubble_user WITH ENCRYPTED PASSWORD 'password'"
sudo sed -i 's/peer/md5/' /etc/postgresql/9.3/main/pg_hba.conf
sudo /etc/init.d/postgresql restart

export PGPASSWORD=password
psql -U hubble_user -d hubbledb < /vagrant/hubble_schema.sql

echo "=== Installing Composer ==="
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '070854512ef404f16bac87071a6db9fd9721da1684cd4589b1196c3faf71b9a2682e2311b36a5079825e155ac7ce150d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/bin --filename=composer
php -r "unlink('composer-setup.php');"
composer global require "laravel/installer"

sudo rm -r /var/www/html/
sudo chmod -R 777 /vagrant/hubble/storage/
cd /var/www/ && sudo ln -s /vagrant/hubble/public/ html
cd /vagrant/hubble && php artisan key:generate