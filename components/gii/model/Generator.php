<?php

namespace app\components\gii\model;


use app\components\BaseModel;
use app\components\BaseQuery;
use ReflectionClass;
use Yii;
use yii\helpers\FileHelper;

class Generator extends \yii\gii\generators\model\Generator
{

    public $baseClass = BaseModel::class;
    public $generateLabelsFromComments = true;
    public $useTablePrefix = true;
    public $generateQuery = true;
    public $queryBaseClass = BaseQuery::class;

    private function unStickyAttributes(): array
    {
        return ['baseClass', 'generateLabelsFromComments', 'useTablePrefix', 'generateQuery', 'queryBaseClass'];
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '自定义 Model  Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'This generator generates an ActiveRecord class for the specified database table.';
    }


    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function defaultTemplate()
    {
        $class = new ReflectionClass(\yii\gii\generators\model\Generator::class);

        $targetDir = $this->createDefaultTemplate($class->getFileName());
        return $targetDir;
    }

    //make model-generator compatible to Upstream
    private function createDefaultTemplate(string $filename)
    {
        $sourceDir = dirname($filename) . '/default';
        $targetDir = Yii::getAlias('@app/runtime/custom-gii/model/default');
        FileHelper::copyDirectory($sourceDir, $targetDir);
        $queryFileContent = file_get_contents($targetDir . '/query.php');
        $pos = strrpos($queryFileContent, '}');
        $appendContent = file_get_contents(__DIR__ . '/default/query-append.php');
        file_put_contents($targetDir . '/query.php', substr_replace($queryFileContent, $appendContent, $pos - 1, 0));
        return $targetDir;
    }

    /**
     * {@inheritdoc}
     * @return string
     * @throws \ReflectionException
     */
    public function formView()
    {
        $class = new ReflectionClass(\yii\gii\generators\model\Generator::class);

        return dirname($class->getFileName()) . '/form.php';
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getStickyDataFile()
    {
        return Yii::$app->getRuntimePath() . '/gii-' . Yii::getVersion() . '/' . str_replace('\\', '-', \yii\gii\generators\model\Generator::class) . '.json';
    }


    /**
     * {@inheritdoc}
     */
    public function stickyAttributes()
    {
        $parentStickyAttributes = parent::stickyAttributes();
        foreach ($parentStickyAttributes as $key => $parentStickyAttribute) {
            if (in_array($parentStickyAttribute, $this->unStickyAttributes(), true)) {
                unset($parentStickyAttributes[$key]);
            }
        }
        return $parentStickyAttributes;
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function generate()
//    {
//        return parent::generate();
//    }


}