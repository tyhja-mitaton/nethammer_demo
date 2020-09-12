<?php

namespace matodor\chat\models\forms;

use yii\base\Model;

class SetInfo extends Model
{
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email'], 'required'],
            [['email'], 'email'],
            [['firstName', 'lastName'], 'string', 'min' => 2, 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return
        [
            'firstName' => \Yii::t('matodor.chat', 'chat.setinfo.firstName'),
            'lastName' => \Yii::t('matodor.chat', 'chat.setinfo.lastName'),
            'email' => \Yii::t('matodor.chat', 'chat.setinfo.email'),
        ];
    }
}

?>