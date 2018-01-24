<?php

abstract class ImageWrapperAbstract
{
    const JPEG = 'jpeg';
    const JPEG_UPPER = 'JPEG';
    const JPG = 'jpg';
    const JPG_UPPER = 'JPG';
    const PNG = 'png';
    const PNG_UPPER = 'PNG';
    const GIF = 'gif';
    const GIF_UPPER = 'GIF';

    protected static $extensions = array(
        self::JPEG,
        self::JPEG_UPPER,
        self::JPG,
        self::JPG_UPPER,
        self::PNG,
        self::PNG_UPPER,
        self::GIF,
        self::GIF_UPPER
    );

    protected $is_valid_extension;
    protected $input_width;
    protected $input_height;
    protected $input_ext;
    protected $save_path;
    protected $quality;
    protected $max_width;
    protected $max_height;
    protected $source_image;
    protected $output_image;
    protected $output_width;
    protected $output_height;
    protected $file_path;

    protected function get_input_size($path)
    {
        list($this->input_width, $this->input_height) = getimagesize($path);
    }

    protected function stop_compress()
    {
        return
            $this->input_width <= $this->max_width && $this->input_height <= $this->max_height;
    }

    protected function set_output_size($stopCompress)
    {
        if ($stopCompress) {
            $this->output_width = $this->input_width;
            $this->output_height = $this->input_height;
        } else {
            $is_horizontal_image = ($this->input_width / $this->input_height) >= 1;

            if ($is_horizontal_image) {
                $rate = $this->max_width / $this->input_width;
            } else {
                $rate = $this->max_height / $this->input_height;
            }

            $this->output_width = $this->input_width * $rate;
            $this->output_height = $this->input_height * $rate;
        }
    }

    protected function get_source_image($file_path)
    {
        $image = null;

        switch ($this->input_ext) {
            case self::JPG :
            case self::JPG_UPPER :
            case self::JPEG_UPPER :
            case self::JPEG : {
                $image = imagecreatefromjpeg($file_path);
                break;
            }
            case self::PNG_UPPER :
            case self::PNG : {
                $image = imagecreatefrompng($file_path);
                break;
            }
            case self::GIF_UPPER :
            case self::GIF : {
                $image = imagecreatefromgif($file_path);
                break;
            }
        }

        $this->source_image = $image;
    }

    public static function validate_extension($ext)
    {
        return in_array($ext, self::$extensions);
    }

    public function create()
    {
        $this->set_output_size($this->stop_compress());

        $this->get_source_image($this->file_path);

        $this->output_image = imagecreatetruecolor($this->output_width, $this->output_height);

        imagecopyresampled(
            $this->output_image,
            $this->source_image,
            0,
            0,
            0,
            0,
            $this->output_width,
            $this->output_height,
            $this->input_width,
            $this->input_height
        );

        switch ($this->input_ext) {
            case self::JPG :
            case self::JPG_UPPER :
            case self::JPEG_UPPER :
            case self::JPEG : {
                imagejpeg($this->output_image, $this->save_path, $this->quality);
                break;
            }
            case self::PNG_UPPER :
            case self::PNG : {
                imagepng($this->output_image, $this->save_path);
                break;
            }
            case self::GIF_UPPER :
            case self::GIF : {
                imagegif($this->output_image, $this->save_path);
                break;
            }
        }

        imagedestroy($this->source_image);
        imagedestroy($this->output_image);
    }
}

class CUploadedImageWrapper extends ImageWrapperAbstract
{
    private $input_file;

    public function __construct(CUploadedFile $input_file, $save_path, $max_width, $max_height, $quality)
    {
        $this->input_file = $input_file;
        $this->file_path = $input_file->getTempName();
        $this->save_path = $save_path;
        $this->max_width = $max_width;
        $this->max_height = $max_height;
        $this->quality = $quality;

        $this->get_input_ext();

        if (!$this->is_valid_extension) throw new Exception('unvalid extension');

        $this->get_input_size($this->file_path);
    }

    private function get_input_ext()
    {
        $this->input_ext = strtolower($this->input_file->getExtensionName());

        $this->is_valid_extension = self::validate_extension($this->input_ext);
    }
}

