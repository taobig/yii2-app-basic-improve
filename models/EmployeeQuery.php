<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Employee]].
 *
 * @see Employee
 */
class EmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function searchActive(Employee $model)
    {
        if ($model->getSoftDeleteAttribute()) {
            $this->andWhere([$model->getSoftDeleteAttribute() => 0]);
        }

        $this->andFilterWhere(['id' => $model->id]);
        $this->andFilterWhere(['like', 'account', $model->account]);
        $this->andFilterWhere(['like', 'nickname', $model->nickname]);

        return $this;
    }
}
