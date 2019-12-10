<?php

class ImportTdCommand extends CConsoleCommand
{
    protected $category_link = [
        'WOMAN_SHOES_Tabi boots & Ankle boots' => 140,
        'WOMAN_TOPS & TEES_Short sleeve t-shirts' => 162,
        'WOMAN_TOPS & TEES_Tops' => 162,
        'WOMAN_SHIRTS_Long sleeve shirts' => 162,
        'WOMAN_BAGS_Shoulder bags' => 186,
        'WOMAN_Small Leather Goods_Wallets' => 193,
        'WOMAN_ACCESSORIES_Scarves and Stoles' => 191,
        'WOMAN_Small Leather Goods_Key rings' => 193,
        'WOMAN_JEWELRY _Necklaces' => 148,
        'WOMAN_SHOES_Ankle boots' => 140,
        'WOMAN_SHOES_Ballet flats' => 136,
        'WOMAN_SHOES_Tabi ballet flats' => 136,
        'WOMAN_SHOES_Sneakers' => 138,
        'WOMAN_PANTS_Jeans' => 155,
        'WOMAN_PANTS_Casual pants' => 177,
        'WOMAN_DRESSES_Jumpsuits' => 94,
        'WOMAN_PANTS_Shorts and Bermudas' => 178,
        'WOMAN_SWEATERS_V-neck sweaters' => 94,
        'WOMAN_SWEATERS_Sweatshirts' => 162,
        'WOMAN_DRESSES_Dresses' => 153,
        'WOMAN_SKIRTS_Skirts' => 179,
        'WOMAN_SWEATERS_Cardigans' => 161,
        'WOMAN_COATS & JACKETS_Jackets' => 154,
        'WOMAN_COATS & JACKETS_Blazers' => 154,
        'WOMAN_COATS & JACKETS_Coats and Trenches' => 154,
        'WOMAN_BAGS_Backpacks' => 183,
        'WOMAN_BAGS_Totes' => 187,
        'WOMAN_TOPS & TEES_Bodies' => 156,
        'WOMAN_JEWELRY _Rings' => 148,
        'WOMAN_JEWELRY _Earrings' => 148,
        'WOMAN_SHOES_Moccasins' => 135,
        'WOMAN_SWEATERS_High neck sweaters' => 94,
        'WOMAN_SHOES_Sandals' => 181,
        'WOMAN_SWEATERS_Crewneck sweaters' => 94,
        'WOMAN_SHOES_Tabi Sneakers' => 138,
        'WOMAN_SWEATERS_Hooded sweatshirts' => 94,
        'WOMAN_BAGS_Fanny packs' => 182,
        'WOMAN_BAGS_Handbags' => 188,
        'WOMAN_BAGS_Clutches' => 188,
        'WOMAN_ACCESSORIES_Hats and Caps' => 191,
        'WOMAN_SHOES_Boots' => 140,
        'WOMAN_TOPS & TEES_Long sleeve t-shirts' => 162,
        'WOMAN_SHOES_Tabi pumps' => 135,
        'WOMAN_SHOES_Pumps' => 135,
        'WOMAN_BAGS_Crossbody bags' => 182,
        'WOMAN_JEWELRY _Bracelets' => 148,
        'WOMAN_ACCESSORIES_Ornamental Objects' => 146,
        'WOMAN_Small Leather Goods_Belts' => 192,
    ];
    
    protected $data_url = 'https://api.tradedoubler.com/1.0/productsUnlimited;';
    protected $token = '9EB8F91E33D9FC2006DDFEB5D498095B28AF2C7D';
    
    protected $key = "3CMGDJJNJAU6JXYFT7GG";
    protected $secret = "bxt9eWx6kJ/E3yvNiNkRG7N9NUbvnN/cwNAFJiQkDZk";
    protected $space_name = "n2315";
    protected $region = "fra1";
    
    protected $fids = [
        '35608', // maison margiela
    ];
    
