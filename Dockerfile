FROM daocloud.io/php:5-apache
MAINTAINER Lv Yuan <yuanlv@126.com>

#install git for ci
RUN  apt-get update && apt-get install -y git-core

COPY index.html /var/www/html/
COPY daocloud.yml /var/www/html/
COPY init.php /var/www/html/

EXPOSE 80
