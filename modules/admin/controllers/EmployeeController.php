<?php

namespace app\modules\admin\controllers;

use app\components\BaseHtmlController;
use app\components\FlashMessage;
use app\models\UserIdentity;
use Yii;
use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends BaseHtmlController
{

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Employee();
        $model->load(Yii::$app->request->get());

        $dataProvider = new ActiveDataProvider([
            'query' => Employee::find()->searchActive($model),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_created = date('Y-m-d H:i:s');
            $model->password = UserIdentity::generateHashPassword($model->password);
            if ($model->insert()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        if ($model->hasErrors()) {
            FlashMessage::setDanger(current($model->getFirstErrors()));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_updated = date("Y-m-d H:i:s");
            if ($model->update(true, ['nickname', 'dt_updated'])) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $model->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\InvalidConfigException
     */
    protected function findModel(int $id)
    {
        if (($model = Employee::findActiveOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
