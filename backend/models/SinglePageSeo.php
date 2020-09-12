<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "single_page_seo".
 *
 * @property int $id
 * @property int $type
 */
class SinglePageSeo extends \yii\db\ActiveRecord
{
    const MAIN_PAGE_SEO = 1;
    const PRODUCTS_PAGE_SEO = 2;
    const SERVICES_PAGE_SEO = 3;
    const CASES_PAGE_SEO = 4;
    const JOB_PAGE_SEO = 5;
    const REVIEWS_PAGE_SEO = 6;
    const CONTACT_PAGE_SEO = 7;

    public function behaviors()
    {
        return [
            'seo' => [
                'class' => 'dvizh\seo\behaviors\SeoFields',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'single_page_seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    public static function getTitle($type)
    {
        $title = '';
        switch ($type) {
            case self::MAIN_PAGE_SEO: $title = 'главной страницы';break;
            case self::PRODUCTS_PAGE_SEO: $title = 'страницы списка продуктов';break;
            case self::SERVICES_PAGE_SEO: $title = 'страницы списка услуг';break;
            case self::CASES_PAGE_SEO: $title = 'страницы кейсов';break;
            case self::JOB_PAGE_SEO: $title = 'страницы вакансий';break;
            case self::REVIEWS_PAGE_SEO: $title = 'страницы отзывов';break;
            case self::CONTACT_PAGE_SEO: $title = 'страницы контактов';break;
        }
        return $title;
    }

    public static function getViewPath($type)
    {
        $path = '';
        switch ($type) {
            case self::MAIN_PAGE_SEO: $path = 'single-seo-main';break;
            case self::PRODUCTS_PAGE_SEO: $path = 'single-seo-products';break;
            case self::SERVICES_PAGE_SEO: $path = 'single-seo-services';break;
            case self::CASES_PAGE_SEO: $path = 'single-seo-cases';break;
            case self::JOB_PAGE_SEO: $path = 'single-seo-job';break;
            case self::REVIEWS_PAGE_SEO: $path = 'single-seo-reviews';break;
            case self::CONTACT_PAGE_SEO: $path = 'single-seo-contacts';break;
        }
        return $path;
    }
}
