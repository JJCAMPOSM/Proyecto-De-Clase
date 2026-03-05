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
# Para propósito de inicialización usamos un script dummy
CMD if [ -f artisan ]; then php artisan serve --host=0.0.0.0 --port=8000; else echo "Por favor, inicializa tu proyecto de Laravel en este volumen."; tail -f /dev/null; fi
