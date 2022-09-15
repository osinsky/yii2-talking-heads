<?php

declare(strict_types=1);

namespace app\commands;

use app\models\Author;
use app\models\Book;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

class MyFixtureController extends Controller
{
    public function actionIndex(): int
    {
        Author::deleteAll();
        Book::deleteAll();

        $authors = require __DIR__ . '/../tests/unit/fixtures/data/author.php';
        foreach ($authors as $author) {
            $model = new Author();
            $model->load(['Author' => $author]);
            $model->save();
        }

        $authorIds = array_map(fn ($x) => $x, ArrayHelper::getColumn(Author::find()->all(), '_id'));
        $authorsCount = count($authorIds);

        $books = require __DIR__ . '/../tests/unit/fixtures/data/book.php';
        foreach ($books as $book) {
            $model = new Book();
            $model->load(['Book' => $book]);
            $randomIndex = rand(0, $authorsCount - 1);
            $model->author_id = $authorIds[$randomIndex];
            $result = $model->save();
            var_dump($result);
            var_dump($model->getErrors());
        }

        return ExitCode::OK;
    }
}
