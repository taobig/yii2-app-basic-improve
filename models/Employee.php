<?php

namespace app\models;

use app\components\exceptions\InnerException;
use Yii;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property int $id
 * @property string $account 用户名
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property int $is_deleted 被删除的时间戳，0表示未删除
 * @property int $version
 * @property string $dt_created 创建时间
 * @property string $dt_updated 最后更新时间
 */
class Employee extends BaseModel
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
            [['account', 'password', 'dt_created'], 'required'],
            [['is_deleted', 'version'], 'integer'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['account', 'nickname'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 100],
            [['account', 'is_deleted'], 'unique', 'targetAttribute' => ['account', 'is_deleted']],
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
            'is_deleted' => '被删除的时间戳，0表示未删除',
            'version' => 'Version',
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
        throw new InnerException("User can't be deleted, your should change user.is_deleted");
    }

    public function softDelete()
    {
        $this->is_deleted = time();
        return $this->update(true, ['is_deleted']);
    }

}
