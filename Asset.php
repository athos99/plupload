<?php

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@app/extensions/plupload/assets';
    public $css = array(
        'style.css',
    );
    public $js = array(
        'modules.plupload.js',
        'moxie.js',
        'plupload.dev.js',
    );
    public $depends = array(
        'yii\web\JqueryAsset'
    );

}
