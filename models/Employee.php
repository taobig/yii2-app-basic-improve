<?php

namespace app\models;

use app\components\exceptions\InnerException;
use app\enums\EnumEmployeeActive;
use Yii;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property int $id
 * @property string $account 用户名
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property int $active 状态1-有效 0-无效
 * @property string $dt_created 创建时间
 * @property string $dt_updated 最后更新时间
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account', 'nickname', 'password', 'active', 'dt_created'], 'required'],
            [['active'], 'integer'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['account', 'nickname'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'active' => '状态',
            'dt_created' => '创建时间',
            'dt_updated' => '最后更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }

    public function delete()
    {
        throw new InnerException("User can't be deleted, your should change user.active");
    }

    public function softDelete()
    {
        $this->active = EnumEmployeeActive::DELETED;
        return $this->update(true, ['active']);
    }

    public function optimisticLock()
    {
        return 'version';
    }
}
