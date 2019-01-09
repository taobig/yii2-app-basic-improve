<?php

namespace app\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{

    /**
     * @return string|null
     */
    public static function getSoftDeleteAttribute()
    {
        return 'deleted_at';
    }

    public function optimisticLock()
    {
        return 'version';
    }

    /**
     * @param $condition
     * @return array|\yii\db\ActiveRecordInterface|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function findActiveOne($condition)
    {
        $query = static::findByCondition($condition);
        if (static::getSoftDeleteAttribute()) {
            $query->andWhere([static::getSoftDeleteAttribute() => 0]);
        }
        return $query->one();
    }

    /**
     * @param $condition
     * @return array|ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public static function findActiveAll($condition)
    {
        $query = static::findByCondition($condition);
        if (static::getSoftDeleteAttribute()) {
            $query->andWhere([static::getSoftDeleteAttribute() => 0]);
        }
        return $query->all();
    }

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function softDelete()
    {
        $softDeleteAttribute = static::getSoftDeleteAttribute();
        if ($softDeleteAttribute) {
            $this->{$softDeleteAttribute} = time();
            return $this->update(true, [$softDeleteAttribute]);
        }
    }


}