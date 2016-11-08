FROM php:5.6-apache
RUN apt-get update
RUN apt-get install -y git zip php5-pgsql php5-json libpq-dev && docker-php-ext-install pdo pdo_pgsql
WORKDIR /home/
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/bin --filename=composer
RUN git clone https://github.com/apcros/Hubble.git
RUN cd Hubble/Server/hubble && composer install
RUN a2enmod rewrite
ADD config/000-default.conf /etc/apache2/sites-enabled/000-default.conf
ADD config/env_dev /home/Hubble/Server/hubble/.env
RUN cd /home/Hubble/Server/hubble && php artisan key:generate
RUN service apache2 restart
RUN rm -r /var/www/html
RUN chmod -R 777 /home/Hubble/Server/hubble/storage/
RUN ln -s /home/Hubble/Server/hubble/public/ /var/www/html

