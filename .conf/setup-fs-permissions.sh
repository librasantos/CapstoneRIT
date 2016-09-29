
chown -R 1000:www-data /var/www/html/; \
# All new files will have the inherite the group id (www-data)
chmod g+s /var/www/html/; \
# All files belong to 1000 (first user in linux systems) and to group www-data
chmod -R 750 /var/www/html/; \

# These laravel directories must be writable
chmod -R g+rwx /var/www/html/bootstrap/cache /var/www/html/storage;
