<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cert".
 *
 * @property int $id
 * @property string|null $file
 */
class Cert extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['pdf'], 'maxFiles' => 1],
        ];
    }

    public function behaviors()
    {
        return [
            'files' => [
                'class' => 'floor12\files\components\FileBehaviour',
                'attributes' => [
                    'file',
                ],
            ],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Сертификат',
        ];
    }
}
