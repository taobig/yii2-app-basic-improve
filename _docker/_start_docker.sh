#!/usr/bin/env bash

container_name=yii2-app-basic-improve;
expose_port=80;
username=`whoami`;
docker stop ${container_name} && docker rm ${container_name};

dockerRun(){
    echo container_name=${container_name};
    echo expose_port=${expose_port};
    echo code_dir=${code_dir};
    echo custom_nginx_conf_dir=${custom_nginx_conf_dir};
    echo
    docker run --name ${container_name} -p ${expose_port}:80  -v ${code_dir}:/app -v ${custom_nginx_conf_dir}:/etc/nginx/conf.d -d taobig/nginx_php7:php70;
}

#Docker
#code_dir=C:\Users\${username}\code\${container_name};

#DockerToolbox  The drive name("c") must be a lowercase; and must run in "Docker Quickstart Terminal"
#code_dir=/c/Users/${username}/code/${container_name};

code_dir=/c/Users/${username}/code/${container_name};
custom_nginx_conf_dir=${code_dir}/_docker;
dockerRun;

if [ $? -eq 0 ];then
    echo "success, =====>>>>> 192.168.99.100:${expose_port}";
    docker ps;
else

    code_dir=c:/Users/${username}/code/${container_name};
    custom_nginx_conf_dir=${code_dir}/_docker;
    dockerRun;

    if [ $? -eq 0 ];then
        echo "success, =====>>>>> 127.0.0.1:${expose_port}";
        docker ps;
    else
        echo "failed";
        echo
    fi

fi