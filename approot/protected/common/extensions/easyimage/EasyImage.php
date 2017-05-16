<?php
/**
 * EasyImage class file.
 * @author liutao@fangfull.com
 * @copyright Copyright &copy; liutao 2015-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version 1.0.5
 */

Yii::setPathOfAlias('easyimage', dirname(__FILE__));
Yii::import('easyimage.drivers.*');

/**
 * 图片处理类
 */
class EasyImage extends CApplicationComponent 
{
    /**
     * Resizing directions
     */
    const RESIZE_NONE = 0x01;
    const RESIZE_WIDTH = 0x02;
    const RESIZE_HEIGHT = 0x03;
    const RESIZE_AUTO = 0x04;
    const RESIZE_INVERSE = 0x05;
    const RESIZE_PRECISE = 0x06;
    const RESIZE_PADDING = 0x07;

    /**
     * Flipping directions
     */
    const FLIP_HORIZONTAL = 0x11;
    const FLIP_VERTICAL = 0x12;

    /**
     * Watermark position
     */
    const WATERMARK_POSITION_DUPLICATE = 0x91;

    /**
     * @var object Image
     */
    private $_image;

    /**
     * @var string driver type: GD, Imagick
     */
    public $driver = 'GD';

    /**
     * @var string relative path where the cache files are kept
     */
    public $cachePath = '/assets/easyimage/';

    /**
     * @var int cache lifetime in seconds
     */
    public $cacheTime = 2592000;

    /**
     * @var int value of quality: 0-100 (only for JPEG)
     */
    public $quality = 100;

    /**
     * @var bool use retina-resolutions
     * This setting increases the load on the server.
     */
    public $retinaSupport = false;

    /**
     * @var int Permissions for main cache directory and subdirectories.
     */
    public $newDirMode = 0777;

    /**
     * @var int Permissions for cached files.
     */
    public $newFileMode = 0777;

    /**
     * Constructor.
     * @param string $file
     * @param string $driver
     */
    public function __construct($file = null, $driver = null)
    {
        if (is_file($file)) {
            return $this->_image = Image::factory($this->detectPath($file), $driver ? $driver : $this->driver);
        }
    }

    /**
     * Convert object to binary data of current image.
     * Must be rendered with the appropriate Content-Type header or it will not be displayed correctly.
     * @return string as binary
     */
    public function __toString()
    {
        try {
            return $this->image()->render();
        } catch (CException $e) {
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Publish "retina.js" library (http://retinajs.com/)
        if ($this->retinaSupport) {
            Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('easyimage.assets') . '/retina.min.js'
                ),
                CClientScript::POS_HEAD
            );
        }
    }

    /**
     * This method returns the current Image instance.
     * @return Image
     * @throws CException
     */
    public function image()
    {
        if ($this->_image instanceof Image) {
            return $this->_image;
        } else {
            throw new CException('Don\'t have image');
        }
    }

    /**
     * This method detects which (absolute or relative) path is used.
     * @param array $file path
     * @return string path
     */
    public function detectPath($file)
    {
        $fullPath = dirname(Yii::app()->basePath) . $file;
        if (is_file($fullPath)) {
            return $fullPath;
        }
        return $file;
    }