class FileImageWrapper extends ImageWrapperAbstract
{
    public function __construct($file_path, $save_path, $max_width, $max_height, $quality)
    {
        if(!file_exists($file_path)) throw new Exception('file not found');

        $this->file_path = $file_path;
        $this->save_path = $save_path;
        $this->max_width = $max_width;
        $this->max_height = $max_height;
        $this->quality = $quality;

        $this->get_input_ext();

        if (!$this->is_valid_extension) throw new Exception('unvalid extension');

        $this->get_input_size($this->file_path);
    }

    private function get_input_ext()
    {
        $arr = explode('.', $this->file_path);
        $this->input_ext = end($arr);

        $this->is_valid_extension = self::validate_extension($this->input_ext);
    }
}

class ImageHelper
{
    public static function saveWithoutCompress(CUploadedFile $file, $save_path, $remove_old){
        if ($remove_old) {
            if (file_exists($save_path) && is_file($save_path)) unlink($save_path);
        }

        $file->saveAs($save_path);
    }

    public static function cCompress(CUploadedFile $file, $save_path, $max_width, $max_height, $quality, $remove_old)
    {
        if ($remove_old) {
            if (file_exists($save_path) && is_file($save_path)) unlink($save_path);
        }

        $wrapper = new CUploadedImageWrapper($file, $save_path, $max_width, $max_height, $quality);

        $wrapper->create();
    }

    public static function compress($file_path, $save_path, $max_width, $max_height, $quality, $remove_old)
    {
        if ($remove_old) {
            if (file_exists($save_path) && is_file($save_path)) unlink($save_path);
        }

        $wrapper = new FileImageWrapper($file_path, $save_path, $max_width, $max_height, $quality);

        $wrapper->create();
    }

    public static function getUniqueValidName($path, $name)
    {
        $arr = explode('.', $name);
        $ext = end($arr);

        if (!ImageWrapperAbstract::validate_extension($ext)) return null;

        $new = $name;

        do {
            $new = 'image_' . uniqid() . '.' . $ext;
        } while (file_exists($path . $new));

        return $new;
    }

