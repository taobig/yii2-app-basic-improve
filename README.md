Yii 2 Basic Project Template
============================

**Based on `Yii 2 Basic Project Template`（[https://github.com/yiisoft/yii2-app-basic](https://github.com/yiisoft/yii2-app-basic)）.**

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://poser.pugx.org/taobig/yii2-app-basic-improve/v/stable)](https://packagist.org/packages/taobig/yii2-app-basic-improve)
[![Total Downloads](https://poser.pugx.org/taobig/yii2-app-basic-improve/downloads)](https://packagist.org/packages/taobig/yii2-app-basic-improve)
[![Latest Unstable Version](https://poser.pugx.org/taobig/yii2-app-basic-improve/v/unstable)](https://packagist.org/packages/taobig/yii2-app-basic-improve)
[![License](https://poser.pugx.org/taobig/yii2-app-basic-improve/license)](https://packagist.org/packages/taobig/yii2-app-basic-improve)
[![Build Status](https://travis-ci.org/taobig/yii2-app-basic-improve.svg?branch=master)](https://travis-ci.org/taobig/yii2-app-basic-improve)

### INSTALLATION
**Install via Composer**  
If you do not have Composer, you may install it refer to [getcomposer.org](https://getcomposer.org/download/).

In order to use Docker-Toolbox, you must download this project to `$HOME`($HOME on *nix or %USERPROFILE% on Windows).

You can then install this project template using the following command:
```
  
composer global require "fxp/composer-asset-plugin:^1.4.2"
composer create-project --prefer-dist taobig/yii2-app-basic-improve

# install project from master branch
composer create-project taobig/yii2-app-basic-improve data-query dev-master

```
then 
```bash
cd yii2-app-basic-improve
docker-compose up --build -d
If you generated your dev config, you can run
    docker-compose -f docker-compose.yml -f docker-compose-dev.yml up --build -d
```
to start a docker container.   
The homepage is on http://localhost (Docker)  or http://192.168.99.100 (Docker-toolbox)

## Database
1. ```CREATE DATABASE `DATABASE_NAME` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;```
2. modify `config/db.php`
3. run `yii migrate` in project root dir to init tables.

# dev
> npm i gulp-cli -g  
> gulp watch  

# pre-deploy
1. build static resources
> gulp
