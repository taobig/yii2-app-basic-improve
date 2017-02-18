#!/usr/bin/env bash


container_name=yii2-app-basic-improve;
expose_port=8080;
username=`whoami`;
docker stop ${container_name} && docker rm ${container_name};

#code_dir=C:\Users\${username}\code\${container_name};

#DockerToolbox  盘符c要小写；and must run in "Docker Quickstart Terminal"
code_dir=/c/Users/${username}/code/${container_name};
custom_nginx_conf_dir=${code_dir}/_docker;
docker run --name ${container_name} -p ${expose_port}:80  -v ${code_dir}:/app -v ${custom_nginx_conf_dir}:/etc/nginx/conf.d -d taobig/nginx_php7:php71;