<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\ar\Users;
use app\models\FileUploadForm;
use app\models\ar\Files;
use app\components\UploadedFiles;

class SiteController extends Controller
{
    

    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'test', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'test', 'index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete_image' => ['post'],
                    'upload' => ['post'],
                    'multiple_delete' => ['post']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($searchString = "")
    {
        $baseUrl = $this->getBaseUrl();
        $model = new \app\models\FileUploadForm();
        
        $files = Files::getImages(Yii::$app->user->getId(), $searchString);
        return $this->render('index', ['model' => $model, 'files' => $files, 'baseUrl' => $baseUrl]);
    }
    
    public function actionUpload() {
       $model = new \app\models\FileUploadForm();
       $model->imageFiles = \yii\web\UploadedFile::getInstances($model, 'imageFiles');;
       $ok = $model->upload(); 
       if (!$ok) {
           \Yii::$app->session->setFlash('error', implode(', ', $model->getErrorSummary(true)));
       }
       $this->redirect(['site/index']);
    }
    
    private function getBaseUrl() {
        $webUrl = \Yii::getAlias('@web');
        $pos = strrpos($webUrl, 'web');
        $baseUrl = '';
        if ($pos >= 0) {
            $baseUrl = substr($webUrl, 0, $pos);
        }
        return $baseUrl;
    }
    
    public function actionView_image($file_id) {
        $baseUrl = $this->getBaseUrl();
        $file = Files::getOneImage($file_id);
        return $this->render('view_image', ['file' => $file, 'baseUrl' => $baseUrl]);
    }
    
    public function actionEdit_image($file_id) {
        $baseUrl = $this->getBaseUrl();
        $file = Files::getOneImage($file_id);
        
        if (\Yii::$app->request->isPost) {
           $file->load(\Yii::$app->request->post());
           $ok = $file->save();
           if ($ok) {
               return $this->redirect(['site/view_image', 'file_id' => $file_id]);
           }
        }
        
        return $this->render('edit_image', ['file' => $file, 'baseUrl' => $baseUrl]);
    }
    
    public function actionDelete_image() {        
        $file_id = \Yii::$app->request->post('file_id');
        $obj = UploadedFiles::deleteFile($file_id);
        $error = '';
        if ($obj['status']) {
            return $this->redirect(['site/index']);
        } else {
            $error = $obj['error'];
        }
        if ($error) {
            Yii::$app->session->setFlash('error', $error);
        }
        $this->redirect(['site/view_image', 'file_id' => $file_id]);
    }
    
    public function actionMultiple_delete() {
        $files = \Yii::$app->request->post('files');
        $obj = UploadedFiles::deleteFiles($files);
        $error = '';
        if ($obj['status']) {
            return $this->redirect(['site/index']);
        } else {
            $error = $obj['error'];
        }
        if ($error) {
            Yii::$app->session->setFlash('error', $error);
        }
        $this->redirect(['site/view_image', 'file_id' => $file_id]);
    }
    
    public function actionRegistration($login = "", $password = "", $password2 = "") {
        $model = new RegistrationForm();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load(\Yii::$app->request->post());
            if ($model->validate()) {
                $usersModel = new Users();
                $usersModel->login = $model->login;
                $usersModel->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                if ($usersModel->save()) {
                    return $this->redirect(array('site/success_registration'));
                }
            }
        }
        return $this->render('registration', ['model' => $model]);
    }
    
    public function actionSuccess_registration() {
        return $this->render('success_registration');
    }
    
    public function actionTest() {
        return $this->render('test');
    }

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login_new', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
