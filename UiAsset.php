<?php
namespace athos99\plupload;
use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@app/extensions/plupload/assets';
    public $depends = array(
        'yii/jui/theme/base/progressbar',
        'yii/jui/progressbar',
    );
}
