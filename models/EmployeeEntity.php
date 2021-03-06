<?php

namespace app\models;

use taobig\yii\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property int $id
 * @property string $account 用户名
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property int $deleted_at 被删除的时间戳，0表示未删除
 * @property int $version
 * @property string $dt_created 创建时间
 * @property string $dt_updated 最后更新时间
 */
abstract class EmployeeEntity extends BaseModel
{
    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account', 'password', 'dt_created'], 'required'],
            [['deleted_at', 'version'], 'integer'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['account', 'nickname'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 100],
            [['account', 'deleted_at'], 'unique', 'targetAttribute' => ['account', 'deleted_at']],
        ];
    }

    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'deleted_at' => '被删除的时间戳，0表示未删除',
            'version' => 'Version',
            'dt_created' => '创建时间',
            'dt_updated' => '最后更新时间',
        ];
    }

    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }
}
