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

# Install composer packages
COPY $PWD/composer.json /home/user/composer_packages/
RUN cd /home/user/composer_packages; \
    sudo chown -R user:www-data ./; \
    composer install --no-dev --no-scripts --no-autoloader;

# Install nodejs packages
COPY $PWD/package.json /home/user/npm_packages/
RUN cd /home/user/npm_packages; \
    sudo chown -R user:www-data ./; \
    npm install --production;

WORKDIR /var/www/html

# Copy source code into image
COPY $PWD /var/www/html

# The user will be 1000, the first non-root user of the system
RUN sudo chown -R 1000:www-data .; \
    # All new files will have the inherite the group id (www-data)
    sudo chmod g+s ./; \
    # All files belong to 1000 (first user in linux systems) and to group www-data
    sudo chmod -R 750 ./; \
    # These laravel directories must be writable
    sudo chmod -R g+rwx bootstrap/cache storage; \
    # Move the vendor and nodejs directories to the app code directory
    cp /home/user/composer_packages/vendor ./ -r; \
    cp /home/user/npm_packages/node_modules ./ -r

# Add .conf/vhost.conf (nginx host config file) as default vhost
RUN sudo rm /etc/apache2/sites-available/000-default.conf; \
    sudo ln -s /var/www/html/.conf/vhost.conf /etc/apache2/sites-available/000-default.conf;

# Habilta el comando 'clear' en el terminal
RUN echo "export TERM=xterm;" >> ~/.bashrc;

CMD if [ ! -e "vendor" ]; then \
        composer install; \
    fi; \
    if [ ! -e "node_modules" ]; then \
        npm install; \
    fi; \
    sudo apache2-foreground
