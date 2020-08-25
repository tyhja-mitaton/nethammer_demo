<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $author
 * @property string $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $is_visible
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author', 'text'], 'required'],
            [['text'], 'string'],
            [['is_visible'], 'integer'],
            [['author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего обновления',
            'is_visible' => 'Проверено',
        ];
    }
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'dd.MM.yyyy');
    }
}
