<?php
namespace athos99\plupload;
use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@athos99/plupload/assets';
    public $depends = array(
        'yii/bootstrap',
    );

}
