FROM daocloud.io/php:5-apache
MAINTAINER Lv Yuan <yuanlv@126.com>

RUN docker-php-ext-install pdo_mysql
COPY . /var/www/html

EXPOSE 80
