<?php
namespace athos99\plupload;
use yii\web\AssetBundle;

class PluploadAsset extends AssetBundle
{
    public $sourcePath = '@vendor/athos99/plupload/assets';
    public $css = [
        'plupload.css',
    ];
    public $depends = [
        'athos99\plupload\Asset',
    ];
}
