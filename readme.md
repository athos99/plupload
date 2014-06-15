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
