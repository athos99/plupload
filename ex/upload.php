<?php
use \yii\helpers\Html;
echo Html::beginForm();
echo athos99\plupload\PluploadWidget::widget([]);
echo Html::submitButton();
echo Html::endForm();
