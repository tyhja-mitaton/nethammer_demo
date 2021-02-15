<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\validators\RegularExpressionValidator;

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
    const EMAIL = 'email';
    const PHONE = 'phone';
    public $verifyCode;
    public $country_code = 'RU';
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
            [['author'], 'required', 'message' => 'Необходимо заполнить поле "Имя"'],
            [['phone'], 'required', 'message' => 'Необходимо заполнить поле "E-mail или телефон"'],
            //[['email'], 'required', 'message' => 'Необходимо заполнить поле "E-mail"'],
            [['author'], 'string', 'max' => 255],
            ['phone', 'email', 'on' => self::EMAIL, 'message' => 'Некорректный email или телефон'],
            ['phone', 'udokmeci\yii2PhoneValidator\PhoneValidator', 'countryAttribute'=>'country_code','strict'=>false,'format'=>true, 'on' => self::PHONE],
            //['email', 'email'],
            ['verifyCode', 'captcha'],
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
            //'email' => 'E-mail',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'verifyCode' => 'Код подтверждения',
        ];
    }

    public function sendEmail($email, $contactData, $appeal)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom('latter@nethammer.ru')
            ->setSubject($contactData->subject)
            ->setTextBody($appeal->author.' '.$appeal->phone)
            ->send();
    }

    public function beforeValidate()
    {
        if(is_numeric($this->phone)){
            $this->scenario = self::PHONE;
        }else{
            $this->scenario = self::EMAIL;
        }
        return parent::beforeValidate();
    }
}
