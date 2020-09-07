<?php


namespace frontend\models;


use common\models\InfoBlock;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class Sitemap extends Model
{
    public function getUrl()
    {
        $urls = array();
        $url_info_blocks = InfoBlock::find()->all();
        foreach ($url_info_blocks as $url_info_block) {
            $url = $url_info_block->url;
            $urls[] = array($url, 'daily');
        }
        $arr_stat_page = ['/', '/services', '/products',
            '/reviews', '/contact'];
        foreach ($arr_stat_page as $url_stat){
            $urls[] = array($url_stat, 'daily');
        }
        return $urls;
    }
    //Формирует XML файл, возвращает в виде переменной
    public function getXml($urls){
        $host = Yii::$app->request->hostInfo; // домен сайта
        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        $xmaldata = ob_get_clean();
        ob_start();
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xmaldata .= ob_get_clean();
        ob_start();
        echo'<url><loc>'.$host.'</loc><changefreq>daily</changefreq><priority>1</priority></url>';
        $xmaldata .= ob_get_clean();
            foreach($urls as $url) {
                ob_start();
                echo '<url><loc>'.$host.$url[0].'</loc><changefreq>'.$url[1].'</changefreq></url>';
                $xmaldata .= ob_get_clean();
            }
        ob_start();
        echo '</urlset>';
        $xmaldata .= ob_get_clean();

        return $xmaldata;
    }

    //Возвращает XML файл
    public function showXml($xml_sitemap){
        // устанавливаем формат отдачи контента
        Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //повторно т.к. может не сработать
        header("Content-type: text/xml");
        echo $xml_sitemap;
        Yii::$app->end();
    }

}