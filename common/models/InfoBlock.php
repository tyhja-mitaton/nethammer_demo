<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "info_block".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $btn_name
 * @property int $type
 * @property int $salary
 * @property string|null $imgs
 */
class InfoBlock extends \yii\db\ActiveRecord
{
    const MAIN_PAGE_SLIDER = 1;
    const INFO_BLOCK = 2;
    const SERVICE_BLOCK = 3;
    const PRODUCT_BLOCK = 4;
    const CASE_BLOCK = 5;
    const VACANCY_BLOCK = 6;

    private $_url;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_block';
    }

    public function behaviors()
    {
        return [
            'files' => [
                'class' => 'floor12\files\components\FileBehaviour',
                'attributes' => [
                    'imgs',
                    'avatar'
                ],
            ],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'btn_name', 'type'], 'required'],
            [['description'], 'string'],
            [['type', 'salary'], 'integer'],
            [['title', 'btn_name'], 'string', 'max' => 255],
            ['imgs', 'file', 'extensions' => ['jpg', 'png', 'jpeg', 'gif'], 'maxFiles' => 10],
            ['avatar', 'file', 'extensions' => ['jpg', 'png', 'jpeg', 'gif'], 'maxFiles' => 1],
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
            'description' => 'Описание',
            'btn_name' => $this->type === self::MAIN_PAGE_SLIDER ? 'Ссылка' : 'Имя кнопки',
            'type' => 'Тип',
            'salary' => 'Зарплата',
            'imgs' => 'Изображения',
            'avatar' => 'Аватар'
        ];
    }

    public function getUrl()
    {
        $params = null;
        if ($this->_url === null) {
            switch ($this->type) {
                case self::MAIN_PAGE_SLIDER: $params = ["$this->btn_name"];break;
                case self::INFO_BLOCK: $params = ["site/index"];break;
                case self::SERVICE_BLOCK: $params = ["site/service-page", 'id' => $this->id]; break;
                case self::PRODUCT_BLOCK: $params = ["site/product-page", 'id' => $this->id]; break;
                case self::CASE_BLOCK: $params = ["site/cases"];break;
                case self::VACANCY_BLOCK: $params = ["site/job"];break;
            }
            $this->_url = Url::toRoute($params);
        }

        return $this->_url;
    }
}
