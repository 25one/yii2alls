<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',

    'basePath' => dirname(__DIR__),
        /*
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                ],
            ],
        ],
        */

    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        //'@webrootimg' => '@webroot/img', //...???ÂÅÐÎßÒÍÎ, ÅÙÅ ÍÅÒ @webroot - ÂÎ view ÓÆÅ ÅÑÒÜ...
    ],

    //'language' => 'en-US', // <- ÍÅ çäåñü - common/config/main.php!
    //'language' => 'ru-RU', // <- ÍÅ çäåñü - common/config/main.php!

    'components' => [

        /*
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/common/messages',
                    //'sourceLanguage' => 'ru-RU',
                    'sourceLanguage' => 'en-US',
                     'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        */


        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@app/console/runtime/queue',
            'as log' => \yii\queue\LogBehavior::class,
        ],


        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'HMJbevTumByYZj1tMLkj6Kp_-IpyX-n6',
            'baseUrl' => '',   //...!!!@app - ÓÁÐÀÒÜ web...

            'parsers' => [
               'application/json' => 'yii\web\JsonParser',  //...???ÍÀËÈ×ÈÅ ÝÒÎÃÎ ÄËß RESTful API ÒÈÏÀ ÍÅ ÏÎÍßÒÍÎ(È ÒÀÊ ÒÈÏÀ json)...
            ]

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'keyPrefix' => 'surprisenew', // óíèêàëüíûé ïðåôèêñ êëþ÷åé êýøà
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            //'errorAction' => 'site/error',
            'errorAction' => 'site/myviewerror', //...!!!ÍÎ actionMyviewerror Â SiteController.php + myviewerror.php Â views/site
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            'useFileTransport' => false,
            'htmlLayout' => 'layouts/html',
            //'viewPath' => '@app/mail',
            /*
           'messageConfig' => [
               'charset' => 'UTF-8',
               //...
            ],
            */
            'transport' => [
               'class' => 'Swift_SmtpTransport',
               'host' => 'mail.ukraine.com.ua',
               'username' => 'noreply@25one.com.ua',
               //'password' => 'tarzan33',
               'password' => '04o2E7sGRaBk',
               'port' => '587',
               'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['klisl'],  //...ÇÀÌÅÐ ÏÐÎÈÇÂÎÄÈÒÅËÜÍÎÑÒÈ...
                    'levels' => ['error', 'warning'],
                    //'levels' => ['error', 'warning', 'profile'],
                ],
            ],
        ],
        'db' => $db,

        //'myhelper' => [
        //   'class' => 'app\components\MyHelper',  //...!!!ÌÎÉ ÊÎÌÏÎÍÅÍÒ... - ÈËÈ Â componets - !!!À ÏÎ ÑÓÒÈ - È ÍÅ ÍÓÆÍÎ - È ÒÀÊ ÌÎÆÍÎ use È ÂÛÇÂÀÒÜ...
	    //],

        //'myclass' => [
        //   'class' => 'app\components\MyClass',  //...!!!ÌÎÉ ÊÎÌÏÎÍÅÍÒ - ???ÒÈÏÀ ÄËß getLabel(setLabel) ÍÓÆÍÎ...
	    //],                                       //...!!!ÝÒÎ ÁÛËÀ ÍÀÑÒÐÎÉÊÀ ÄËß web.php - ÅÑËÈ ÒÀÌ ÇÀÊÎÌÅÍÒÈËÈ (ÀËÜÒÅÐÍÀÒÈÂÀ - ServiceLocator)...
                                                   //...!!!ÀËÜÒÅÐÍÀÒÈÂÀ Â ÑÀÌÎÌ index.php...
        //'DependClass' => [
        //   'class' => 'app\components\DependClass',  //...ÏÐßÌÎ Â Dependency Injection Container...
	    //],


        /*
        'foo' => [
           'class' => 'app\components\Foo',  //...!!!ÌÎÉ ÊÎÌÏÎÍÅÍÒ - ??ÒÈÏÀ ÍÅ ÍÓÆÍÎ...
	    ],
        */


        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => false,  //...???ÍÀËÈ×ÈÅ ÝÒÎÃÎ ÄËß RESTful API ÒÈÏÀ ÍÅ ÏÎÍßÒÍÎ...
            'showScriptName' => false,
            'rules' => [

            '/' => 'mylogin/index',

            'login' => 'mylogin/login',
            'ajaxspecialvalidation' => 'mylogin/ajaxspecialvalidation',
            'surprisenew-lead-update-select' => 'mylogin/surprisenew-lead-update-select',
            'surprisenew-lead-update-save' => 'mylogin/surprisenew-lead-update-save',
            'select-language' => 'mylogin/select-language',
            'mailer' => 'mylogin/mailer',
            //'<action:[-\w]+>' => 'mylogin/<action>',    //...???ÄËß RESTful API ÒÈÏÀ ÍÅ ÏÎÉÄÅÒ - ÏÐÈÄÅÒÑß ÂÑÅ ÏÅÐÅ×ÈÑËÈÒÜ(ÂÛØÅ)...

            ['class' => 'yii\rest\UrlRule', 'controller' => 'country'],  //...???ÍÀËÈ×ÈÅ ÝÒÎÃÎ ÄËß RESTful API ÒÈÏÀ ÍÅ ÏÎÍßÒÍÎ...

            ['class' => 'yii\rest\UrlRule', 'controller' => 'restv1/country'],
            ['class' => 'yii\rest\UrlRule', 'controller' => 'restv2/country'],

            'tree' => 'tree/index',
            'autoloadhook' => 'tree/autoloadhook',
            'addupdateremovehook' => 'tree/addupdateremovehook',

            //...house...
            'core' => 'core/index',
            'fromcore' => 'core/fromcore',
            //...house...

            //...cartree...
               'cartree/' => 'cartree/index',
               'ajax-select' => 'cartree/ajax-select',
            //...cartree...

            //...worker...

               //'/' => 'worker/listworkers',
               'worker/' => 'worker/listworkers',
               'worker' => 'worker/listworkers',
               'removeworker' => 'worker/removeworker',
               //...en...
               'workers' => 'workers/listworkers', 
               'removeworkers' => 'workers/removeworker',
               //...en...
               'listworkers' => 'worker/listworkers',
 
               'upload' => 'upload/index',
            //...worker...

            ],
        ],

        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && !empty(Yii::$app->request->get('suppress_response_code'))) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },

        ],

    'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [  // ...!!!ÑÂÎÉ Jquery...
                    'sourcePath' => null,   // íå îïóáëèêîâûâàòü êîìïëåêò
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
            ],
        ],

    ],

    //...!!!delete http.../
    'on beforeRequest' => function () {
        $pathInfo = Yii::$app->request->pathInfo;
        $query = Yii::$app->request->queryString;
        if (!empty($pathInfo) && substr($pathInfo, -1) === '/') {
            $url = '/' . substr($pathInfo, 0, -1);
            if ($query) {
                $url .= '?' . $query;
            }
            Yii::$app->response->redirect($url, 301)->send();
        }
    },
    //...!!!delete http.../

    'params' => $params,

    /*
    'modules' => [
        'forum' => [
            'class' => 'app\modules\forum\Module',
            // ... äðóãèå íàñòðîéêè ìîäóëÿ ...
        ],
    ],
    */

    'modules' => [
        'restv1' => [
            'class' => 'app\modules\restv1\Module',
        ],
        'restv2' => [
            'class' => 'app\modules\restv2\Module',
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

//define(YII_ENABLE_ERROR_HANDLER, false);

return $config;
