<?php

class ImportFlexCommand extends CConsoleCommand
{
    protected $category_link = [
        'Apparel & Accessories > Clothing' => 94,
        'Apparel & Accessories' => 94,
        'Apparel & Accessories > Shoes' => 135,
        'Apparel & Accessories > Clothing Accessories > Sunglasses' => 149,
        'Apparel & Accessories > Clothing > Shirts & Tops' => 162,
        'Apparel & Accessories > Clothing > Pants' => 177,
        'Apparel & Accessories > Clothing > Dresses' => 153,
        'Apparel & Accessories > Jewelry > Watches' => 148,
        'Apparel & Accessories > Clothing > Swimwear' => 129,
        'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets' => 154,
        'Apparel & Accessories > Clothing > Skirts' => 179,
        'Apparel & Accessories > Handbags, Wallets & Cases > Handbags' => 188,
        'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers' => 94,
        'Home & Garden' => 199,
        'Health & Beauty' => 196,
        'Apparel & Accessories > Clothing Accessories' => 146,
        'Luggage & Bags > Luggage Accessories' => 146,
        'Apparel & Accessories > Jewelry' => 148,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body Gift Sets' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Skin Care' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup' => 196,
        'Home & Garden > Decor > Home Fragrance Accessories' => 199,
        'Health & Beauty > Jewelry Cleaning & Care > Jewelry Cleaning Tools' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body' => 196,
        'Accessories' => 146,
        'SMALL LEATHER GOODS' => 193,
        'BACKPACKS' => 183,
        'Shoulder bags' => 186,
        'TOTES' => 187,
        'CLUTCHES' => 188,
        'MESSENGER BAGS' => 182,
        'PANTS' => 177,
        'T BY  PANTS' => 177,
        'SHORTS' => 178,
        'T BY  SHORTS' => 178,
        'SKIRTS' => 179,
        'T BY  SKIRTS' => 179,
        'T BY  3/4 Length dresses' => 153,
        '3/4 Length dresses' => 153,
        'T BY  Short Dresses' => 153,
        'Short Dresses' => 153,
        'T BY  KNIT DRESSES' => 153,
        'KNIT DRESSES' => 153,
        'Long dresses' => 153,
        'JACKETS AND OUTERWEAR' => 154,
        'T BY  JACKETS AND OUTERWEAR' => 154,
        'Short' => 178,
        'Boots' => 140,
        'FLATS' => 136,
        'Heels' => 137,
        'Sneakers' => 138,
        'SANDALS' => 181,
        'T BY  TOPS' => 162,
        'TOPS' => 162,
        'Blouses' => 162,
        'Short sleeve t' => 162,
        'T BY  SWEATERS' => 161,
        'DENIM' => 94,
        'Jewelry' => 148,
    ];
    
    protected $ftp_server = 'ftp.flexoffers.com';
    protected $ftp_user_name = 'kontakt@n2315.com';
    protected $ftp_user_pass = 'Neon23152315#';
    
    protected $key = "3CMGDJJNJAU6JXYFT7GG";
    protected $secret = "bxt9eWx6kJ/E3yvNiNkRG7N9NUbvnN/cwNAFJiQkDZk";
    protected $space_name = "n2315";
    protected $region = "fra1";
    
    protected $file_names_part_1 = [
        '160518/2.23288B42649C3C46/',
        '171455/1.8FDC/',
        '181599/1.A3BC/'
    ];
    
    protected $file_names_part_2 = [
        '185499/1.A2BE/',
        '197461/1.A6F0/',
        //'203945/1.AAFB/', - absent gender
    ];
    
    protected $_file_name = '1172566_Products.xml.gz';
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        $str = 'file_names_part_';
        
