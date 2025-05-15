# Базовый образ с PHP и Apache
FROM php:8.3-apache

COPY apache-config.conf /etc/apache2/conf-enabled/servername.conf
# Установка зависимостей для Joomla
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip

# Включение модуля Apache rewrite (для ЧПУ)
RUN a2enmod rewrite

# Копируем файлы Joomla в контейнер
COPY joomla/ /var/www/html/

# Устанавливаем права (Joomla требует запись в папки)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Порт, который слушает Apache
EXPOSE 80

# Команда запуска Apache
CMD ["apache2-foreground"]