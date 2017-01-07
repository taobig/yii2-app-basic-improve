<?php

namespace app\controllers;

use app\components\BaseWebController;
use app\components\exceptions\ParamException;
use app\components\exceptions\UserException;
use app\components\filters\AccessControl;
use app\components\Flash;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\captcha\CaptchaAction;
use app\components\filters\VerbFilter;

class SiteController extends BaseWebController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['password', 'logout'],
                'rules' => [
                    [
                        'actions' => ['password', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 5,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionPassword()
    {
        if (Yii::$app->request->getIsPost()) {
            try {
                $oldPassword = (string)Yii::$app->request->post('old_password', '');
                $newPassword = (string)Yii::$app->request->post('new_password', '');
                if (empty($oldPassword) || empty($newPassword)) {
                    throw new ParamException('新旧密码都不能为空');
                }
                $user = User::findIdentity(Yii::$app->user->id);
                $user->updatePassword($oldPassword, $newPassword);
                Flash::setSuccess('更改密码成功');
            } catch (UserException $e) {
                Flash::setDanger($e->getMessage());
            } catch (\Throwable $e) {
                \QCustomLogger::logException(\QCustomLogger::TYPE_ERROR, $e);
                Flash::setDanger('系统异常，请重试');
            }
        }

        $username = Yii::$app->user->identity->username;
        return $this->render('password', [
            'username' => $username,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        return $this->goHome();
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

}