        foreach ($this->{$str . $args[0]} as $file_name) {
            $this->getFromFtp($file_name);
            $out_file_name = $this->unzipFile($this->_file_name);
            
            //$out_file_name = '1172566_Products.xml';
            
            $xml = simplexml_load_file(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            if ($xml) {
                Product::model()->updateAll(['to_delete' => 1], 'imported = 1 AND imported_from = "' . $file_name . $this->_file_name . '"');
                
                $this->saveData($xml, $file_name);
                
                $to_delete_products = Product::model()->findAll('to_delete = 1 AND imported = 1 AND imported_from = "' . $file_name . $this->_file_name . '"');
                if ($to_delete_products) {
                    foreach ($to_delete_products as $to_delete) {
                        $this->removeFromCdn($to_delete->image1);
                        $to_delete->delete();
                    }
                }
                
                unlink(Yii::getPathOfAlias('application') . '/data/' . $this->_file_name);
                unlink(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            }
        }
        
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
    }
    
    protected function getFromFtp($file_name)
    {
        $curl = curl_init();
        $file = fopen(Yii::getPathOfAlias('application') . '/data/' . $this->_file_name, 'w');
        curl_setopt($curl, CURLOPT_URL, "ftp://" . $this->ftp_server . "/ProductFeeds/XML/" . $file_name . $this->_file_name);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_IGNORE_CONTENT_LENGTH, 1);
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_USERPWD, $this->ftp_user_name . ":" . $this->ftp_user_pass);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }
    
    protected function unzipFile($file_name)
    {
        $buffer_size = 4096;
        $out_file_name = str_replace('.gz', '', $file_name);

        $file = gzopen(Yii::getPathOfAlias('application') . '/data/' . $file_name, 'rb');
        $out_file = fopen(Yii::getPathOfAlias('application') . '/data/' . $out_file_name, 'wb');

        while(!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }

        fclose($out_file);
        gzclose($file);
        
        return $out_file_name;
    }
    
    protected function saveData($data, $file_name)
    {
        $cats = [];
        foreach ($data->product as $rec) {
            //print_r($rec);
            //die();
            if ((strtolower($rec->gender) == 'female' || strtolower($rec->gender) == 'womens') && strtolower($rec->isInStock) == 'true') {
                $category_id = 0;
                if (isset($this->category_link["$rec->category"])) {
                    $category_id = $this->category_link["$rec->category"];
                }
                if ($file_name == '171455/1.8FDC/') {
                    if (isset($this->category_link[$this->getCategory("$rec->name")])) {
                        $category_id = $this->category_link[$this->getCategory("$rec->name")];
                    }
                }
                if ($category_id != 0) {
                    $brand_file = isset($rec->brand) ? $rec->brand : (isset($rec->manufacturer) ? $rec->manufacturer : '');
                    
                    if (!empty($brand_file)) {
                        $brand = Brand::model()->find('url = "' . $this->generateUrl($brand_file) . '"');
                        if (!$brand) {
                            $brand = Brand::model()->find('LOWER(name) = "' . strtolower($brand_file) . '"');
                            if (!$brand) {
                                $brand_variant = BrandVariant::model()->find('url = "' . $this->generateUrl($brand_file) . '"');
                                if (!$brand_variant) {
                                    $brand_variant = BrandVariant::model()->find('LOWER(name) = "' . strtolower($brand_file) . '"');
                                    if (!$brand_variant) {
                                        $brand = new Brand();
                                        $brand->url = $this->generateUrl($brand_file);
                                        $brand->generate_url = false;
                                        $brand->name = $brand_file;
                                        $brand->save();
                                    }
                                }
                                if ($brand_variant) {
                                    $brand = Brand::model()->findByPk($brand_variant->brand_id);
                                }
                            }
                        }
                        $brand_id = $brand->id;
                        
                        $model = Product::model()->find('direct_url = "' . $rec->deepLinkUrl . '"');
                        
                        $image = $this->getImage($rec->imageUrl);
                        
                        $currency = Currency::getCurrencyByName(strtoupper($rec->priceCurrency));
                        if ($currency) {
                            $rate = $currency->currencyRate->rate;
                        } else {
                            if (strtoupper($rec->priceCurrency) == 'AUD') {
                                $rate = 0.63;
                            } else if (strtoupper($rec->priceCurrency) == 'HKD') {
                                $rate = 0.12;
                            }
                        }
                        
                        if ($image) {
                            if (!$model) {
                                $model = new Product();
                                $model->user_id = 185;
                                $model->category_id = $category_id;
                                $model->brand_id = $brand_id;
                                $model->title = $file_name == '171455/1.8FDC/' ? $this->getNameFromDesc("$rec->shortDescription") : "$rec->name";
                                $model->description = "$rec->description";
                                $model->image1 = $image;
                                $model->color = "$rec->color";
                                $model->price = isset($rec->salePrice) ? $rec->salePrice * $rate : $rec->price * $rate;
                                $model->init_price = $rec->price * $rate;
                                $model->condition = 1;
                                $model->direct_url = "$rec->deepLinkUrl";
                                $model->external_sale = 1;
                                $model->status = 'active';
                                $model->imported = 1;
                                $model->to_delete = 0;
                                $model->imported_from = $file_name . $this->_file_name;
                                $model->save();
                            } else {
                                if ($model->screpped != 1) {
                                    if ($model->price != $rec->salePrice * $rate) {
                                        $model->price = $rec->salePrice * $rate;
                                    }
                                    if ($model->init_price != $rec->price * $rate) {
                                        $model->init_price = $rec->price * $rate;
                                    }
                                    $model->title = "$rec->name";
                                    $model->brand_id = $brand_id;
                                    $model->image1 = $image;
                                    $model->to_delete = 0;
                                    $model->save();
                                }
                            }
                            $path = $this->setCdnPath($model->id) . '/' . $model->image1;
                            $image_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR . 'medium/' . $model->image1;
                            if ($this->copyToCdn($image_path, $path)) {
                                $model->image1 = $path;
                                if ($model->save()) {
                                    unlink($image_path);
                                }
                            }
                        }
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
    
    protected function getImage($img_path)
    {
        $main_upload_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR;
        
        if (($pos_s = strpos($img_path, '?')) !== false) {
            $img_path = substr($img_path, 0, $pos_s);
        }
        if (($pos_s = strpos($img_path, '$')) !== false) {
            $img_path = substr($img_path, 0, $pos_s);
        }
        $arr = explode('/', $img_path);
        $f_name = end($arr);
        
        if (!pathinfo($f_name, PATHINFO_EXTENSION)) {
            $f_name .= '.jpg';
        }
        
        $image = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
        
        if (ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0)) {
            return $image;
        }
        
        return false;
    }
    
    protected function setCdnPath($id)
    {
        $path = sprintf('%08x', $id);
        $path = preg_replace('/^(.{2})(.{2})(.{2})(.{2})$/', '$1/$2/$3/$4', $path);
        return $path;
    }
    
    protected function copyToCdn($uploadFile, $path)
    {
        require_once(Yii::app()->basePath . "/helpers/amazon-s3-php-class-master/S3.php");
        
        $s3 = new S3($this->key, $this->secret);
        
        if ($s3->putObjectFile($uploadFile, $this->space_name, $path, S3::ACL_PUBLIC_READ)) {
            return true;
        }
        
        return false;
    }
    
    protected function removeFromCdn($path)
    {
        require_once(Yii::app()->basePath . "/helpers/Spaces-API-master/spaces.php");
        
        $space = new SpacesConnect($this->key, $this->secret, $this->space_name, $this->region);
        
        $space->DeleteObject($path);
    }
    
    protected function getCategory($title)
    {
        $title_parts = explode('-', $title);
        $cat = str_replace('ALEXANDER WANG', '', $title_parts[0]);
        return trim($cat);
    }
    
    protected function getNameFromDesc($title)
    {
        $title_parts = explode('.', $title);
        return $title_parts[0];
    }
}