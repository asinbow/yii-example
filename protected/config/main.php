<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'language'=>'en',
    //'language'=>'zh_cn',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                // REST API
                array('api/list', 'pattern'=>'api/<controller:\w+>', 'verb'=>'GET'),
                array('api/view', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'GET'),
                array('api/update', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'PUT'),
                array('api/delete', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'DELETE'),
                array('api/create', 'pattern'=>'api/<controller:\w+>', 'verb'=>'POST'),

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        'viewRenderer'=>array(
            'class'=>'application.extensions.ESmartyViewRenderer',
            'fileExtension' => '.tpl',
            //'pluginsDir' => 'application.smartyPlugins',
            //'configDir' => 'application.smartyConfig',
            //'prefilters' => array(array('MyClass','filterMethod')),
            //'postfilters' => array(),
            //'config'=>array(
            //    'force_compile' => YII_DEBUG,
            //   ... any Smarty object parameter
            //)
        ),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=asinbow_test',
			'emulatePrepare' => true,
			'username' => 'asinbow',
			'password' => 'ancuist`12',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
