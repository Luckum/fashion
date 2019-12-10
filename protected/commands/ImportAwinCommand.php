<?php

class ImportAwinCommand extends CConsoleCommand
{
    protected $category_link = [
        'Woman>Shoes>Pumps' => 135,
        'Woman>Shoes>Sneakers' => 138,
        'Woman>Shoes>Sandals' => 181,
        'Woman>Clothing>Coats' => 154,
        'Woman>Clothing>Topwear' => 94,
        'Woman>Clothing>Sweatshirts' => 162,
        'Woman>Clothing>Dresses' => 153,
        'Woman>Clothing>Jeans' => 155,
        'Woman>Clothing>Skirts' => 179,
        'Woman>Clothing>Knitwear' => 94,
        'Woman>Clothing>T-Shirt' => 162,
        'Woman>Clothing>Lingerie' => 156,
        'Woman>Accessories>Wallets' => 188,
        'Woman>Accessories>Belts' => 192,
        'Woman>Clothing>Shirts' => 162,
        'Woman>Clothing>Clothing' => 94,
        'Woman>Bags>Tote ' => 187,
        'Woman>Bags>Clutches' => 188,
        'Woman>Bags>Shoulder bags' => 186,
        'Woman>Bags>Waist Bag' => 182,
        'Woman>Clothing>Blouse' => 162,
        'Woman>Clothing>Pants' => 177,
        'Woman>Accessories>Hats' => 191,
        'Woman>Bags>Hand bags' => 186,
        'Woman>Shoes>Combat boots' => 140,
        'Woman>Shoes>Ballet flats' => 136,
        'Woman>Clothing>Shorts' => 178,
        'Woman>Clothing>Body' => 156,
        'Woman>Clothing>Leggins' => 94,
        'Woman>Clothing>Cardigan' => 161,
        'Woman>Clothing>Leather jackets' => 154,
        'Woman>Clothing>Furs' => 154,
        'Woman>Accessories>Scarves' => 191,
        'Woman>Bags>Backpacks' => 183,
        'Woman>Clothing>Jackets' => 154,
        'Woman>Clothing>Suits' => 94,
        'Woman>Shoes>Lace up shoes' => 138,
        'Woman>Clothing>Bomber' => 154,
        'Woman>Shoes>Loafers' => 180,
        'Woman>Clothing>Shearlings' => 94,
        'Woman>Accessories>iPhone / iPad Cases' => 195,
        'Woman>Clothing>Outerwear' => 154,
        'Woman>Clothing>Vest' => 162,
        'Woman>Accessories>Sunglasses' => 149,
        'Woman>Accessories>Jewelry' => 148,
        'Woman>Clothing>Denim' => 94,
        'Woman>Shoes>Flats' => 136,
        'Woman>Shoes>Boots' => 140,
        'Woman>Shoes>Ankle boots' => 140,
        'Woman>Shoes>texan Ankle boots' => 140,
        'Woman>Shoes>High heels Ankle boots' => 140,
        'Woman>Clothing>Casual jackets' => 154,
        'Woman>Clothing>Beachwear' => 129,
        'Woman>Bags>Borse Sport' => 182,
        "Women's Outerwear" => 154,
        "Women's Tops" => 162,
        "Bags" => 182,
        "Women's Underwear" => 194,
        "Women's Dresses & Skirts" => 179,
        "Women's Footwear" => 135,
        "Bras" => 162,
        "Women's Jewellery" => 148,
        "Women's Swimwear" => 129,
        "Women's Accessories" => 146,
        "Women's Trousers" => 177,
        "Women's Suits" => 94,
        "Women's Sportswear" => 94,
        'Womens - Lingerie' => 156,
        'Womens - Jeans' => 155,
        'Flats [Women / Footwear]' => 136,
        'Sunglasses [Clothing/Women/Accessories]' => 149,
        'Boots [Clothing/Women/Footwear]' => 140,
        'Womens - Bras' => 162,
        'Briefs [Clothing/Women/Lingerie]' => 156,
        'Bags [Clothing/Women/Accessories]' => 182,
        'Shoes [Clothing/Women/Footwear]' => 135,
        'Purses & Wallets [Clothing/Wmn/Acc]' => 193,
        'Bras [Clothing/Women/Lingerie]' => 162,
        'Body Care [Health and Beauty]' => 196,
        'Coats [Clothing/Women/Clothing]' => 154,
        'Tops [Clothing/Women/Clothing]' => 162,
        'Womens - Bags' => 182,
        'T-Shirts & Tops [Clthng/W/Clthng]' => 162,
        'Trousers [Clothing/Women/Clothing]' => 177,
        'Pass/card Holders [Clothing/W/Acc]' => 193,
        'Womens - Accessories - Jewellery' => 148,
        'Dresses [Clothing/Women/Clothing]' => 153,
        'Sandals [Women / Footwear]' => 181,
        'Womens - Swimwear' => 129,
        'Shirts [Clothing/Women/Clothing]' => 162,
        'Skirts [Clothing/Women/Clothing]' => 179,
        'Sweatshirts [Clothing/W/Clothing]' => 162,
        'Watches [Clothing/W/Accessories]' => 146,
        'Trainers [Clothing/Women/Footwear]' => 135,
        'Womens - Sweatpants' => 177,
        'Knitwear [Clothing/Women/Clothing]' => 94,
        'Womens - Footwear - Trainers' => 135,
        'Womens - Nightwear' => 94,
        'Scarves, Gloves & Hats [Cloth/W/Ac]' => 191,
        'Heels [Women / Footwear]' => 137,
        'Womens - Footwear - Shoes' => 135,
        'Womens - Knickers' => 135,
        'Shorts [Clothing/Women/Clothing]' => 178,
        'Womens - Accessories - Sunglasses' => 149,
        'Womens - Vests' => 162,
        'Sunglasses' => 149,
        'Sandals/Flip Flops [Cloth/W/Ftwear]' => 181,
        'Womens - Footwear - Boots' => 140,
        'Womens - Luggage' => 182,
        'Womens - Loungewear' => 94,
        'Womens - Accessories - Belts' => 192,
        'Womens - Accessories - Hats' => 191,
        'Belts [Clothing/Women/Accessories]' => 192,
        'Womens - Accessories - Gloves' => 191,
        'Socks [Clothing/Women/Clothing]' => 156,
        'Womens - Accessories - Hair' => 196,
        'Womens - Accs - Fashion Jewellery' => 148,
        'Womens - Accessories - Scarves' => 191,
        'Womens - Accessories - Purses' => 193,
        'Womens - Polo Shirts' => 162,
        'Bags' => 182,
    ];
    
