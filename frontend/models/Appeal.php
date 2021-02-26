<?php

namespace frontend\models;

use udokmeci\yii2PhoneValidator\PhoneValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\captcha\CaptchaAction;
use yii\validators\EmailValidator;

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
            [['author'], 'string', 'max' => 255],
            [['phone'], 'validatePhoneOrEmail'],
            [['verifyCode'], 'codeVerify'],
        ];
    }

    /**
     * @param $attribute
     *
     * @noinspection PhpUnused
     */
    public function codeVerify($attribute)
    {
        $captchaValidate  = new CaptchaAction('captcha', Yii::$app->controller);

        if ($this->$attribute) {
            $code = $captchaValidate->getVerifyCode();

            if ($this->$attribute != $code) {
                $this->addError($attribute, 'Код проверки некорректен');
            }
        }
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

    /**
     * @noinspection PhpUnused
     */
    public function validatePhoneOrEmail()
    {
        $validEmail = (new EmailValidator())->validate($this->phone);

        if (!$validEmail) {
            (new PhoneValidator([
                'countryAttribute' => 'country_code',
                'strict' => true,
                'format' => true,
            ]))->validateAttribute($this, 'phone');
        }

        if ($this->hasErrors('phone')) {
            $this->clearErrors('phone');
            $this->addError('phone', 'Некорректный E-mail или телефон');
            return false;
        }

        return true;
    }
}
