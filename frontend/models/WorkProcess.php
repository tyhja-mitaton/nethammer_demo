<?php

namespace frontend\models;

use Yii;
use common\models\InfoBlock;

/**
 * This is the model class for table "work_process".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property string $block1_text
 * @property string $block2_text
 * @property int $service_id
 *
 * @property InfoBlock $service
 */
class WorkProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id'], 'required'],
            [['service_id'], 'integer'],
            [['title', 'block1_text', 'block2_text'], 'string', 'max' => 255],
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
            'block1_text' => 'Блок 1',
            'block2_text' => 'Блок 2',
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
