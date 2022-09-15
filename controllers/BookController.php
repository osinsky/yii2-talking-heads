<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class BookController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['view'] = [
            'class' => 'app\actions\BookViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Book::find(),
            'sort' => [
                'defaultOrder' => [
                    'year' => SORT_ASC,
                ],
            ],
        ]);
    }
}
