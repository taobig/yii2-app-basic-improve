<?php

namespace app\models;

use app\components\exceptions\UserException;
use yii\base\Exception;

class UserIdentity extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $employee = Employee::findOne(['id' => $id]);

        if ($employee) {
            $user = new static();
            $user->id = $employee->id;
            $user->username = $employee->account;
            $user->password = $employee->password;
            return $user;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception("unsupport !");
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $employee = Employee::findOne(['account' => $username]);
        if ($employee) {
            $user = new static();
            $user->id = $employee->id;
            $user->username = $employee->account;
            $user->password = $employee->password;
            return $user;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function updatePassword(string $oldPassword, string $newPassword)
    {
        if (!$this->validatePassword($oldPassword)) {
            throw new UserException('当前密码输入错误');
        }

        $columns = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'dt_updated' => date('Y-m-d H:i:s'),
        ];
        $condition = [
            'id' => $this->id,
        ];
        if (1 !== Employee::getDb()->createCommand()->update(Employee::tableName(), $columns, $condition)->execute()) {
            throw new UserException('修改密码失败，请重试');
        }
    }
}
