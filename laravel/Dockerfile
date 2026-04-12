FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Mantenemos el contenedor en ejecución de manera básica.
# Si el proyecto laravel existiera, usaríamos:
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
# Para propósito de inicialización usamos bash y nos aseguramos de montar composer
CMD bash -c "if [ ! -f vendor/autoload.php ]; then composer install --no-interaction; fi && php artisan serve --host=0.0.0.0 --port=8000"
