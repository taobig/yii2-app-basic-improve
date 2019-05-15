<?php

use app\components\exceptions\InnerException;
use app\models\Employee;
use app\models\UserIdentity;
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
//        $tableName = $this->getDb()->getSchema()->getRawTableName(Employee::tableName());
//        echo "tableName:{$tableName}\n";
        $username = "test";
        $password = substr(md5(time()), 0, 8);
        $hashedPassword = UserIdentity::generateHashPassword($password);
        $datetime = date('Y-m-d H:i:s');
//        $sql = "
//            CREATE TABLE `{$tableName}` (
//              `id` int(11) NOT NULL AUTO_INCREMENT,
//              `account` varchar(20) NOT NULL COMMENT '用户名',
//              `nickname` varchar(20) COMMENT '昵称',
//              `password` varchar(100) NOT NULL COMMENT '密码',
//              `active` tinyint(4) NOT NULL COMMENT '状态1-有效 0-无效',
//              `version` bigint(20) DEFAULT '0',
//              `dt_created` datetime NOT NULL COMMENT '创建时间',
//              `dt_updated` datetime DEFAULT NULL COMMENT '最后更新时间',
//              PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
//
//            INSERT INTO `{$tableName}` (`account`, `nickname`, `password`, `active`, `dt_created`)
//            VALUES ('{$username}', '{$username}', '{$hashedPassword}', '1', '{$datetime}');
//        ";
//        $this->execute($sql);
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Employee::tableName(), [
            'id' => $this->primaryKey(),//$this->integer()->notNull(),
            'account' => $this->string(20)->notNull()->comment("用户名"),
            'nickname' => $this->string(20)->comment("昵称"),
            'password' => $this->string(100)->notNull()->comment("密码"),
            'deleted_at' => $this->integer()->notNull()->defaultValue(0)->comment("被删除的时间戳，0表示未删除"),
            'version' => $this->bigInteger()->defaultValue(0),
            'dt_created' => $this->dateTime()->notNull()->comment("创建时间"),
            'dt_updated' => $this->dateTime()->comment("最后更新时间"),
        ], $tableOptions);
        $this->createIndex('unique_account', Employee::tableName(), ['account', 'deleted_at'], true);

        $employee = new Employee();
        $employee->account = $username;
//        $employee->nickname = ;
        $employee->password = $hashedPassword;
        $employee->dt_created = $datetime;
        if (!$employee->insert()) {
            var_dump($employee->errors);
            throw new InnerException("insert employee record failed");
        }

        echo "\n\nusername:{$username}, password:{$password}\n";
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
