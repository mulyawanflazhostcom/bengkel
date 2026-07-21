FROM php:8.4-apache

# OS deps + ekstensi PHP umum Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
      git unzip libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
      libonig-dev libxml2-dev libicu-dev \
      libjpeg-dev 2>/dev/null || true \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring zip exif pcntl bcmath gd intl opcache \
 && pecl install redis 2>/dev/null || docker-php-ext-install redis 2>/dev/null || true \
 && docker-php-ext-enable redis 2>/dev/null || true \
 && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache: DocumentRoot -> public/, mod_rewrite, dan FallbackResource supaya
# semua route Laravel (selain /) diteruskan ke index.php tanpa perlu .htaccess.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
      /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && a2enmod rewrite setenvif \
 && printf '%s\n' \
      '# Di belakang proxy TLS (CapRover): kenali HTTPS dari X-Forwarded-Proto supaya' \
      '# PHP/Laravel generate URL & form action https:// (cegah warning "not secure").' \
      'SetEnvIf X-Forwarded-Proto "https" HTTPS=on' \
      '<Directory /var/www/html/public>' \
      '    Options Indexes FollowSymLinks' \
      '    AllowOverride All' \
      '    Require all granted' \
      '    FallbackResource /index.php' \
      '</Directory>' \
      > /etc/apache2/conf-available/flazhost-laravel.conf \
 && a2enconf flazhost-laravel

# PHP: memory_limit lebih besar (default 128M sering kurang untuk Laravel)
RUN echo 'memory_limit=512M' > /usr/local/etc/php/conf.d/flazhost.ini

# Laravel: log ke stderr supaya error terlihat di App Logs / Error Log UI.
# Bisa di-override lewat env var app.
ENV LOG_CHANNEL=stderr

WORKDIR /var/www/html
COPY . .

# git mungkin tidak terinstall di beberapa base image — skip kalau tidak ada.
# composer install = jalur utama (deterministik, pakai lock). Fallback ke
# composer update kalau install gagal (lock basi / "lock file does not contain a
# compatible set of packages" saat composer.json diubah tanpa composer-update),
# supaya deploy tidak error hanya karena lock belum disinkron.
RUN (command -v git >/dev/null 2>&1 && git config --global --add safe.directory /var/www/html || true) \
 && ( composer install --no-dev --no-scripts --optimize-autoloader --no-interaction --prefer-dist --no-progress --ignore-platform-reqs \
      || composer update --no-dev --no-scripts --optimize-autoloader --no-interaction --prefer-dist --no-progress --ignore-platform-reqs ) \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80
# Startup: migration + seed (auto-deteksi) lalu Apache.
#  - migrate --force: terapkan migration (idempotent, --force wajib di production).
#  - db:seed --force: auto-jalankan DatabaseSeeder KALAU ada isinya (default Laravel
#    kosong = no-op). Guard "|| true" → seeder ber-unique-key gagal aman saat diulang
#    (tidak menduplikat data, tidak menggagalkan boot). App tetap hidup walau DB
#    sesaat belum siap; migration/seed menyusul di restart berikutnya.
#  - storage:link best-effort.
CMD ["/bin/bash", "-c", "if [ -f artisan ]; then php artisan migrate --force --no-interaction || true; php artisan db:seed --force --no-interaction || true; php artisan storage:link 2>/dev/null || true; fi; exec apache2-foreground"]
