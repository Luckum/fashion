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

    public function create($is_thumb = false, $crop_mode = 0)
    {
        //$this->set_output_size($this->stop_compress());
        $this->set_output_size(true);

        $this->get_source_image($this->file_path);
        
        $mode = 0;

        if (!$is_thumb) {
            if (round($this->output_width) < Yii::app()->params['image_settings']['min_medium_width']) {
                $this->output_width = Yii::app()->params['image_settings']['min_medium_width'];
                $this->output_height = Yii::app()->params['image_settings']['min_medium_height'];
                $mode = 1;
            } else if (round($this->output_width) > Yii::app()->params['image_settings']['min_medium_width'] && round($this->output_width) < Yii::app()->params['image_settings']['mid_medium_width']) {
                $mode = 2;
                if (round($this->output_height) < Yii::app()->params['image_settings']['min_medium_height']) {
                    $mode = 1;
                }
                $this->output_width = Yii::app()->params['image_settings']['min_medium_width'];
                $this->output_height = Yii::app()->params['image_settings']['min_medium_height'];
            } else if (round($this->output_width) > Yii::app()->params['image_settings']['mid_medium_width'] && round($this->output_width) < Yii::app()->params['image_settings']['max_medium_width']) {
                $mode = 3;
                if (round($this->output_height) < Yii::app()->params['image_settings']['mid_medium_height']) {
                    $this->output_width = Yii::app()->params['image_settings']['min_medium_width'];
                    $this->output_height = Yii::app()->params['image_settings']['min_medium_height'];
                } else {
                    $this->output_width = Yii::app()->params['image_settings']['mid_medium_width'];
                    $this->output_height = Yii::app()->params['image_settings']['mid_medium_height'];
                }
            } else if (round($this->output_width) > Yii::app()->params['image_settings']['max_medium_width']) {
                $mode = 4;
                if (round($this->output_height) < Yii::app()->params['image_settings']['max_medium_height']) {
                    $this->output_width = Yii::app()->params['image_settings']['mid_medium_width'];
                    $this->output_height = Yii::app()->params['image_settings']['mid_medium_height'];
                } else {
                    $this->output_width = Yii::app()->params['image_settings']['max_medium_width'];
                    $this->output_height = Yii::app()->params['image_settings']['max_medium_height'];
                }
            }
        }
        
        switch ($mode) {
            case 0:
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
            break;
            case 1:
                self::img_resize($this->file_path, $this->save_path, $this->output_width, $this->output_height);
            break;
            case 2:
            case 3:
            case 4:
                self::img_crop($this->file_path, $this->save_path, 0, 0, $this->output_width, $this->output_height, null, 90, 0, 0, $crop_mode);
            break;
        }
    }
    
    public function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
    {
        if (!file_exists($src)) return false;
        $size = getimagesize($src);
        
        if ($size === false) return false;
        
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = 'imagecreatefrom' . $format;
         
        if (!function_exists($icfunc)) return false;
         
        $x_ratio = $width  / $size[0];
        $y_ratio = $height / $size[1];
         
        if ($height == 0) {
            $y_ratio = $x_ratio;
            $height = $y_ratio * $size[1];
        } elseif ($width == 0) {
            $x_ratio = $y_ratio;
            $width = $x_ratio * $size[0];
        }
         
        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
         
        $new_width = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio  ? 0 : floor(($width - $new_width)   / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
         
        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);
         
        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
         
        imagejpeg($idest, $dest, $quality);
         
        imagedestroy($isrc);
        imagedestroy($idest);
         
        return true;
    }
    
    public function img_crop($src_img, $dest_img, $x0, $y0, $x1, $y1, $format = NULL, $quality = 90, $ignore_crop_width = 0, $ignore_crop_height = 0, $crop_mode = 0)
    {
        if (!file_exists($src_img)) return false;
        $img_size = @getimagesize($src_img);
        if ($img_size === false) return false;

        if ($ignore_crop_width && $ignore_crop_height && $img_size[0] < $ignore_crop_width && $img_size[1] < $ignore_crop_height) {
            return false;
        }

        switch ($crop_mode) {
            case 0:
                $x_crop = ($img_size[0] - $x1) / 2;
                $y_crop = ($img_size[1] - $y1) / 2;
            break;
            case 1:
                //center and bottom
                $x_crop = ($img_size[0] - $x1) / 2;
                $y_crop = $img_size[1] - $y1;
            break;
            case 2:
                //center and middle
                $x_crop = ($img_size[0] - $x1) / 2;
                $y_crop = ($img_size[1] - $y1) / 2;
            break;
            case 3:
                //center and top
                $x_crop = ($img_size[0] - $x1) / 2;
                $y_crop = 0;
            break;
        }
        
        
        
        $x0 = (int)$x0;
        $x1 = (int)$x1;
        $y0 = (int)$y0;
        $y1 = (int)$y1;

        $img_format = strtolower(substr($img_size['mime'], strpos($img_size['mime'], '/') + 1));
        if (($img_format == 'x-ms-bmp') || ($img_format == 'bitmap')) {
            $img_format = 'bmp';
        }
        if (!function_exists($fn_imgcreatefrom = 'imagecreatefrom' . $img_format))
            return false;

        if (!$format) {
            $format = $img_format;
        }

        $new_width = $x1 - $x0;
        $new_height = $y1 - $y0;

        $gd_dest_img = imagecreatetruecolor($new_width, $new_height);
        $gd_src_img = $fn_imgcreatefrom($src_img);

        if (($format == 'png') || ($format == 'gif')) {
            imagealphablending($gd_dest_img, false);
            imagesavealpha($gd_dest_img, true);
            $transparent = imagecolorallocatealpha($gd_dest_img, 255, 255, 255, 127);
            imagefilledrectangle($gd_dest_img, 0, 0, $new_width, $new_height, $transparent);
        }

        //imagecopyresampled($gd_dest_img, $gd_src_img, 0, 0, $x0, $y0, $new_width, $new_height, $new_width, $new_height);
        imagecopyresampled($gd_dest_img, $gd_src_img, 0, 0, $x_crop, $y_crop, $new_width, $new_height, $new_width, $new_height);
        switch ($format) {
            case 'gif':
                imagegif($gd_dest_img, $dest_img);
                break;
            case 'png':
                imagepng($gd_dest_img, $dest_img);
                break;
            case 'bmp':
                imagebmp($gd_dest_img, $dest_img);
                break;
            default:
                imagejpeg($gd_dest_img, $dest_img, $quality);
                break;
        }
        imagedestroy($gd_dest_img);
        imagedestroy($gd_src_img);
        
        return true;
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

    public static function compress($file_path, $save_path, $max_width, $max_height, $quality, $remove_old, $is_thumb = false, $crop_mode = 0)
    {
        if ($remove_old) {
            if (file_exists($save_path) && is_file($save_path)) unlink($save_path);
        }

        $wrapper = new FileImageWrapper($file_path, $save_path, $max_width, $max_height, $quality);

        $wrapper->create($is_thumb, $crop_mode);
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

    public static function cSaveWithReducedCopies(CUploadedFile $file, $newName = null, $is_url = false, $crop_mode = 0)
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
            if ($is_url) {
                copy($is_url, $save_max_path);
                
            } else {
                self::saveWithoutCompress($file, $save_max_path, true);
            }
            
            self::compress($save_max_path, $save_medium_path, $medium_width, $medium_height, $quality, true, false, $crop_mode);
            self::compress($save_max_path, $save_thumbnail_path, $thumbnail_width, $thumbnail_height, $quality, true, true);
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
            self::compress($save_max_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true, true);
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
            self::compress($save_max_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true, true);
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
            self::compress($source_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true, true);
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
            self::compress($source_path, $thumbnail_dir . $name, $thumbnail_width, $thumbnail_height, $quality, true, true);
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