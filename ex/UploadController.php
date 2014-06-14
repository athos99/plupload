<?php
namespace app\controllers\admin;
use \yii;
use \yii\web\Controller;


class UploadController extends Controller
{
    public function downloaded($x) {
        $a=$x;
        return mt_rand(0,1)==0;
    }

    public function actionUpload() {
        \yii::$app->getComponent('uploadManager')->run();

    }

    public function actionIndex()
    {
        return $this->render('//admin/upload');
    }






}


