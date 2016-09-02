FROM php:5.6-apache

# Instala Composer, the defacto package manaker of php
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
    php composer-setup.php ; \
    php -r "unlink('composer-setup.php');"; \
    mv composer.phar /usr/bin/composer;

# Instala Git
RUN apt-get update; apt-get install -y git;

# Instala nodejs
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -; \
    apt-get install -y nodejs;

# Install and enable php5-mysql in order to support MySQL driver
RUN apt-get install -y php5-mysql; \
    cp /etc/php5/mods-available/pdo_mysql.ini /usr/local/etc/php/conf.d/; \
    echo "extension_dir=/usr/lib/php5/20131226/" >> /usr/local/etc/php/php.ini;

# Habilita el modo rewrite en apache.
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/;

# Habilta el comando 'clear' en el terminal
RUN echo "export TERM=xterm;" >> ~/.bashrc;

WORKDIR /var/www/html

