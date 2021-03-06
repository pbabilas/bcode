<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		'log',
		'AdminRoutePlugin',
		'DefaultModuleRoutePlugin',
		'EventDispatcher',
	],
	'language' => 'pl',
	'layout' => 'main.tpl',
	'defaultRoute' => 'index/index/index',
	'modules' => [
		'page' => [
			'class' => 'app\module\page\Module',
			'defaultRoute' => 'page/index',
		],
		'dashboard' => [
			'class' => 'app\module\dashboard\Module',
			'defaultRoute' => 'dashboard/index',
		],
		'calendar' => [
				'class' => 'app\module\calendar\Module',
				'defaultRoute' => 'default/index',
		],
		'user' => [
			'class' => 'app\module\user\Module',
			'defaultRoute' => 'user/index',
		],
		'module' => [
			'class' => 'app\module\module\Module',
			'defaultRoute' => 'module/index',
		],
		'index' => [
			'class' => 'app\module\index\Module',
			'defaultRoute' => 'index/index',
		],
		'thumbnailer' => [
			'class' => 'app\module\thumbnailer\Module',
			'defaultRoute' => 'default/create',
		],
		'error' => [
			'class' => 'app\module\error\Module',
			'defaultRoute' => 'error/index',
		]
	],
    'components' => [
		'bundles' => [
			'class' => 'app\assets\BootstrapAsset',
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
			'cache' => [
				'class' => 'yii\caching\FileCache'
			]
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
			'autoRenewCookie' => true,
			'authTimeout' => 3600,
        ],
        'errorHandler' => [
            'errorAction' => 'error/error/index',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
				'file' => [
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
				],
				'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['warning'],
                	],
            ],
        ],
		'EventDispatcher' => [
			'class' => 'app\components\dispatcher\EventDispatcher',
		],
		'AdminRoutePlugin' => [
			'class' => 'app\components\route\AdminPlugin',
		],
		'DefaultModuleRoutePlugin' => [
			'class' => 'app\components\route\DefaultModulePlugin',
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
				'group' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => "@app/module/user/lang",
					'fileMap' => [
						'user' =>'group.php'
					]
				],
				'module' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => "@app/module/module/lang",
					'fileMap' => [
						'module' =>'general.php'
					]
				],
				'dashboard' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => "@app/module/dashboard/lang"
				]
			],
		],
		'urlManager' => [
			'class' => 'app\common\url\Manager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'pictures/<type:\w+>/<size:\w+>/<pictureFilename:.+?>.<extension:\w+>' => 'thumbnailer/create/index',
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
