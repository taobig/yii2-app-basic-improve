<?php

use yii\db\Migration;

/**
 * Class m181201_010101_init
 */
class m181201_010101_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = \app\models\Employee::tableName();
        $username = "test";
        $password = substr(md5(time()), 0, 8);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $datetime = date('Y-m-d H:i:s');
        $sql = "
            CREATE TABLE `{$tableName}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `account` varchar(20) NOT NULL COMMENT '用户名',
              `nickname` varchar(20) NOT NULL COMMENT '昵称',
              `password` varchar(100) NOT NULL COMMENT '密码',
              `active` tinyint(4) NOT NULL COMMENT '状态1-有效 0-无效',
              `version` bigint(20) NOT NULL DEFAULT '0',
              `dt_created` datetime NOT NULL COMMENT '创建时间',
              `dt_updated` datetime DEFAULT NULL COMMENT '最后更新时间',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
            INSERT INTO `{$tableName}` (`account`, `nickname`, `password`, `active`, `dt_created`)
            VALUES ('{$username}', '{$username}', '{$hashedPassword}', '1', '{$datetime}');
        ";
        $this->execute($sql);

        echo "\n\nuser:{$username}, password:{$password}\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181201_010101_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181201_010101_init cannot be reverted.\n";

        return false;
    }
    */
}
