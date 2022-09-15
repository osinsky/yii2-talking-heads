<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

class Author extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'author';
    }

    public function attributes(): array
    {
        return ['_id', 'first_name', 'last_name', 'date_of_birth', 'biography', 'created_at', 'updated_at'];
    }

    /**
     * @return array<string>
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'date_of_birth'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['date_of_birth', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['author_id' => '_id']);
    }

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function fields()
    {
        return [
            '_id',
            'first_name',
            'last_name',
            'date_of_birth' => [$this, 'getFormattedDateOfBirth'],
        ];
    }

    public function getFormattedDateOfBirth()
    {
        return Yii::$app->formatter->asDate($this->date_of_birth, 'yyyy.MM.dd');
    }

    public function transformForView()
    {
        $books = array_map(fn ($item) => ['title' => $item->title, 'year' => $item->year], $this->books);

        return [
            '_id' => (string) $this->_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->getFormattedDateOfBirth(),
            'books' => $books,
        ];
    }
}
