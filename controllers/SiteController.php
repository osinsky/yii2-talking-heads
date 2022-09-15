<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\ContactForm;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\mongodb\Query;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
    public function actionIndex()
    {
        $book = Book::find()->one();

        var_dump($book->author->getFullName());
        exit;

        // $author = Author::find()->where(['first_name' => 'Linda'])->one();

        // $book = new Book();
        // $book->author_id = $author->_id;
        // $book->title = 'Excepteur aliquip ipsum voluptate officia excepteur non adipisicing minim esse minim cillum nostrud.';
        // $book->year = 2022;
        // $result = $book->save();

        // var_dump($result);
        // var_dump($book->getErrors());

        // $author = new Author();
        // $author->first_name = ' Linda ';
        // $author->last_name = ' Trevino ';
        // $author->date_of_birth = mktime(0, 0, 0, 5, 25, 1982);
        // $result = $author->save();
        // var_dump($result);
        // var_dump($author);
        // $query = new Query();
        // // compose the query
        // $query->select(['name', 'status'])
        //     ->from('author')
        //     ->limit(10);
        // // execute the query
        // $rows = $query->all();

        return $this->render('index');
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

        return $this->render('login', [
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
