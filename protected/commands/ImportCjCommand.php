<?php

class ImportCjCommand extends CConsoleCommand
{
    protected $category_link = [
        'Apparel & Accessories > Clothing' => 94,
        'Apparel & Accessories > Handbags, Wallets & Cases' => 182,
        'Apparel & Accessories > Clothing > Shirts & Tops' => 162,
        'Apparel & Accessories > Clothing Accessories > Sunglasses' => 149,
        'Apparel & Accessories > Shoes' => 135,
        'Apparel & Accessories > Clothing > Dresses' => 153,
        'Apparel & Accessories > Clothing > Outerwear' => 94,
        'Apparel & Accessories > Clothing > Pants' => 177,
        'Apparel & Accessories > Clothing > Shorts' => 178,
        'Apparel & Accessories > Clothing > Skirts' => 179,
        'Apparel & Accessories > Handbags, Wallets & Cases > Handbags' => 188,
        'Apparel & Accessories > Clothing > One-Pieces' => 94,
        'Apparel & Accessories > Clothing > Swimwear' => 129,
    ];
    
    protected $ftp_server = 'datatransfer.cj.com';
    protected $ftp_user_name = '5008026';
    protected $ftp_user_pass = 'c2~8eE97';
    protected $file_names = [
        'SVMoscow-GOOGLE_PRODUCT_FEED_EUROPE_ENG_EUR_-shopping.xml.zip',
        'Nanushka-Nanushka_Product_Feed_-shopping.xml.zip',
    ];
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        foreach ($this->file_names as $file_name) {
            $this->getFromFtp($file_name);
            $out_file_name = $this->unzipFile($file_name);
            
            $xml = simplexml_load_file(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            
            if ($xml) {
                Product::model()->updateAll(['to_delete' => 1], 'imported = 1 AND imported_from = "' . $file_name . '"');
                $this->saveData($xml, $file_name);
                Product::model()->deleteAll('to_delete = 1 AND imported = 1 AND imported_from = "' . $file_name . '"');
                unlink(Yii::getPathOfAlias('application') . '/data/' . $file_name);
                unlink(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            }
        }
        
        Product::clearImages();
            
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
    }
    
    protected function getFromFtp($file_name)
    {
        try {
            $sftp_obj = new SftpComponent($this->ftp_server, $this->ftp_user_name, $this->ftp_user_pass);
            $sftp_obj->connect();
            $sftp_obj->getFile('/outgoing/productcatalog/229336/' . $file_name, Yii::getPathOfAlias('application') . '/data/' . $file_name);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    protected function unzipFile($file_name)
    {
        $out_file_name = str_replace('.zip', '', $file_name);
        
        $zip = new ZipArchive;
        $res = $zip->open(Yii::getPathOfAlias('application') . '/data/' . $file_name);
        if ($res === TRUE) {
            $zip->extractTo(Yii::getPathOfAlias('application') . '/data/');
            $zip->close();
        }
        
        return $out_file_name;
    }
    
    protected function saveData($data, $file_name)
    {
        //$cats = [];
        foreach ($data as $rec) {
            if ($rec->gender == 'female') {
                //$cats[] = $rec->google_product_category_name;
                
                $category_id = 0;
                if (isset($this->category_link["$rec->google_product_category_name"])) {
                    $category_id = $this->category_link["$rec->google_product_category_name"];
                }
                if ($category_id != 0) {
                    $brand = Brand::model()->find('url = "' . $this->generateUrl($rec->brand) . '"');
                    if (!$brand) {
                        $brand = Brand::model()->find('LOWER(name) = "' . strtolower($rec->brand) . '"');
                        if (!$brand) {
                            $brand_variant = BrandVariant::model()->find('url = "' . $this->generateUrl($rec->brand) . '"');
                            if (!$brand_variant) {
                                $brand_variant = BrandVariant::model()->find('LOWER(name) = "' . strtolower($rec->brand) . '"');
                                if (!$brand_variant) {
                                    $brand = new Brand();
                                    $brand->url = $this->generateUrl($rec->brand);
                                    $brand->generate_url = false;
                                    $brand->name = $rec->brand;
                                    $brand->save();
                                }
                            }
                            if ($brand_variant) {
                                $brand = Brand::model()->findByPk($brand_variant->brand_id);
                            }
                        }
                    }
                    $brand_id = $brand->id;
                    
                    $model = Product::model()->find("direct_url = '" . $this->getDirectUrl($rec->link) . "'");
                    if (!$model) {
                        if ($file_name == 'Nanushka-Nanushka_Product_Feed_-shopping.xml.zip') {
                            foreach ($rec->additional_image_link as $additional_image_link) {
                                $image = $this->getImage($additional_image_link);
                                break;
                            }
                        } else {
                            $image = $this->getImage($rec->image_link);
                        }
                        
                        
                        if ($image) {
                            $model = new Product();
                            $model->user_id = 185;
                            $model->category_id = $category_id;
                            $model->brand_id = $brand_id;
                            $model->title = "$rec->title";
                            $model->description = "$rec->description";
                            $model->image1 = $image;
                            $model->color = "$rec->color";
                            $model->price = isset($rec->sale_price) ? str_replace(' EUR', '', "$rec->sale_price") : str_replace(' EUR', '', "$rec->price");
                            $model->init_price = str_replace(' EUR', '', "$rec->price");
                            $model->condition = 1;
                            $model->direct_url = $this->getDirectUrl($rec->link);
                            $model->external_sale = 1;
                            $model->status = 'active';
                            $model->imported = 1;
                            $model->to_delete = 0;
                            $model->imported_from = $file_name;
                            $model->save();
                        }
                    } else {
                        if ($model->price != $rec->sale_price) {
                            $model->price = $rec->sale_price;
                        }
                        if ($model->init_price != $rec->price) {
                            $model->init_price = $rec->price;
                        }
                        $model->title = $rec->title;
                        $model->brand_id = $brand_id;
                        $model->image1 = $image;
                        $model->to_delete = 0;
                        $model->save();
                    }
                }
            }
        }
        //print_r(array_unique($cats));
    }
    
    protected function generateUrl($name)
    {
        $url = trim(strtolower($name));
        $url = str_replace(' ', '-', $url);
        $url = str_replace('--', '-', $url);
        $url = str_replace(array('\'', '.', ',', '&', '*', '/'), "", $url);
        
        return $url;
    }
    
    protected function getDirectUrl($full_url)
    {
        $parsed = parse_url($full_url);
        $query = $parsed['query'];
        parse_str($query, $params);
        $parsed = parse_url($params['url']);
        
        return (!empty($parsed['scheme']) ? $parsed['scheme'] . '://' : "") . $parsed['host'] . $parsed['path']; 
    }
    
    protected function getImage($img_path)
    {
        $main_upload_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR;
        
        if (($pos_s = strpos($img_path, '?')) !== false) {
            $img_path = substr($img_path, 0, $pos_s);
        }
        $arr = explode('/', $img_path);
        $f_name = end($arr);
        
        $image = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
        
        if (ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0)) {
            return $image;
        }
        
        return false;
    }
}