    protected $name;
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        foreach ($this->fids as $fid) {
            $url = $this->data_url . 'fid=' . $fid . '?token=' . $this->token;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            $result = curl_exec($curl);
            curl_close($curl);
            
            if ($result) {
                Product::model()->updateAll(['to_delete' => 1], 'imported = 1 AND imported_from = "TD-' . $fid . '"');
                $data = json_decode($result);
            
                $this->saveData($data, $fid);
                
                $to_delete_products = Product::model()->findAll('to_delete = 1 AND imported = 1 AND imported_from = "TD-' . $fid . '"');
                if ($to_delete_products) {
                    foreach ($to_delete_products as $to_delete) {
                        $this->removeFromCdn($to_delete->image1);
                        $to_delete->delete();
                    }
                }
            }
        }
        
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
    }
    
    protected function saveData($data, $file_name)
    {
        foreach ($data->products as $rec) {
            if ($this->isWoman($rec->fields)) {
                $category_id = 0;
                if (isset($this->category_link[$this->getCategory($rec->categories)])) {
                    $category_id = $this->category_link[$this->getCategory($rec->categories)];
                }
                
                if ($category_id != 0) {
                    $brand_file = SymbolHelper::getCorrectName($rec->brand);
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
                    
                    $model = Product::model()->find("direct_url = '" . $this->getDirectUrl($this->getLink($rec->offers)) . "'");
                    
                    $image = $this->getImage($rec->productImage->url, $brand->url, $rec->name);
                    
                    if ($image) {
                        $rate = 1;
                        $currency = Currency::getCurrencyByName($this->getCurrency($rec->offers));
                        if ($currency) {
                            $rate = $currency->currencyRate->rate;
                        }
                        
                        $sale_price = number_format(sprintf("%01.2f", $this->getCurrencyValue($rec->offers) / $rate), 2, '.', '');
                        $price = number_format(sprintf("%01.2f", $this->getInitPrice($rec->fields) / $rate), 2, '.', '');
                        
                        if (!$model) {
                            $model = new Product();
                            $model->user_id = 185;
                            $model->category_id = $category_id;
                            $model->brand_id = $brand_id;
                            $model->title = $rec->name;
                            $model->description = $rec->description;
                            $model->image1 = $image;
                            $model->color = $this->getColor($rec->fields);
                            $model->price = $sale_price;
                            $model->init_price = $price;
                            $model->condition = 1;
                            $model->direct_url = $this->getDirectUrl($this->getLink($rec->offers));
                            $model->external_sale = 1;
                            $model->status = 'active';
                            $model->imported = 1;
                            $model->to_delete = 0;
                            $model->imported_from = 'TD-' . $file_name;
                            $model->save();
                        } else {
                            if ($model->price != $sale_price) {
                                $model->price = $sale_price;
                            }
                            if ($model->init_price != $price) {
                                $model->init_price = $price;
                            }
                            $model->title = $rec->name;
                            $model->brand_id = $brand_id;
                            $model->image1 = $image;
                            $model->to_delete = 0;
                            $model->save();
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
    
    protected function removeFromCdn($path)
    {
        $path_parts = explode('/', $path);
        array_pop($path_parts);
        $path = implode('/', $path_parts);
        
        require_once(Yii::app()->basePath . "/helpers/Spaces-API-master/spaces.php");
        
        $space = new SpacesConnect($this->key, $this->secret, $this->space_name, $this->region);
        
        $space->DeleteObject($path);
    }
    
    protected function isWoman($data)
    {
        foreach ($data as $rec) {
            if ($rec->name == 'gender' && $rec->value == 'WOMAN') {
                return true;
            }
        }
        
        return false;
    }
    
    protected function getCategory($data)
    {
        foreach ($data as $rec) {
            return $rec->name;
        }
    }
    
    protected function generateUrl($name)
    {
        $url = trim(strtolower($name));
        $url = str_replace(' ', '-', $url);
        $url = str_replace(array('\'', '.', ',', '&', '*', '/', '+', ':'), "", $url);
        $url = str_replace('--', '-', $url);
        
        return $url;
    }
    
    protected function getLink($data)
    {
        foreach ($data as $rec) {
            return $rec->productUrl;
        }
    }
    
    protected function getDirectUrl($full_url)
    {
        $parsed = parse_url($full_url);
        $query = $parsed['query'];
        $pos_start = strpos($query, 'url(');
        $sub = substr($query, $pos_start + 4);
        $sub = substr($sub, 0, -1);
        
        return urldecode($sub); 
    }
    
    protected function getImage($img_path, $brand, $title)
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
        
        $arr = explode('.', $f_name);
        $ext = end($arr);
        
        $title = str_replace(array('\'', '.', ',', '&', '*', '/', '"', '|'), "", $title);
        $image = strtolower($brand) . '-' . $this->generateUrl($title) . '-' . uniqid() . '.' . $ext;
        
        if (ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0)) {
            return $image;
        }
        
        return false;
    }
    
    protected function getCurrency($data)
    {
        foreach ($data as $rec) {
            foreach ($rec->priceHistory as $res) {
                return $res->price->currency;
            }
        }
    }
    
    protected function getCurrencyValue($data)
    {
        foreach ($data as $rec) {
            foreach ($rec->priceHistory as $res) {
                return $res->price->value;
            }
        }
    }
    
    protected function getColor($data)
    {
        foreach ($data as $rec) {
            if ($rec->name == 'colors') {
                return $rec->value;
            }
        }
    }
    
    protected function getInitPrice($data)
    {
        foreach ($data as $rec) {
            if ($rec->name == 'previousPrice') {
                return $rec->value;
            }
        }
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
}