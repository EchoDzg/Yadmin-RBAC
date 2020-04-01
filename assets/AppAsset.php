<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use app\services\UrlService;
/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     /*
    public $css = [
        '/x-admin/css/font.css',
        '/x-admin/css/xadmin.css',
    ];
    public $js = [
        '/x-admin/js/xadmin.js',
        '/x-admin/lib/layui/layui.js',
    ];

   
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    */

    //重写 registerAssetFiles 方法
    public function registerAssetFiles( $view ){
        $release = '0.1';

        $this->css = [
            UrlService::buildUrl('/x-admin/css/font.css',['v'=>  $release ]),
            UrlService::buildUrl('/x-admin/css/xadmin.css',['v'=>  $release ]),    
        ];

        $this->js = [
            UrlService::buildUrl('/x-admin/lib/layui/layui.js',['v'=>  $release ]),    
            UrlService::buildUrl('/x-admin/js/xadmin.js',['v'=>  $release ]),
        ];

        parent::registerAssetFiles( $view );
    }

}
