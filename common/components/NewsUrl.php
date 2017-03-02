<?php

namespace common\components;

use common\models\News;
use yii\web\UrlRule;

class NewsUrl extends UrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'site/newsview' && isset($params['id']))
        {   
            return $params['id'];            
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $url = $request->getPathInfo();
        $params['id'] = News::find()->where(['alias' => $url])->one();        
        if (isset($params['id'])) {
            return ['site/newsview', $params];
        }
        else {
            return false;
        }
    }
}