    protected $product_data_url = 'https://productdata.awin.com/datafeed/list/apikey/';
    protected $api_key = 'd87bbceb863c34b80154bfd1e025b22f';
    
    protected $key = "3CMGDJJNJAU6JXYFT7GG";
    protected $secret = "bxt9eWx6kJ/E3yvNiNkRG7N9NUbvnN/cwNAFJiQkDZk";
    protected $space_name = "n2315";
    protected $region = "fra1";
    
    protected $product_file_name = 'datafeeds.csv';
    protected $feed_file_name = 'feed.csv.gz';
    
    protected $feed_id = [
        '33577', // Deliberti
        '21675', // W Concept
        '11149', // coggles
        '28991', //charles&keith
    ];
    
    protected $feedMap = [
        '33577' => [
            'category' => 12,
            'brand' => 10,
            'price' => 18,
            'init_price' => 28,
            'url' => 15,
            'image' => 27,
            'title' => 13,
            'description' => 14,
            'color' => 22,
            'currency' => 'USD',
        ],
        '21675' => [
            'category' => 8,
            'brand' => 10,
            'price' => 19,
            'init_price' => 20,
            'url' => 17,
            'image' => 27,
            'title' => 15,
            'description' => 16,
            'color' => 24,
            'currency' => 'USD',
        ],
        '11149' => [
            'category' => 12,
            'brand' => 10,
            'price' => 25,
            'init_price' => 26,
            'url' => 20,
            'image' => 52,
            'title' => 17,
            'description' => 18,
            'color' => 33,
            'currency' => 'USD',
        ],
        '28991' => [
            'category' => 8,
            'brand' => 2,
            'price' => 17,
            'init_price' => 18,
            'url' => 15,
            'image' => 16,
            'title' => 13,
            'description' => 14,
            'color' => 20,
            'currency' => 'EUR',
        ],
    ];
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        $this->getProductDataFile();
        $fileHandler = fopen(Yii::getPathOfAlias('application') . '/data/' . $this->product_file_name, "r");
        $feeds = $links = [];
        
        if ($fileHandler !== false) {
            while (($data = fgetcsv($fileHandler , 3000, ",")) !== false) {
                $feeds[] = $data;
            }
            fclose($fileHandler);
        }
        
