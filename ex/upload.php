<?php
use \yii\helpers\Html;
echo Html::beginForm();
echo app\extensions\plupload\PluploadWidget::widget(array());
echo Html::submitButton();
echo Html::endForm();
