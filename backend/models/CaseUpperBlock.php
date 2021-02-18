<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "case_upper_block".
 *
 * @property int $id
 * @property string|null $text
 */
class CaseUpperBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'case_upper_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
        ];
    }
}