        if (count($feeds)) {
            foreach ($feeds as $feed) {
                if (in_array($feed[4], $this->feed_id)) {
                    $link = $feed[11];
                    $urlHeaders = get_headers($link);
                
                    if (strpos($urlHeaders[0], '200') !== false) {
                        file_put_contents(Yii::getPathOfAlias('application') . '/data/' . $this->feed_file_name, fopen($link, 'r'));
                        
                        $out_file_name = $this->unzipFile($this->feed_file_name);
                        
                        $fileHandler = fopen(Yii::getPathOfAlias('application') . '/data/' . $out_file_name, "r");
                        $products = [];

                        if ($fileHandler !== false) {
                            while (($data = fgetcsv($fileHandler , 15000, ",")) !== false) {
                                $products[] = $data;
                            }
                            fclose($fileHandler);
                        }
                        
                        if ($products) {
                            Product::model()->updateAll(['to_delete' => 1], 'imported = 1 AND imported_from = "awin-' . $feed[4] . '"');
                            $this->saveData($products, $feed[4]);
                            
                            $to_delete_products = Product::model()->findAll('to_delete = 1 AND imported = 1 AND imported_from = "awin-' . $feed[4] . '"');
                            if ($to_delete_products) {
                                foreach ($to_delete_products as $to_delete) {
                                    $this->removeFromCdn($to_delete->image1);
                                    $to_delete->delete();
                                }
                            }
                            unlink(Yii::getPathOfAlias('application') . '/data/' . $this->feed_file_name);
                            unlink(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
                        }
                    }
                }
            }
        }
        
        unlink(Yii::getPathOfAlias('application') . '/data/' . $this->product_file_name);
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
    }
    
    protected function getProductDataFile()
    {
        file_put_contents(Yii::getPathOfAlias('application') . '/data/' . $this->product_file_name, fopen($this->product_data_url . $this->api_key, 'r'));
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
    
    protected function saveData($products, $feedId)
    {
        //$cats = [];
        foreach ($products as $product) {
            if ($product[0] != 'data_feed_id' && $product[0] != '') {
                $mapIdx = $this->feedMap[$feedId];
                //$cats[] = $product[$mapIdx['category']];
                
                $category_id = 0;
                if (isset($this->category_link[$product[$mapIdx['category']]])) {
                    $category_id = $this->category_link[$product[$mapIdx['category']]];
                }
                
                if ($category_id != 0) {
                    $brand_file = SymbolHelper::getCorrectName($product[$mapIdx['brand']]);
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
                    
                    $model = Product::model()->find("direct_url = '" . $product[$mapIdx['url']] . "'");
                    
                    $image = $this->getImage($product[$mapIdx['image']], $brand->url, $product[$mapIdx['title']]);
                    
                    if ($image) {
                        $rate = 1;
                        $currency = Currency::getCurrencyByName($mapIdx['currency']);
                        if ($currency) {
                            $rate = $currency->currencyRate->rate;
                        }
                        
                        $sale_price = number_format(sprintf("%01.2f", $product[$mapIdx['price']] / $rate), 2, '.', '');
                        $price = number_format(sprintf("%01.2f", $product[$mapIdx['init_price']] / $rate), 2, '.', '');
                        
                        if (!$model) {
                            $model = new Product();
                            $model->user_id = 185;
                            $model->category_id = $category_id;
                            $model->brand_id = $brand_id;
                            $model->title = $product[$mapIdx['title']];
                            $model->description = $product[$mapIdx['description']];
                            $model->image1 = $image;
                            $model->color = $product[$mapIdx['color']];
                            $model->price = $sale_price;
                            $model->init_price = $price;
                            $model->condition = 1;
                            $model->direct_url = $product[$mapIdx['url']];
                            $model->external_sale = 1;
                            $model->status = 'active';
                            $model->imported = 1;
                            $model->to_delete = 0;
                            $model->imported_from = 'awin-' . $feedId;
                            $model->save();
                        } else {
                            if ($model->price != $sale_price) {
                                $model->price = $sale_price;
                            }
                            if ($model->init_price != $price) {
                                $model->init_price = $price;
                            }
                            $model->title = $product[$mapIdx['title']];
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
        //print_r(array_unique($cats));
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
    
    protected function generateUrl($name)
    {
        $url = trim(strtolower($name));
        $url = str_replace(' ', '-', $url);
        $url = str_replace(array('\'', '.', ',', '&', '*', '/', '+', ':'), "", $url);
        $url = str_replace('--', '-', $url);
        
        return $url;
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