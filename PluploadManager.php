<?php
namespace athos99\plupload;

class PluploadManager extends \yii\base\Component
{
    public $targetDir = '@runtime/plupload';
    public $cleanupTargetDir = true;
    public $maxFileAge = 18000; // Temp file age in seconds
    public $fileName;

    protected $_chunk;
    protected $_chunks;
    protected $_fileName;
    protected $_contentType;

    public $_filePath;

    public function init()
    {
        parent::init();
        $this->targetDir = \Yii::getAlias($this->targetDir);
        if (!is_dir($this->targetDir)) {
            mkdir($this->targetDir, 0777, true);
        }
    }

    public function cleanFileName($file)
    {
        $file = str_replace(array_keys(\yii\helpers\Inflector::$transliteration), \yii\helpers\Inflector::$transliteration, $file);
        $map = [
                '/[^\w\s.-_]/' => ' ',
                '/\\s+/' => '-',
            ];
        return preg_replace(array_keys($map), array_values($map), $file);
    }

    public function run()
    {
        // Get parameters
        $this->_chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $this->_chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $this->fileName = $this->cleanFileName(isset($_REQUEST["name"]) ? $_REQUEST["name"] : '');


// Clean the fileName for security reasons
        $this->_filePath = $this->targetDir . DIRECTORY_SEPARATOR . $this->fileName;

        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
            $this->_contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        }
        if (isset($_SERVER["CONTENT_TYPE"])) {
            $this->_contentType = $_SERVER["CONTENT_TYPE"];
        }

        $this->cleanTmpDir();
        $file = $this->store();
        if (method_exists(\yii::$app->controller, 'downloaded') && $file !== null && $file !== false) {
            if (\yii::$app->controller->downloaded(array($this->fileName=>$file)) === false) {
                $file=false;
            }
        }
        $this->response($file === false ? 500 : 200);
    }


    public function cleanTmpDir()
    {
// Remove old temp files
        if ($this->cleanupTargetDir) {
            if (is_dir($this->targetDir) && ($dir = opendir($this->targetDir))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $this->targetDir . DIRECTORY_SEPARATOR . $file;
                    // Remove temp file if it is older than the max age and is not the current file
                    if (filemtime($tmpfilePath) < time() - $this->maxFileAge) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            }
        }
    }


    public function store()
    {
// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($this->_contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = @fopen("{$this->_filePath}.part", $this->_chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = @fopen($_FILES['file']['tmp_name'], "rb");
                    if ($in) {
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                    } else {
                        @fclose($in);
                        @fclose($out);
                        @unlink($out);
                        return false;
                    }
                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                    return false;
                }
            } else {
                return false;
            }
        } else {
            // Open temp file
            $out = @fopen("{$this->_filePath}.part", $this->_chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = @fopen("php://input", "rb");
                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                } else {
                    @fclose($in);
                    return false;
                }
                @fclose($in);
                @fclose($out);
            } else {
                return false;
            }
        }

// Check if file has been uploaded
        if (!$this->_chunks || $this->_chunk == $this->_chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$this->_filePath}.part", $this->_filePath);
            return $this->_filePath;
        }
        return null;
    }

    public function response($statusCode = 200)
    {

        \yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'no-cache')
            ->set('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT')
            ->set('Expires', '0')
            ->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        \yii::$app->getResponse()->setStatusCode($statusCode);
    }


}
