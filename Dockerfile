# Usar la imagen oficial de PHP con FPM y Nginx
FROM php:8.0-fpm

# Establecer el directorio de trabajo
WORKDIR /var/www

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    nginx \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los contenidos del directorio de la aplicación
COPY . /var/www

# Instalar dependencias de PHP con Composer
RUN composer install --no-dev --optimize-autoloader

# Copiar configuración de Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Establecer permisos
COPY --chown=www-data:www-data . /var/www

# Cambiar el usuario actual a www
USER www-data

# Exponer el puerto 80
EXPOSE 80

# Iniciar Nginx y PHP-FPM
CMD ["sh", "-c", "service nginx start && php-fpm"]
