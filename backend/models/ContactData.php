<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact_data".
 *
 * @property int $id
 * @property string|null $subject
 * @property string $emails
 * @property string $address
 * @property string $phone
 * @property string $vk_link
 * @property string $fb_link
 * @property string $twitter_link
 * @property string $map_link
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
            [['subject', 'emails', 'address', 'phone', 'vk_link', 'fb_link', 'twitter_link', 'map_link', 'tg_link'], 'string', 'max' => 255],
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
            'emails' => 'E-mails (через пробел)',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'vk_link' => 'ВК',
            'fb_link' => 'Facebook',
            'twitter_link' => 'Twitter',
            'map_link' => 'Ссылка на карту',
            'tg_link' => 'Telegram'
        ];
    }

    public function getEmailsArray()
    {
        return explode(' ', trim($this->emails));
    }
}