    /**
     * Performance of image manipulation and save result.
     * @param string $file the path to the original image
     * @param string $newFile path to the resulting image
     * @param array $params
     * @return bool operation status
     * @throws CException
     */
    private function _doThumbOf($file, $newFile, $params)
    {
        if ($file instanceof Image) {
            $this->_image = $file;
        } else {
            if (!is_file($file)) {
                return false;
            }
            $this->_image = Image::factory($this->detectPath($file), $this->driver);
        }
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'resize':
                    $this->resize(
                        isset($value['width']) ? $value['width'] : NULL,
                        isset($value['height']) ? $value['height'] : NULL,
                        isset($value['master']) ? $value['master'] : NULL,
                        isset($value['padding']) ? $value['padding'] : FALSE
                    );
                    break;
                case 'crop':
                    if (!isset($value['width']) || !isset($value['height'])) {
                        throw new CException('Params "width" and "height" is required for action "' . $key . '"');
                    }
                    $this->crop(
                        $value['width'],
                        $value['height'],
                        isset($value['offset_x']) ? $value['offset_x'] : NULL,
                        isset($value['offset_y']) ? $value['offset_y'] : NULL
                    );
                    break;
                case 'scaleAndCrop':
                    $this->scaleAndCrop($value['width'], $value['height']);
                    break;
                case 'rotate':
                    if (is_array($value)) {
                        if (!isset($value['degrees'])) {
                            throw new CException('Param "degrees" is required for action "' . $key . '"');
                        }
                        $this->rotate($value['degrees']);
                    } else {
                        $this->rotate($value);
                    }
                    break;
                case 'flip':
                    if (is_array($value)) {
                        if (!isset($value['direction'])) {
                            throw new CException('Param "direction" is required for action "' . $key . '"');
                        }
                        $this->flip($value['direction']);
                    } else {
                        $this->flip($value);
                    }
                    break;
                case 'sharpen':
                    if (is_array($value)) {
                        if (!isset($value['amount'])) {
                            throw new CException('Param "amount" is required for action "' . $key . '"');
                        }
                        $this->sharpen($value['amount']);
                    } else {
                        $this->sharpen($value);
                    }
                    break;
                case 'reflection':
                    $this->reflection(
                        isset($value['height']) ? $value['height'] : NULL,
                        isset($value['opacity']) ? $value['opacity'] : 100,
                        isset($value['fade_in']) ? $value['fade_in'] : FALSE
                    );
                    break;
                case 'watermark':
                    if (is_array($value)) {
                        $this->watermark(
                            isset($value['watermark']) ? $value['watermark'] : NULL,
                            isset($value['offset_x']) ? $value['offset_x'] : NULL,
                            isset($value['offset_y']) ? $value['offset_y'] : NULL,
                            isset($value['opacity']) ? $value['opacity'] : 100,
                            isset($value['duplicate']) ? $value['duplicate'] : FALSE
                        );
                    } else {
                        $this->watermark($value);
                    }
                    break;
                case 'background':
                    if (is_array($value)) {
                        if (!isset($value['color'])) {
                            throw new CException('Param "color" is required for action "' . $key . '"');
                        }
                        $this->background(
                            $value['color'],
                            isset($value['opacity']) ? $value['opacity'] : 100
                        );
                    } else {
                        $this->background($value);
                    }
                    break;
                case 'quality':
                    if (!isset($value)) {
                        throw new CException('Param "' . $key . '" can\'t be empty');
                    }
                    $this->quality = $value;
                    break;
                case 'type':
                    break;
                default:
                    throw new CException('Action "' . $key . '" is not found');
            }
        }
        $result = $this->save($newFile, $this->quality);
        @chmod($newFile, $this->newFileMode);
        return $result;
    }


    /**
     * 动态生成缩略图，持久存储
     * 
     * @param  string $file        原始图片地址
     * @param  array  $thumbParams 缩略配置参数
     * @param  array  $saveParams  存储配置参数
     * @return mixed  false|string 文件绝对路径或是返回false
     */
    public function generateThumb($file, $thumbParams = array(), $saveParams = array())
    {
        // 原始图不存在
        if (!file_exists($file)) {
            return false;
        }

        // 获取源图片信息
        list( $dirname, $basename, $extension, $filename ) = array_values( pathinfo($file) );
        // 去除/o目录
        $dirname = rtrim($dirname, DIRECTORY_SEPARATOR.'o');

        // 缩略图文件名
        $thumbFileName = isset($saveParams['name']) ? $saveParams['name'] : $basename;

        // 缩略图存储目录（resolution + path）
        if (isset($saveParams['resolution'])) {
            $thumbSaveDir = $saveParams['resolution'];
        } elseif(isset($thumbParams['resize']['width']) && isset($thumbParams['resize']['height'])) {
            $thumbSaveDir = $thumbParams['resize']['width']. 'x' .$thumbParams['resize']['height'];
        } else {
            $thumbSaveDir = 'unknown';
        }
        // path
        if (isset($saveParams['path'])) {
            $thumbSaveDir .= DIRECTORY_SEPARATOR . $saveParams['path'];
        } elseif(!empty($dirname)) {
            $arrDir = explode(DIRECTORY_SEPARATOR, $dirname);
            $thumbSaveDir .= DIRECTORY_SEPARATOR . end($arrDir);
        } else {
            $thumbSaveDir .= DIRECTORY_SEPARATOR . '';
        }

        // 缩略图绝对路径
        $thumbSavePath = Yii::getpathOfAlias('webroot') . $this->cachePath . $thumbSaveDir;
        // 缩略图文件绝对路径
        $thumbSaveFile = $thumbSavePath . DIRECTORY_SEPARATOR . $thumbFileName;

        // 缩略图已经存在
        if (file_exists($thumbSaveFile)) {
            return $thumbSaveFile;
        }

        // 创建存储目录
        if (!is_dir($thumbSavePath)) {
            mkdir($thumbSavePath, $this->newDirMode, true);
            chmod($thumbSavePath, $this->newDirMode);
        }

        // 生成缩略图
        $objImage = Image::factory( $this->detectPath($file), $this->driver );
        $result = $this->_doThumbOf($objImage, $thumbSaveFile, $thumbParams);
        unset($objImage);

        return  $thumbSaveFile;
    }


    /**
     * This method returns the URL to the cached thumbnail.
     * @param string $file path
     * @param array $params
     * @param mixed $hash cache version modifier
     * @return string URL path
     */
    public function thumbSrcOf($file, $params = array())
    {
        // Paths
        $hash = md5($file . serialize($params) . (string)$hash);
        $cachePath = Yii::getpathOfAlias('webroot') . $this->cachePath . $hash{0};
        $cacheFileExt = isset($params['type']) ? $params['type'] : pathinfo($file, PATHINFO_EXTENSION);
        $cacheFileName = $hash . '.' . $cacheFileExt;
        $cacheFile = $cachePath . DIRECTORY_SEPARATOR . $cacheFileName;
        $webCacheFile = Yii::app()->baseUrl . $this->cachePath . $hash{0} . '/' . $cacheFileName;

        // Return URL to the cache image
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $this->cacheTime)) {
            return $webCacheFile;
        }

        // Make cache dir
        if (!is_dir($cachePath)) {
            mkdir($cachePath, $this->newDirMode, true);
            chmod(Yii::getpathOfAlias('webroot') . $this->cachePath, $this->newDirMode);
            chmod($cachePath, $this->newDirMode);
        }

        // Create and caching thumbnail use params
        if (!is_file($file)) {
            return false;
        }
        $image = Image::factory($this->detectPath($file), $this->driver);
        $originWidth = $image->width;
        $originHeight = $image->height;
        $result = $this->_doThumbOf($image, $cacheFile, $params);
        unset($image);

        // Same for high-resolution image
        if ($this->retinaSupport && $result) {
            if ($this->image()->width * 2 <= $originWidth && $this->image()->height * 2 <= $originHeight) {
                $retinaFile = $cachePath . DIRECTORY_SEPARATOR . $hash . '@2x.' . $cacheFileExt;
                if (isset($params['resize']['width']) && isset($params['resize']['height'])) {
                    $params['resize']['width'] = $this->image()->width * 2;
                    $params['resize']['height'] = $this->image()->height * 2;
                }
                $this->_doThumbOf($file, $retinaFile, $params);
            }
        }

        return $webCacheFile;
    }

    /************** 以下使用工厂模式下overwrite方法 **************/
    public function resize($width = NULL, $height = NULL, $master = NULL, $padding = true)
    {
        return $this->image()->resize($width, $height, $master, $padding);
    }

    public function crop($width, $height, $offset_x = NULL, $offset_y = NULL)
    {
        return $this->image()->crop($width, $height, $offset_x, $offset_y);
    }

    public function scaleAndCrop($width, $height)
    {
        $this->resize(
            $width,
            $height,
            self::RESIZE_INVERSE
        );
        $this->crop($width, $height);
    }

    public function rotate($degrees)
    {
        return $this->image()->rotate($degrees);
    }

    public function flip($direction)
    {
        return $this->image()->flip($direction);
    }

    public function sharpen($amount)
    {
        return $this->image()->sharpen($amount);
    }

    public function reflection($height = NULL, $opacity = 100, $fade_in = FALSE)
    {
        return $this->image()->reflection($height, $opacity, $fade_in);
    }

    public function watermark($watermark, $offset_x = NULL, $offset_y = NULL, $opacity = 100, $duplicate = NULL)
    {
        if ($watermark instanceof EasyImage) {
            $watermark = $watermark->image();
        } elseif (is_file($watermark) && file_exists($watermark)) {
            $watermark = Image::factory($watermark);
        } elseif (is_string($watermark)) {
            $watermark = Image::factory(Yii::getpathOfAlias('webroot') . $watermark);
        }

        return $this->image()->watermark($watermark, $offset_x, $offset_y, $opacity, $duplicate);
    }

    public function background($color, $opacity = 100)
    {
        return $this->image()->background($color, $opacity);
    }

    public function save($file = NULL, $quality = 100)
    {
        return $this->image()->save($file, $quality);
    }

    public function render($type = NULL, $quality = 100)
    {
        return $this->image()->render($type, $quality);
    }


}
