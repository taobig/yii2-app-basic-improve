#!/usr/bin/env bash

base_path=$(cd `dirname $0`; pwd);
app_path=`dirname ${base_path}`;

cd ${app_path};
docker-compose up -d;

cp ${app_path}/web/index-example.php ${app_path}/web/index.php;
sed -i "s/die;//" ${app_path}/web/index.php;
sed -i "s/\/\/dev //" ${app_path}/web/index.php;
sed -i "s/\/\/dev //" ${app_path}/web/index.php;

docker-compose exec -u www web composer install;