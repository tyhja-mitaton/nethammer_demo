<?php

namespace matodor\chat\models\forms;

use yii\base\Model;

class CreateDialog extends Model
{
    /**
     * @var string
     */
    public $question;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question'], 'string', 'min' => 5, 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return
        [
            'question' => \Yii::t('matodor.chat', 'chat.createdialog.question'),
        ];
    }
}

?>