Yii 2 Basic Project Template
============================

**Based on `Yii 2 Basic Project Template`（[https://github.com/yiisoft/yii2-app-basic](https://github.com/yiisoft/yii2-app-basic)）.**

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

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
