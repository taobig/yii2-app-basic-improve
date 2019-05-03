<?php

namespace app\components\yii\gii\model;


use app\components\yii\BaseModel;
use app\components\yii\BaseQuery;
use ReflectionClass;
use Yii;
use yii\gii\CodeFile;
use yii\gii\Module;

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


    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $reflector = new ReflectionClass(Module::class);
        $reflectionMethod = $reflector->getMethod("defaultVersion");
        $reflectionMethod->setAccessible(true);
        $giiVersion = $reflectionMethod->invoke(new Module([]));

        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            // model :
            $modelClassName = $this->generateClassName($tableName);
            $entityClassName = $modelClassName . 'Entity';
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'properties' => $this->generateProperties($tableSchema),
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $params['entityClassName'] = $entityClassName;
            $params['giiVersion'] = $giiVersion;
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $entityClassName . '.php',
                $this->render('entity.php', $params)
            );

            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );

            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php',
                    $this->render('query.php', $params)
                );
            }
        }

        return $files;
    }

}