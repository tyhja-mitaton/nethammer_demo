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
    //public $logo;//картинка сохраняется при обнавлении только когда поле непосредственно в бд
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
            'files' => [
                'class' => 'floor12\files\components\FileBehaviour',
                'attributes' => [
                    'logo'
                ],
            ],
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
            ['dateTime', 'date', 'format' => 'php:d.m.Y'],
            ['logo', 'file', 'extensions' => ['jpg', 'png', 'jpeg', 'gif'], 'maxFiles' => 1],
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
            'dateTime' => 'Дата',
            'logo' => 'Логотип'
        ];
    }
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'dd.MM.yyyy');
    }

    public function getDateTime()
    {
        return $this->created_at ? date('d.m.Y', $this->created_at) : '';
    }

    public function setDateTime($date)
    {
        $this->created_at = $date ? strtotime($date) : null;
    }

}
