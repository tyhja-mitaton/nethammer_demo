<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "info_block".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $btn_name
 * @property int $type
 * @property string|null $imgs
 */
class InfoBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'btn_name', 'type'], 'required'],
            [['description'], 'string'],
            [['type'], 'integer'],
            [['title', 'btn_name', 'imgs'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'btn_name' => 'Btn Name',
            'type' => 'Type',
            'imgs' => 'Imgs',
        ];
    }
}
