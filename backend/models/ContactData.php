<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact_data".
 *
 * @property int $id
 * @property string|null $subject
 * @property string $emails
 */
class ContactData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'emails'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Тема',
            'emails' => 'E-mails',
        ];
    }

    public function getEmailsArray()
    {
        return explode(' ', $this->emails);
    }
}
