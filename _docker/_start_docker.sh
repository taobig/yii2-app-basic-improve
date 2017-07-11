#!/usr/bin/env bash

container_name=yii2-app-basic-improve;
expose_port=8080;

dockerRun(){
    custom_nginx_conf_dir=${code_dir}/_docker;
#    echo container_name=${container_name};
#    echo expose_port=${expose_port};
#    echo code_dir=${code_dir};
#    echo custom_nginx_conf_dir=${custom_nginx_conf_dir};
#    echo
    docker run --name ${container_name} --privileged=true -p ${expose_port}:80  -v ${code_dir}:/app -v ${custom_nginx_conf_dir}:/etc/nginx/conf.d -d taobig/nginx_php7:php70  1>/dev/null 2>&1;
}


#Docker
#code_dir=C:\Users\${username}\code\${container_name};

#DockerToolbox  The drive name("c") must be a lowercase; and must run in "Docker Quickstart Terminal"
#code_dir=/c/Users/${username}/code/${container_name};

#username=`whoami`;  username maybe different from the basename of home path
home_basename=`basename $HOME`;
#echo $HOME;#   /c/Users/{username}  or  /root
docker stop ${container_name} 1>/dev/null 2>&1;
docker rm   ${container_name} 1>/dev/null 2>&1;

container_has_run=0
sysOS=`uname -s`
if [ ${sysOS} == "Darwin" ];then
    code_dir=${HOME}/code/${container_name};# Docker(OSX)
elif [ ${sysOS} == "Linux" ];then
    code_dir=${HOME}/code/${container_name};# Docker(Linux)
else
# eg: MINGW64_NT-10.0
#    echo "Other OS: $sysOS"
#    echo $HOME;#   /c/Users/{username}
    code_dir=${HOME}/code/${container_name};# DockerToolbox(windows)
    dockerRun;

    if [ $? -eq 0 ];then
        echo "success, =====>>>>> 192.168.99.100:${expose_port}";
        docker ps;
        container_has_run=1;
    else
        code_dir=c:/Users/${home_basename}/code/${container_name};#Docker(Windows)
    fi
fi

if [ ${container_has_run} -eq 0 ];then
    dockerRun;

    if [ $? -eq 0 ];then
        echo "success, =====>>>>> 127.0.0.1:${expose_port}";
        docker ps;
    else
        echo "failed";
        echo
        exit 1;
    fi
fi


#init
config_path=$(cd `dirname $0`; pwd);
app_path=`dirname $config_path`;

cp ${app_path}/web/index-example.php ${app_path}/web/index.php;
sed -i "s/die;//" ${app_path}/web/index.php;
sed -i "s/\/\/dev //" ${app_path}/web/index.php;
sed -i "s/\/\/dev //" ${app_path}/web/index.php;