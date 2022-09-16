<?php

declare(strict_types=1);

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

class Book extends ActiveRecord
{
    public static function collectionName(): string
    {
        return 'book';
    }

    public function attributes(): array
    {
        return ['_id', 'author_id', 'title', 'year', 'summary', 'created_at', 'updated_at'];
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
            [['author_id', 'title', 'year'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['year', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            // [['author_id'], ObjectID::class],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => '_id']],
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['_id' => 'author_id']);
    }

    public function fields(): array
    {
        return [
            '_id',
            'title',
            'year',
            'author' => function () {
                return $this->author->getFullName();
            },
        ];
    }

    public function transformForView(): array
    {
        return [
            '_id' => (string) $this->_id,
            'title' => $this->title,
            'year' => $this->year,
            'summary' => $this->summary,
            'author' => [
                'first_name' => $this->author->first_name,
                'last_name' => $this->author->last_name,
                'date_of_birth' => $this->author->getFormattedDateOfBirth(),
                'biography' => $this->author->biography,
            ],
        ];
    }
}
