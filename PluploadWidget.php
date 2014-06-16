<?php
namespace athos99\plupload;

use yii;
use yii\web\View;


class PluploadWidget extends yii\base\Widget
{

    public $urlUpload = null;
    public $multipart_params = array();
    public $data;
    public $baseStyle = 'plupload'; // null, 'plupload','bootstrap' or 'ui'

    public $progressClass = '';
    public $progressOkClass = '';
    public $progressErrorClass = '';
    public $barClass = '';


    public function init()
    {
        if ($this->urlUpload === null) {
            $this->urlUpload = \yii::$app->getUrlManager()->createUrl('/' . \yii::$app->controller->id . '/upload');
        }
        switch ($this->baseStyle) {
            case 'plupload' :
                $this->progressClass = '';
                $this->progressOkClass = 'plupload-ok';
                $this->progressErrorClass = 'plupload-error';
                $this->barClass = '';
                break;
            case 'bootstrap' :
                $this->progressClass = 'progress progress-striped';
                $this->progressOkClass = 'progress progress-success';
                $this->progressErrorClass = 'progress progress-danger';
                $this->barClass = 'bar';
                break;
            case 'ui' :
                $this->progressClass = 'ui-progressbar ui-widget ui-widget-content ui-corner-all';
                $this->progressOkClass = 'progress progress-striped';
                $this->progressErrorClass = 'progress progress-danger';
                $this->barClass = "ui-progressbar-value ui-widget-header ui-corner-left ui-progressbar-overlay";
                break;
            default:
                $this->baseStyle = null;
        }

        $this->getId(true);
        \yii::$aliases['@plupload'] = dirname(__FILE__);
        $view = $this->getView();
        $view->registerAssetBundle('athos99\plupload\Asset');
        $view->registerAssetBundle('athos99\plupload\\' . $this->baseStyle . 'Asset');
        $am = $view->getAssetManager();
        $bundle = $am->getBundle('athos99\plupload\Asset');
        $urlAsset = $bundle->baseUrl;
        $request = \Yii::$app->getRequest();
        if ($request->enableCsrfValidation) {
            $this->multipart_params[$request->csrfParam] = $request->getCsrfToken();
        }

        $pluploadOptions = array(
            'browse_button' => 'plupload-browse-button',
            'container' => 'plupload-container',
            'chunks' => array('size' => '400kb', 'send_chunk_number' => true),
//            'chunk_size' => '400kb',
            'drop_element' => 'plupload-container',
            'file_data_name' => 'file',
            'filters' => array(array('title' => 'Image files', 'extensions' => 'jpg,gif,png')),
            'flash_swf_url' => $urlAsset . '/xMoxie.swf',
//     'headers'=>
            'max_file_size' => '30mb',
            'multipart' => true,
            'multipart_params' => $this->multipart_params,
            'multi_selection' => true,
// 'resize'=>
//            'runtimes' => 'html5',
            'runtimes' => 'gears,browserplus,html5,silverlight,flash,html4',
// 'required_features'=>
            'silverlight_xap_url' => $urlAsset . '/Moxie.xap',
            'url' => $this->urlUpload,
            'urlstream_upload' => true,
        );

        $transferOptions = array(
            'progressOkClass' => 'plupload-progress ' . $this->progressOkClass,
            'progressErrorClass' => 'plupload-progress ' . $this->progressErrorClass,
        );


        $view->registerJs(
            'var modules=modules||{};modules.plupload.options=' . json_encode(array('plupload' => $pluploadOptions, 'transfer' => $transferOptions)) . ';',
            View::POS_END);
    }

    public function renderHTML()
    {

        if (is_array($this->data))
            echo PHP_EOL;
            foreach ($this->data as $key => $data) {
                echo  yii\helpers\Html::hiddenInput($key, $data).PHP_EOL ;
            }
        ?>
        <div class="plupload">
            <div id="plupload-container" class="plupload-drop-zone">
                <div class="plupload-drop-zone-inside">
                    <div class="plupload-drop-zone-info">Drop files here</div>
                    <div class="plupload-drop-zone-button">
                        <button id="plupload-browse-button">Select Files</button>
                    </div>
                </div>
            </div>

            <div class="plupload-transfer-zone transfer-size1">
                <div class="plupload-transfer" style="display:none">
                    <div>
                        <input type="hidden" class="plupload-input-name" name="file[]">

                        <div class="plupload-image"><img></div>
                        <div class="plupload-progress <?php echo $this->progressClass ?>">
                            <div class="plupload-bar <?php echo $this->barClass ?>" style="width:0"></div>
                        </div>
                        <div class="plupload-name"></div>
                        <div class="plupload-size"></div>
                        <div class="plupload-error-msg"></div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>

        </div>
    <?php
    }


    public
    function run()
    {
        $this->renderHTML();
    }
}



