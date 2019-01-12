

    /**
     * @param <?= $modelFullClassName ?> $model
     * @return $this
     */
    public function search($model)
    {
<?php foreach ($properties as $property => $data):
    if($property === ('\\' . $generator->ns . '\\' . $modelFullClassName)::getSoftDeleteAttribute()){
        continue;
    }
    if($data['type'] === 'string'):?>
        $this->andFilterWhere(['like', '<?=$property?>', $model-><?=$property?>]);
<?php else:?>
        $this->andFilterWhere(['<?=$property?>' => $model-><?=$property?>]);
<?php endif;?>
<?php endforeach; ?>
        return $this;
    }