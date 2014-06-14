<?php
use \yii\helpers\Html;
echo Html::beginForm();
echo athos99\plupload\PluploadWidget::widget(array());
echo Html::submitButton();
echo Html::endForm();
