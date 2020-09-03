<?php

namespace frontend\models;

use Yii;
use common\models\InfoBlock;

/**
 * This is the model class for table "service_price".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property int $service_id
 *
 * @property InfoBlock $service
 */
class ServicePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id'], 'required'],
            [['service_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['text'], 'string'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => InfoBlock::class, 'targetAttribute' => ['service_id' => 'id']],
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
            'service_id' => 'Услуга',
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(InfoBlock::class, ['id' => 'service_id']);
    }
}
