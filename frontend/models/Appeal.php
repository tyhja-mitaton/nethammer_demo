<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "appeal".
 *
 * @property int $id
 * @property string $author
 * @property string $phone
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Appeal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appeal';
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
            [['author', 'phone'], 'required'],
            [['author', 'phone'], 'string', 'max' => 255],
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
            'phone' => 'Телефон',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    public function sendEmail($email, $contactData, $appeal)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom($appeal->author)
            ->setSubject($contactData->subject)
            ->setTextBody($appeal->phone)
            ->send();
    }
}