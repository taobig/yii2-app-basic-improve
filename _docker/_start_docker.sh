#!/usr/bin/env bash

base_path=$(cd `dirname $0`; pwd);
app_path=`dirname ${base_path}`;

cd ${app_path};
docker-compose up -d;

cp ${app_path}/web/index-example.php ${app_path}/web/index.php;
# OS X sed handles the -i argument differently to the Linux version.
# You can generate a command that might "work" for both by adding -e in this way:  sed -i -e
sed -i -e "s/die;//" ${app_path}/web/index.php;
sed -i -e "s/\/\/dev //" ${app_path}/web/index.php;
sed -i -e "s/\/\/dev //" ${app_path}/web/index.php;

cp ${app_path}/yii-example ${app_path}/yii;
sed -i -e "s/die;//" ${app_path}/yii;
sed -i -e "s/\/\/dev //" ${app_path}/yii;
sed -i -e "s/\/\/dev //" ${app_path}/yii;
chmod +x ${app_path}/yii;


#docker-compose exec -u www web composer install;
docker-compose exec -u www web bash -c "composer global require 'fxp/composer-asset-plugin:^1.4.2';composer install";