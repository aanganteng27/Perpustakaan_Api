FROM php:8.2-fpm

# 1. Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip sqlite3 libsqlite3-dev nginx

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# 3. Set Working Directory
WORKDIR /var/www/html
COPY . .

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 5. Setup Database & Permissions awal
RUN mkdir -p database storage/logs storage/framework/views storage/framework/sessions storage/framework/cache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 6. Konfigurasi Nginx
RUN echo 'server { \n\
    listen 80; \n\
    root /var/www/html/public; \n\
    index index.php; \n\
    charset utf-8; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# 7. Startup script: PAKSA buat file database di lokasi production.sqlite
CMD mkdir -p /var/www/html/database && \
    touch /var/www/html/database/production.sqlite && \
    chmod 777 /var/www/html/database/production.sqlite && \
    php artisan config:clear && \
    php artisan storage:link && \
    php artisan migrate --force && \
    service nginx start && \
    php-fpm