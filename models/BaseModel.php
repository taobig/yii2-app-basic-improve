<?php

namespace app\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{

    protected static $softDeleteAttribute = 'deleted_at';

    public function optimisticLock()
    {
        return 'version';
    }

    public function delete()
    {
        if (static::$softDeleteAttribute) {
            $this->{static::$softDeleteAttribute} = time();
            return $this->update(true, [static::$softDeleteAttribute]);
        }
    }

}