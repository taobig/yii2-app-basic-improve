<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Employee]].
 *
 * @see Employee
 */
class EmployeeQuery extends \app\components\yii\BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * Auto-generated by Gii-2.0.8.0 
     * {@inheritdoc}
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
    * Auto-generated by Gii-2.0.8.0 
    * @param Employee $model
    * @return $this
    */
    public function search($model)
    {
        $this->andFilterWhere(['id' => $model->id]);
        $this->andFilterWhere(['like', 'account', $model->account]);
        $this->andFilterWhere(['like', 'nickname', $model->nickname]);
//        $this->andFilterWhere(['like', 'password', $model->password]);
        $this->andFilterWhere(['version' => $model->version]);
        $this->andFilterWhere(['like', 'dt_created', $model->dt_created]);
        $this->andFilterWhere(['like', 'dt_updated', $model->dt_updated]);
        return $this;
    }
}