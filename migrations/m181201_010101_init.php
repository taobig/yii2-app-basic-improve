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
                `account` varchar(20) NOT NULL,
                `nickname` varchar(20) NOT NULL,
                `password` varchar(100) NOT NULL,
                `active` tinyint(4) NOT NULL,
                `dt_created` datetime NOT NULL,
                `dt_updated` datetime DEFAULT NULL,
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
