FROM dunglas/frankenphp:php8.4-alpine

# Install ekstensi PHP yang dibutuhkan Laravel & MySQL
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache

# Set working directory
WORKDIR /app

# Salin source code
COPY . .

# Berikan izin ke folder storage & bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Jalankan server
CMD ["frankenphp", "php-server", "--root", "public/"]

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
