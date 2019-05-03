<?php

namespace app\components\yii;

abstract class BaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param BaseModel $model
     * @return $this
     */
    abstract public function search($model);


    public final function searchActive(BaseModel $model)
    {
        if ($model->getSoftDeleteAttribute()) {
            $this->andWhere([$model->getSoftDeleteAttribute() => 0]);
        }
        $this->search($model);
        return $this;
    }

}