    public static function cSaveWithReducedCopies(CUploadedFile $file, $newName = null)
    {
        $name = $newName == null ? $file->getName() : $newName;

        // --------- paths
        //
        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::IMAGE_MAX_DIR . $name;
        $save_medium_path = $base_path . ShopConst::IMAGE_MEDIUM_DIR . $name;
        $save_thumbnail_path = $base_path . ShopConst::IMAGE_THUMBNAIL_DIR . $name;

        // --------- sizes
        //
        //$max_width = Yii::app()->params['image_settings']['max_width'];
        //$max_height = Yii::app()->params['image_settings']['max_height'];
        $medium_width = Yii::app()->params['image_settings']['max_medium_width'];
        $medium_height = Yii::app()->params['image_settings']['max_medium_height'];
        $thumbnail_width = Yii::app()->params['image_settings']['max_thumbnail_width'];
        $thumbnail_height = Yii::app()->params['image_settings']['max_thumbnail_height'];

        // -------- quality
        //
        $quality = Yii::app()->params['image_settings']['quality'];

        // -------- save
        //
        try {
            //self::cCompress($file, $save_max_path, $max_width, $max_height, $quality, true);
            self::saveWithoutCompress($file, $save_max_path, true);
            self::compress($save_max_path, $save_medium_path, $medium_width, $medium_height, $quality, true);
            self::compress($save_max_path, $save_thumbnail_path, $thumbnail_width, $thumbnail_height, $quality, true);
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
    }

    public static function cSaveHomeBlockImage(CUploadedFile $file, $newName = null)
    {
        $name = $newName == null ? $file->getName() : $newName;

        // --------- paths
        //
        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::HOME_BLOCK_IMAGE_MAX_DIR . $name;
        $medium_dir = $base_path . ShopConst::HOME_BLOCK_IMAGE_MEDIUM_DIR;
        $thumbnail_dir = $base_path . ShopConst::HOME_BLOCK_IMAGE_THUMBNAIL_DIR;

        // --------- sizes
        //
        $max_width = Yii::app()->params['image_settings']['max_width'];
        $max_height = Yii::app()->params['image_settings']['max_height'];
        $medium_width = Yii::app()->params['image_settings']['max_home_block_medium_width'];
        $medium_height = Yii::app()->params['image_settings']['max_home_block_medium_height'];
        $thumbnail_width = Yii::app()->params['image_settings']['max_home_block_thumbnail_width'];
        $thumbnail_height = Yii::app()->params['image_settings']['max_home_block_thumbnail_height'];

        // -------- quality
        //
        $quality = Yii::app()->params['image_settings']['quality'];

        try {
            // -------- create medium and thumbnail dir
            //
            if (!is_dir($medium_dir)) mkdir($medium_dir);
            if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir);

            // -------- save
            //
            self::cCompress($file, $save_max_path, $max_width, $max_height, $quality, true);
            self::compress($save_max_path, $medium_dir . $name, $medium_width, $medium_height, $quality, true);
            self::compress($save_max_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true);
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
    }

    public static function cSaveBlogImage(CUploadedFile $file, $newName = null)
    {
        $name = $newName == null ? $file->getName() : $newName;

        // --------- paths
        //
        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::BLOG_IMAGE_MAX_DIR . $name;
        $medium_dir = $base_path . ShopConst::BLOG_IMAGE_MEDIUM_DIR;
        $thumbnail_dir = $base_path . ShopConst::BLOG_IMAGE_THUMBNAIL_DIR;

        // --------- sizes
        //
        $max_width = Yii::app()->params['image_settings']['max_width'];
        $max_height = Yii::app()->params['image_settings']['max_height'];
        $medium_width = Yii::app()->params['image_settings']['max_blog_medium_width'];
        $medium_height = Yii::app()->params['image_settings']['max_blog_medium_height'];
        $thumbnail_width = Yii::app()->params['image_settings']['max_blog_thumbnail_width'];
        $thumbnail_height = Yii::app()->params['image_settings']['max_blog_thumbnail_height'];

        // -------- quality
        //
        $quality = Yii::app()->params['image_settings']['quality'];

        try {
            // -------- create medium and thumbnail dir
            //
            if (!is_dir($medium_dir)) mkdir($medium_dir, 0777, true);
            if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir, 0777, true);

            // -------- save
            //
            self::cCompress($file, $save_max_path, $max_width, $max_height, $quality, true);
            self::compress($save_max_path, $medium_dir . $name, $medium_width, $medium_height, $quality, true);
            self::compress($save_max_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true);
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
    }

    public static function saveHomeBlockImage($name)
    {
        // --------- paths
        //
        $base_path = Yii::getPathOfAlias('webroot');
        $source_path = $base_path . ShopConst::HOME_BLOCK_IMAGE_MAX_DIR . $name;
        $medium_dir = $base_path . ShopConst::HOME_BLOCK_IMAGE_MEDIUM_DIR;
        $thumbnail_dir = $base_path . ShopConst::HOME_BLOCK_IMAGE_THUMBNAIL_DIR;

        // --------- sizes
        //
        $medium_width = Yii::app()->params['image_settings']['max_home_block_medium_width'];
        $medium_height = Yii::app()->params['image_settings']['max_home_block_medium_height'];
        $thumbnail_width = Yii::app()->params['image_settings']['max_home_block_thumbnail_width'];
        $thumbnail_height = Yii::app()->params['image_settings']['max_home_block_thumbnail_height'];

        // -------- quality
        //
        $quality = Yii::app()->params['image_settings']['quality'];

        try {
            // -------- create medium and thumbnail dir
            //
            if (!is_dir($medium_dir)) mkdir($medium_dir);
            if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir);

            // -------- create
            //
            self::compress($source_path, $medium_dir . $name, $medium_width, $medium_height, $quality, true);
            self::compress($source_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true);
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
    }

    public static function saveBlogImage($name)
    {
        // --------- paths
        //
        $base_path = Yii::getPathOfAlias('webroot');
        $source_path = $base_path . ShopConst::BLOG_IMAGE_MAX_DIR . $name;
        $medium_dir = $base_path . ShopConst::BLOG_IMAGE_MEDIUM_DIR;
        $thumbnail_dir = $base_path . ShopConst::BLOG_IMAGE_THUMBNAIL_DIR;

        // --------- sizes
        //
        $medium_width = Yii::app()->params['image_settings']['max_blog_medium_width'];
        $medium_height = Yii::app()->params['image_settings']['max_blog_medium_height'];
        $thumbnail_width = Yii::app()->params['image_settings']['max_blog_thumbnail_width'];
        $thumbnail_height = Yii::app()->params['image_settings']['max_blog_thumbnail_height'];

        // -------- quality
        //
        $quality = Yii::app()->params['image_settings']['quality'];

        try {
            // -------- create medium and thumbnail dir
            //
            if (!is_dir($medium_dir)) mkdir($medium_dir, 0777, true);
            if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir, 0777, true);

            // -------- create
            //
            self::compress($source_path, $medium_dir . $name, $medium_width, $medium_height, $quality, true);
            self::compress($source_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true);
        } catch (Exception $e) {
            Yii::log($e->getMessage());
        }
    }

