<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "extra_block".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string|null $btn_name
 * @property string|null $btn_link
 * @property string|null $img
 */
class ExtraBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'extra_block';
    }

    public function behaviors()
    {
        return [
            'files' => [
                'class' => 'floor12\files\components\FileBehaviour',
                'attributes' => [
                    'img',
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
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title', 'btn_name', 'btn_link'], 'string', 'max' => 255],
            ['img', 'file', 'extensions' => ['jpg', 'png', 'jpeg', 'gif'], 'maxFiles' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'btn_name' => 'Текст кнопки',
            'btn_link' => 'Ссылка кнопки',
            'img' => 'Изображение',
        ];
    }
}
