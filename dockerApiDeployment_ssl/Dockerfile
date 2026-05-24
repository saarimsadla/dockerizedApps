# Use official PHP Apache image
FROM php:8.1-apache

# Install Python3, pip, and utilities
RUN apt-get update && \
    apt-get install -y python3 python3-pip curl unzip openssl && \
    ln -s /usr/bin/python3 /usr/bin/python && \
    apt-get clean

# Install Python pymongo package (no separate bson to avoid ImportError)
RUN pip3 install pymongo

# Default MongoDB URI (Override this at runtime using -e MONGO_URI="..." in docker run)
ENV MONGO_URI="mongodb://user:pass@host.docker.internal:27017/?authMechanism=DEFAULT"

# Enable Apache SSL and rewrite modules
RUN a2enmod ssl rewrite

# Set working directory for Apache
WORKDIR /var/www/html

# Copy your index.html (optional)
# COPY index.html /var/www/html/index.html

# Copy PHP APIs folder (includes pythonScripts)
COPY phpApis /var/www/html/phpApis

# Create a self-signed SSL certificate for HTTPS
RUN mkdir -p /etc/apache2/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/apache2/ssl/apache.key \
    -out /etc/apache2/ssl/apache.crt \
    -subj "/C=US/ST=State/L=City/O=Organization/OU=Org/CN=localhost"

# Configure default SSL virtual host
RUN echo '<VirtualHost *:443>' > /etc/apache2/sites-available/default-ssl.conf && \
    echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '    SSLEngine on' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '    SSLCertificateFile /etc/apache2/ssl/apache.crt' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '    SSLCertificateKeyFile /etc/apache2/ssl/apache.key' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '    <Directory /var/www/html>' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/default-ssl.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/default-ssl.conf

# Enable SSL site
RUN a2ensite default-ssl.conf

# Enable HTTP to HTTPS redirect
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    RewriteEngine On' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    RewriteCond %{HTTPS} off' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Expose both HTTP and HTTPS ports
EXPOSE 80 443

# Start Apache in foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
