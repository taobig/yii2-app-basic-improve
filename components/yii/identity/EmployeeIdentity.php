<?php

namespace app\components\yii\identity;

use app\components\exceptions\UserException;
use app\models\Employee;
use yii\base\Exception;

class EmployeeIdentity extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    protected $password;//不要让外部访问
    protected $authKey;
    protected $accessToken;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $employee = Employee::findOne(['id' => $id]);
        if ($employee) {
            $identity = new static();
            $identity->id = $employee->id;
            $identity->username = $employee->account;
            $identity->password = $employee->password;
            return $identity;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception("unsupported !");
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
            $identity = new static();
            $identity->id = $employee->id;
            $identity->username = $employee->account;
            $identity->password = $employee->password;
            return $identity;
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


    public function updateOwnPassword(string $oldPassword, string $newPassword)
    {
        if (!$this->validatePassword($oldPassword)) {
            throw new UserException('当前密码输入错误');
        }

        $columns = [
            'password' => self::generateHashPassword($newPassword),
            'dt_updated' => date('Y-m-d H:i:s'),
        ];
        $condition = [
            'id' => $this->id,
        ];
        if (1 !== Employee::getDb()->createCommand()->update(Employee::tableName(), $columns, $condition)->execute()) {
            throw new UserException('修改密码失败，请重试');
        }
    }

    /**
     * @param int $userId
     * @param string $newPassword
     * @throws UserException
     * @throws \yii\db\Exception
     */
    public static function updatePassword(int $userId, string $newPassword)
    {
        $columns = [
            'password' => self::generateHashPassword($newPassword),
            'dt_updated' => date('Y-m-d H:i:s'),
        ];
        $condition = [
            'id' => $userId,
        ];
        if (1 !== Employee::getDb()->createCommand()->update(Employee::tableName(), $columns, $condition)->execute()) {
            throw new UserException('修改密码失败，请重试');
        }
    }

    public static function generateHashPassword(string $userInputPassword): string
    {
        return password_hash($userInputPassword, PASSWORD_DEFAULT);
    }

}
