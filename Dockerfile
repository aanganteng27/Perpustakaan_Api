FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip sqlite3 libsqlite3-dev nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Set Working Directory
WORKDIR /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Setup Database & Permissions
RUN mkdir -p database && touch database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Copy konfigurasi Nginx (Kita buat perintahnya langsung di sini)
RUN echo 'server { \n\
    listen 80; \n\
    root /var/www/html/public; \n\
    add_header X-Frame-Options "SAMEORIGIN"; \n\
    add_header X-Content-Type-Options "nosniff"; \n\
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
    location ~ /\.(?!well-known).* { \n\
        deny all; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Start Nginx & PHP-FPM
CMD service nginx start && php-fpm