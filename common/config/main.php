<?php

$mdmAdminPath = 'admin'; // you can change the web url of mdm\yii2-admin to manage rbac.
$rbacDataDir = '/console/rbacdata'; // if you change it, make sure you have created a directory(with write permission) as new path.
$mdmAdminRouteEnabled = true; // or set it false to disable route menu


$mdmAdminRoutePath = null;
if($mdmAdminRouteEnabled){
    $mdmAdminRoutePath = [ 'label' => 'Route' ];
}

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'security' => 'common\controllers\SecurityController',
            ],
            'enableConfirmation' => false, /// change it when necessary.
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
        $mdmAdminPath => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
//            'layout' => 'right-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
//            'layout' => 'top-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'dektrium\user\models\User',
                    'idField' => 'id'
                ]
            ],
            'menus' => [
                'assignment' => [
                    'label' => 'Grand Access' // change label
                ],
                'route' => $mdmAdminRoutePath
            ],
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['admin','editor','client','agent','user'], // here define your roles
            //'authFile' => '/commands/data/rbac.php' //the default path for rbac.php | OLD CONFIGURATION
            'itemFile' =>       dirname(dirname(__DIR__)) . $rbacDataDir . '/items.php', //Default path to items.php | NEW CONFIGURATIONS
            'assignmentFile' => dirname(dirname(__DIR__)) . $rbacDataDir . '/assignments.php', //Default path to assignments.php | NEW CONFIGURATIONS
	    'ruleFile' =>       dirname(dirname(__DIR__)) . $rbacDataDir . '/rules.php', //Default path to rules.php | NEW CONFIGURATIONS
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
        ],
        'wtsecure' => [
            'class' =>  'azraf\simpleapp\classes\SimpleSecurity',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true, // If you want to hide `index.php` from URL, make it false and set a .htaccess file
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // 'db' => 'mydb',  // the application component ID of the DB connection. Defaults to 'db'.
            // 'sessionTable' => 'my_session', // session table name. Defaults to 'session'.
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '//frontend/views/user'
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                        '*' => [
                                'class' => 'yii\i18n\PhpMessageSource',
                                'basePath' => 'common/messages', // if advanced application, set @frontend/messages
                                'sourceLanguage' => 'en',
                                'fileMap' => [
                                        //'main' => 'main.php',
                                ],
                        ],
                ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            $mdmAdminPath.'/*',  // ::: IMPORTANT :::: Make it disable after configuring the USER Roles/Permissions
            'user/index', // add or remove allowed actions to this list
            'user/login', // add or remove allowed actions to this list
            'user/security/login', // add or remove allowed actions to this list
            'user/logout', // add or remove allowed actions to this list
            'user/security/logout', // add or remove allowed actions to this list
            'user/register', // add or remove allowed actions to this list
            'user/registration/register', // add or remove allowed actions to this list
            'user/registration/confirm', // add or remove allowed actions to this list
            'user/registration/resend', // add or remove allowed actions to this list
            'user/registration/connect', // add or remove allowed actions to this list
            'security/login',
            'security/logout',
            
            'site/index',
            'site/about',
            'site/contact',
            'site/signup',
            'site/logout',
            'site/login'
            ]
    ],
];
