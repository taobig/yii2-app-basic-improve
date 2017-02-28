Yii 2 Basic Project Template
============================

**Based on `Yii 2 Basic Project Template`（[https://github.com/yiisoft/yii2-app-basic](https://github.com/yiisoft/yii2-app-basic)）.**

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

### INSTALLATION
**Install via Composer**  
If you do not have Composer, you may install it by following the instructions at getcomposer.org.

In order to use docker(or docker-toolbox), you must download this project to `$HOME/code`($HOME/code on Unix or %USERPROFILE%/code on Windows.).

You can then install this project template using the following command:
```
create-project [-s|--stability STABILITY] [--prefer-source] [--prefer-dist] [--repository REPOSITORY] [--repository-url REPOSITORY-URL] [--dev] [--no-dev] [--no-custom-installers] [--no-scripts] [--no-progress] [--no-secure-http] [--keep-vcs] [--no-install] [--ignore-platform-reqs] [--] [<package>] [<directory>] [<version>]
  
  
php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
php composer.phar create-project --prefer-dist --stability=dev taobig/yii2-app-basic-improve

```
then run `$HOME/code/yii2-app-basic-improve/_docker/_start_docker.sh` to start a docker container.

## Database
```
CREATE DATABASE `yii2-app-basic-improve` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

CREATE TABLE `employee` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `account` varchar(20) NOT NULL,
    `nickname` varchar(20) NOT NULL,
    `password` varchar(100) NOT NULL,
    `active` tinyint(4) NOT NULL,
    `dt_created` datetime NOT NULL,
    `dt_updated` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- default password is test
INSERT INTO `yii2-app-basic-improve`.`employee` (`account`, `nickname`, `password`, `active`, `dt_created`)
VALUES ('test', 'test', '$2y$10$TFvCpuZIcoxiA4k/z9YUH.aOd.qIgs3Orc1BaFmZH1VGvJWMC5Y..', '1', '2017-01-06 16:01:17');
```
