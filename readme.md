The sass and less files are converted with PHP librairies
Only for YII2 upload file with PLUpload library

Plupload - Cross browser and platform uploader API
===================================================

What is Plupload
-----------------
Plupload is a JavaScript API for dealing with file uploads it supports features like multiple file selection, file type filtering,
request chunking, client side image scaling and it uses different runtimes to achieve this such as HTML 5, Silverlight, Flash, Gears and BrowserPlus.

##Requirements

YII 2.0

##Installation and configuration
### installation
This package is install by composer, in your composer.json add :
 ~~~
    "require": {
        ....
        "athos99/plupload": "*"
        .....
        }
 ~~~


### configuration

Add assetManager components definition in your YII configuration file {app}/config/web.php


~~~
[php]
   'components' => [
        ....
         'uploadManager' => [
            'class' => 'athos99\plupload\PluploadManager'
                   ],
        ],
        ...



~~~

'Force'=>true : If you want convert your sass each time without time dependency

The sass files with extension .sass are converted to a .css file
The less files with extension .less are converted to a .css file
The scss file with extension .scss are converted to a .css file


Example of assets config file /protected/config/assets.php


~~~
[php]
<?php

return array(
	'app' => array(
		'basePath' => '@wwwroot',
		'baseUrl' => '@www',
		'css' => array(
			'css/bootstrap.min.css',
			'css/bootstrap-responsive.min.css',
			'css/site.css',
            'css/less_style.less',
            'css/sass_style.sass',
		),
		'js' => array(

		),
		'depends' => array(
			'yii',
		),
	),
);

~~~



##Resources

