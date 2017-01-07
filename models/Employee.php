<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $account
 * @property string $nickname
 * @property string $password
 * @property integer $active
 * @property string $dt_created
 * @property string $dt_updated
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => 'Account',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'active' => 'Active',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
        ];
    }
}