    public static function cloneImages($parent_dir, $child_dir, $max_width, $max_height, $quality)
    {
        $parents = scandir($parent_dir);

        if (!$parents || !is_dir($child_dir)) return;

        $error_message = '';

        foreach ($parents as $parent) {
            if (strlen($parent) < 5) continue;

            try {
                $child = new FileImageWrapper(($parent_dir . $parent), ($child_dir . $parent), $max_width, $max_height, $quality);

                if (file_exists($child_dir . $parent)) unlink($child_dir . $parent);

                $child->create();
            } catch (Exception $e) {
                $error_message .= $e->getMessage() . '<br />';
            }
        }

        echo $error_message;
    }

    public static function get($imageName, $partialPath, $partialAlterPath)
    {
        $baseUrl = Yii::app()->request->baseUrl;
        $basePath = Yii::getPathOfAlias('webroot');

        return file_exists($basePath . $partialPath . $imageName) ?
            $baseUrl . $partialPath . $imageName :
            $baseUrl . $partialAlterPath . $imageName;
    }

    public static function removeOldHomeblockImages($image)
    {
        if (!$image) return;

        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::HOME_BLOCK_IMAGE_MAX_DIR . $image;
        $medium_path = $base_path . ShopConst::HOME_BLOCK_IMAGE_MEDIUM_DIR . $image;
        $thumbnail_path = $base_path . ShopConst::HOME_BLOCK_IMAGE_THUMBNAIL_DIR . $image;

        if (file_exists($save_max_path) && is_file($save_max_path)) unlink($save_max_path);
        if (file_exists($medium_path) && is_file($medium_path)) unlink($medium_path);
        if (file_exists($thumbnail_path) && is_file($thumbnail_path)) unlink($thumbnail_path);
    }

    public static function removeOldBlogImages($image)
    {
        if (!$image) return;

        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::BLOG_IMAGE_MAX_DIR . $image;
        $medium_path = $base_path . ShopConst::BLOG_IMAGE_MEDIUM_DIR . $image;
        $thumbnail_path = $base_path . ShopConst::BLOG_IMAGE_THUMBNAIL_DIR . $image;

        if (file_exists($save_max_path) && is_file($save_max_path)) unlink($save_max_path);
        if (file_exists($medium_path) && is_file($medium_path)) unlink($medium_path);
        if (file_exists($thumbnail_path) && is_file($thumbnail_path)) unlink($thumbnail_path);
    }

    public static function removeOldProductImages($image)
    {
        if (!$image) return;

        $base_path = Yii::getPathOfAlias('webroot');
        $save_max_path = $base_path . ShopConst::IMAGE_MAX_DIR . $image;
        $save_medium_path = $base_path . ShopConst::IMAGE_MEDIUM_DIR . $image;
        $save_thumbnail_path = $base_path . ShopConst::IMAGE_THUMBNAIL_DIR . $image;

        if (file_exists($save_max_path) && is_file($save_max_path)) unlink($save_max_path);
        if (file_exists($save_medium_path) && is_file($save_medium_path)) unlink($save_medium_path);
        if (file_exists($save_thumbnail_path) && is_file($save_thumbnail_path)) unlink($save_thumbnail_path);
    }
}