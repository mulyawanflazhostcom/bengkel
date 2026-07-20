FROM php:8.3-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends libonig-dev \
 && docker-php-ext-install -j"$(nproc)" bcmath mbstring \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Supervisor — runs web + queue worker + scheduler in a single container
RUN apt-get update && apt-get install -y --no-install-recommends supervisor \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Laravel: docroot Apache diarahkan ke /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && a2enmod rewrite

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
 && chown -R www-data:www-data storage bootstrap/cache

COPY .flazhost/supervisord.conf /etc/supervisor/conf.d/flazhost.conf

EXPOSE 80
CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/flazhost.conf"]
