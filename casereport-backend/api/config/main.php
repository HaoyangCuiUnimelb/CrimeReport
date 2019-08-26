<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'urlManager'=>[
            'enablePrettyUrl'=>true,
            'enableStrictParsing' => true,
            'showScriptName'=>false,
            //'suffix'=>'.html',
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'extraPatterns'=>[
                        'POST login'=>'login',
                        'POST reg'=>'reg',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'post',
                    'extraPatterns'=>[
                        'POST new'=>'new',
                        'POST    upload' => 'upload',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'tag',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
