<?php
namespace athos99\plupload;
use yii\web\AssetBundle;

class UiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/athos99/plupload/assets';
    public $depends = array(
        'yii/jui/theme/base/progressbar',
        'yii/jui/progressbar',
    );
}
