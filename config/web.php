<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'EventDispatcher'],
	'language' => 'pl',
	'layout' => 'main.tpl',
	'defaultRoute' => 'page/default',
	'modules' => [
		'page' => [
			'class' => 'app\module\page\Module',
			'defaultRoute' => 'default',
		],
		'dashboard' => [
			'class' => 'app\module\dashboard\Module',
			'defaultRoute' => 'default/index',
		],
		'user' => [
			'class' => 'app\module\user\Module',
			'defaultRoute' => 'default/login',
		],
		'error' => [
			'class' => 'app\module\error\Module',
			'defaultRoute' => 'default/error',
		],
	],
    'components' => [
		'bundles' => [
			'class' => 'app\assets\BootstrapAsset',
		],
		'authManager' => [
			'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
		],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zm_n4nElFyPZ3OIZcYmPdfqwmWFCS-IA',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\module\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
		'EventDispatcher' => [
			'class' => 'app\components\dispatcher\EventDispatcher',
		],
		'i18n' => [
			'translations' => [
				'page' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => "@app/module/page/lang",
					'fileMap' => [
						'page' =>'general.php'
					]
				],
				'user' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => "@app/module/user/lang",
					'fileMap' => [
						'user' =>'general.php'
					]
				],
			]
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'admin' => 'dashboard/default-admin/',
				'admin/<module:\w+>/<action:\w+>' => '<module>/default-admin/<action>',
				'admin/<module:\w+>' => '<module>/default-admin/',
				'<module:\w+>/<action:\w+>' => '<module>/default/<action>',
				'<module:\w+>' => '<module>/admin/',
//				'<module:\w+>/<controller:\w+>-admin/<route:\w+>' => 'site/error',
//				'<module:\w+>/<controller:\w+>-admin/' => 'site/error',
//				'<module:\w+>/<controller:\w+>-admin' => 'site/error',
			]

		],
		'view' => [
			'renderers' => [
				'tpl' => [
					'class' => 'yii\smarty\ViewRenderer',
					'cachePath' => '@runtime/Smarty/cache',
				],
			],
		],
        'db' => require(__DIR__ . '/db.php'),
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
