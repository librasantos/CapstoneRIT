FROM php:5.6-apache

# Instala Composer, the defacto package manaker of php
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
    php composer-setup.php ; \
    php -r "unlink('composer-setup.php');"; \
    mv composer.phar /usr/bin/composer;

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -; \
    apt-get update;

# Instala nodejs, git, sudo, unzip, gulp-cli, php5-mysql, php5-mcrypt
RUN apt-get install -y nodejs \
    git \
    sudo \
    unzip \
    php5-mysql \
    php5-mcrypt; \      
    npm install -g gulp-cli;

# Enable php5-mysql and mcrypt
RUN cp /etc/php5/mods-available/pdo_mysql.ini /usr/local/etc/php/conf.d/; \
    cp /etc/php5/mods-available/mcrypt.ini /usr/local/etc/php/conf.d/; \
    echo "extension_dir=/usr/lib/php5/20131226/" >> /usr/local/etc/php/php.ini;

# Habilita el modo rewrite en apache.
RUN sudo cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/;

# Add a new user for security reasons.
RUN useradd -u 1000 -g www-data user; \
    echo "user ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers; \
    mkdir /home/user; \
    chown -R user:www-data /home/user;
    
USER user

WORKDIR /var/www/html

# Install composer packages
COPY $PWD/composer.json ./
RUN sudo chown -R user:www-data ./; \
    composer install --no-dev  --no-scripts --no-autoloader;

# Copy source code into image
COPY $PWD /var/www/html
COPY $PWD/public/.htaccess /var/www/html/public

# Add .conf/vhost.conf (nginx host config file) as default vhost
RUN sudo rm /etc/apache2/sites-available/000-default.conf; \
    sudo ln -s /var/www/html/.conf/vhost.conf /etc/apache2/sites-available/000-default.conf; \
    # Enable the 'clear' command
    echo "export TERM=xterm;" >> ~/.bashrc; \
    # The user will be 1000, the first non-root user of the system
    sudo .conf/setup-fs-permissions.sh; \
    # Autoload composer classes/namespaces
    composer dump-autoload; 

RUN mkdir www; \
    sudo cp -r ./public/** ./www/; \
    sudo cp ./public/.* ./www/; \
    sudo rm public -rf; \
    mv www public;

CMD sudo .conf/setup-fs-permissions.sh; \
    sudo apache2-foreground
