FROM daocloud.io/php:5-apache
MAINTAINER Lv Yuan <yuanlv@126.com>

COPY index.html /var/www/html/
COPY daocloud.yml /var/www/html/
COPY init.php /var/www/html/

EXPOSE 80
