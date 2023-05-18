FROM php:8.2.5-apache

RUN apt-get update && apt-get upgrade -y

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

COPY . /var/www/html

RUN echo 'SetEnv MYSQL_DB_CONNECTION mysql' >> /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_DB_NAME sadasad' >> /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_USER root' >> /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_PASSWORD 7yG0I8LGyEb3P1c' >> /etc/apache2/conf-enabled/environment.conf

RUN echo "ServerName mysql" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite headers
RUN a2dissite 000-default
RUN service apache2 restart

EXPOSE 80
