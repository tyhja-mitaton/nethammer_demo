<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use himiklab\sitemap\behaviors\SitemapBehavior;

/**
 * This is the model class for table "info_block".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $btn_name
 * @property int $type
 * @property int $salary
 * @property int $tag
 * @property int $priority
 * @property string|null $imgs
 * @property string|null $intro
 */
class InfoBlock extends \yii\db\ActiveRecord
{
    const MAIN_PAGE_SLIDER = 1;
    const INFO_BLOCK = 2;
    const SERVICE_BLOCK = 3;
    const PRODUCT_BLOCK = 4;
    const CASE_BLOCK = 5;
    const VACANCY_BLOCK = 6;

    //только для кейсов
    const DESIGN = 1;
    const PHOTOGRAPHY = 2;
    const DIGITAL_ARTS = 3;

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
            'seo' => [
                'class' => 'dvizh\seo\behaviors\SeoFields',
            ],
            /*'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function ($model) {
                    $model->select(['url', 'lastmod']);
                    $model->andWhere(['is_deleted' => 0]);
                },
                'dataClosure' => function () {

                    return [
                        'loc' => Url::to($this->url, true),
                        //'lastmod' => strtotime($this->lastmod),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.8
                    ];
                }
            ],*/
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'btn_name', 'type'], 'required'],
            [['description', 'intro'], 'string'],
            [['type', 'salary', 'tag', 'priority'], 'integer'],
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
            'intro' => 'Введение',
            'description' => 'Описание',
            'btn_name' => $this->type === self::MAIN_PAGE_SLIDER ? 'Ссылка' : 'Имя кнопки',
            'type' => 'Тип',
            'salary' => 'Зарплата',
            'tag' => 'Тэг кейса',
            'priority' => 'Приоритет',
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

    public function getTypeLabel()
    {
        $label = '';
        switch ($this->type) {
            case self::MAIN_PAGE_SLIDER: $label = 'слайдер на главной странице';break;
            case self::INFO_BLOCK: $label = 'информационный блок с преимуществами на главной';break;
            case self::SERVICE_BLOCK: $label = 'блок с услугой на странице "Услуги"';break;
            case self::PRODUCT_BLOCK: $label = 'блок с продуктом на странице "Продукты"';break;
            case self::CASE_BLOCK: $label = 'блок на странице "Кейсы"';break;
            case self::VACANCY_BLOCK: $label = 'вакансия на странице "Вакансии"';break;
        }
        return  $label;
    }

    public function getTagLabel()
    {
        $label = '';
        switch ($this->tag) {
            case self::DESIGN: $label = 'Design';break;
            case self::PHOTOGRAPHY: $label = 'Photography';break;
            case self::DIGITAL_ARTS: $label = 'Digital Arts';break;
        }
        return  $label;
    }

    public static function getTags()
    {
        $tags = Tag::find()->asArray()->all();
        $tagsArr = ArrayHelper::map($tags, 'id', 'name');

        return $tagsArr;
    }
}
