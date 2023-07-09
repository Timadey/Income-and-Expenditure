FROM php:8.0-apache

# Copy the entire project into the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Copy the Apache configuration file
COPY public/app.conf /etc/apache2/sites-available/app.conf

# Enable the Apache configuration
RUN a2ensite app.conf

# Install dependencies
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache module and rewrite rules
RUN a2enmod rewrite

# Start Apache service
CMD ["apache2-foreground"]
