FROM taobig/nginx-php7-fpm:7.0

ARG env_name


# WARNING: Image for service web was built because it did not already exist. To rebuild this image you must use `docker-compose build` or `docker-compose up --build`.
# docker-compose up --build -d
RUN echo "env.name=${env_name}" >> /usr/local/php/etc/php.ini

#RUN echo "env.name=dev" >> /usr/local/php/etc/php.ini && \
#    composer global require 'fxp/composer-asset-plugin:^1.4.2' && \
#    composer install ;


#Set port
EXPOSE 80 443

#Start it
ENTRYPOINT ["/start.sh"]
