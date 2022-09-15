<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class AuthorController extends ActiveController
{
    public $modelClass = 'app\models\Author';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['view'] = [
            'class' => 'app\actions\AuthorViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Author::find(),
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_ASC,
                ],
            ],
        ]);
    }

    public function actionStatistic()
    {
        $authors = Author::find()->orderBy(['first_name' => SORT_ASC, 'last_name' => SORT_ASC])->all();

        return array_map(fn ($item) => [
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'books_count' => count($item->books),
        ], $authors);
    }
}
