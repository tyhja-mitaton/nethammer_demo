<?php
namespace common\helpers;

use Yii;
use yii\helpers\StringHelper;

class Helpers
{
    public static function isEmpty($value)
    {
        return
            $value === '' ||
            $value === [] ||
            $value === null ||
            is_string($value) && trim($value) === '';
    }

    /**
     * @param string $userAgent
     * @return bool
     */
    public static function userIsBot($userAgent)
    {
        if (static::isEmpty($userAgent)) {
            return false;
        }

        $botsList = [
            'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot','YandexDirectDyn',
            'YandexScreenshotBot', 'YandexImages', 'YandexVideo', 'YandexVideoParser',
            'YandexMedia', 'YandexBlogs', 'YandexFavicons', 'YandexWebmaster',
            'YandexPagechecker', 'YandexImageResizer','YandexAdNet', 'YandexDirect',
            'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
            'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus',
            'YandexMarket', 'YandexVertis', 'YandexForDomain', 'YandexSpravBot',
            'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB', 'YandexOntoDBAPI',
            'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google',
            'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves',
            'OmniExplorer_Bot', 'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!',
            'Ezooms', '', 'Tourlentabot', 'MJ12bot', 'AhrefsBot', 'SearchBot', 'SiteStatus',
            'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks',
            'proximic', 'OpenindexSpider','statdom.ru', 'Exabot', 'Spider', 'SeznamBot',
            'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti',
            'DomainVader', 'DCPbot', 'PaperLiBot', 'Postman'
        ];

        foreach($botsList as $name) {
            if (stripos($userAgent, $name) !== false) {
                return true;
            }
        }

        return false;
    }
}
