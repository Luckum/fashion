<?php

class ImportCommand extends CConsoleCommand
{
    protected $category_link = [
        'Ladies Beachwear' => 129,
        'Ladies Accessories' => [
            'Sunglasses' => 149,
            'Iphone Cases' => 195,
            'Hats' => 191,
            'Stationary' => 146,
            'Wallets' => 193,
            'Accessories' => 146,
            'Bag Straps' => 193,
            'Purses' => 193,
            'Card Holders' => 193,
            'Collars' => 193,
            'Scarves' => 191,
            'Fur Scarves' => 191,
            'Continental Wallets' => 193,
            'Key Fobs' => 146,
            'Fine Knit Scarves' => 191,
            'Compact Wallets' => 193,
            'Caps' => 199,
            'Fabric Belts' => 192,
            'Silk Scarves' => 191,
            'Heavy Knit Scarves' => 191,
            'Magazines' => 199,
            'Waist Belts' => 192,
            'Headband' => 191,
            'Straw Hats' => 191,
            'Beanies' => 191,
            'Washbags' => 199,
            'Wraps' => 199,
            'Leather Gloves' => 191,
            'Knitted Gloves' => 191,
            'Turbans' => 191,
            'Felt Hats' => 191,
            'Fur Hats' => 191,
            'Cat Eye Sunglasses' => 149,
            'Berets' => 191,
            'Opticals' => 149,
            'Recatangle Sunglasse' => 149,
            'Hair Scrunchie' => 199,
            'Hair Clip' => 199,
            'Make-Up Bags' => 199,
            'Oversized Round Sung' => 149,
            'Square Sunglasses' => 149,
            'Oval Sunglasses' => 149,
            'Small Cat Eye' => 149,
            'Fashion Sunglasses' => 149,
            'Flat Top Sunglasses' => 149,
            'Aviator Sunglasses' => 149,
            'Classic Round Sungla' => 149,
            'Ponchos' => 199,
            'Bucket Hat' => 191,
            'Umbrellas' => 146,
            'Shawls' => 191,
            'Studded Belts' => 192,
            'Plain Belts' => 192,
            'Skinny Belts' => 192,
            'Occasion Hats' => 191,
            'Classic Round Frame' => 199,
            'Square Frame' => 199,
            'Aviator Frame' => 199,
            'Cat Eye Frame' => 199,
            'Oversized Round Fram' => 199,
            'Rectangle Frame' => 199,
            'Hair Accessories' => 199,
            'Fashion Frame' => 199,
            'Snoods' => 191,
            'Samll Round Sunglass' => 149,
            'Logo Belts' => 192,
            'Blankets' => 199,
            'Belts' => 192,
            'Wrap Belts' => 192,
            'default' => 146,
        ],
        'Ladies Rtw' => [
            'Light Crew Necks' => 161,
            'Day Tops' => 162,
            'Ponchos' => 94,
            'Occasion Dress' => 153,
            'Evening Gowns' => 153,
            'Skinny Jeans' => 155,
            'Formal Shirts' => 162,
            'Evening Tops' => 162,
            'Cocktail Dresses' => 153,
            'Long Day Dresses' => 153,
            'Relaxed Trousers' => 177,
            'Occasion Jackets' => 154,
            'Wide Leg Trousers' => 177,
            'Day Coats' => 154,
            'Heavy Crew Necks' => 161,
            'Tailored Trousers' => 177,
            'Straight Jeans' => 155,
            'V Necks' => 161,
            'Cropped Trousers' => 177,
            'Fur Jackets' => 154,
            'Camis' => 162,
            'Slip Dresses' => 153,
            'Blouses' => 162,
            'Long Culottes' => 177,
            'Cropped Jeans' => 155,
            'Midi Skirts' => 179,
            'Tanks' => 162,
            'Short Day Dresses' => 153,
            'Evening Coats' => 154,
            'Casual Jackets' => 154,
            'Short Skirts' => 179,
            'Wide Leg Jeans' => 155,
            'Short Sleeve T-Shrts' => 162,
            'Light Cardigans' => 161,
            'Long Skirts' => 179,
            'All In Ones Long' => 176,
            'Tunics' => 162,
            'Sweatshirts' => 162,
            'Sweatpants' => 177,
            'Furs Coats' => 154,
            'Tailored Jackets' => 154,
            'Light Roll Necks' => 161,
            'Straight Leg' => 177,
            'Heavy Cardigans' => 161,
            'Padded Coats' => 154,
            'Casual Shirts' => 162,
            'Leggings' => 177,
            'Shorts' => 178,
            'Boyfriend Jeans' => 155,
            'Parkas' => 161,
            'Bomber Jackets' => 154,
            'Skinny Trousers' => 177,
            'Knee Skirts' => 179,
            'Shearling Coats' => 154,
            'Crop Tops' => 162,
            'Flared Jeans' => 155,
            'Pencil Skirts' => 179,
            'Trench Coats' => 154,
            'Denim Jackets' => 154,
            'Capes' => 94,
            'Heavy Roll Necks' => 161,
            'Hoodys' => 161,
            'All In Ones Short' => 176,
            'Bodies' => 156,
            'Leather Trousers' => 177,
            'Long Sleeve T-Shirts' => 162,
            'Short Culottes' => 178,
            'Leather Jackets' => 154,
            'Padded Jackets' => 154,
            'Gilets' => 162,
            'Knitted Dresses' => 153,
            'Short Dresses' => 153,
            'Jersey Dresses' => 153,
            'Bootcut Jeans' => 155,
            'Pyjama Sets' => 156,
            'T-Shirts' => 162,
            'Trackpants' => 177,
            'Leather Biker Jkts' => 154,
            'Boat Necks' => 161,
            'Biker Jackets' => 154,
            'Slouch Skinny' => 177,
            'Long Dresses' => 153,
            'default' => 94,
        ],
        'Ladies Homeware' => 199,
        'Ladies Jewellery' => 148, 
        'Ladies Fine Jewellery' => 148,
        'Ladies Shoes' => [
            'High Heel Sandals' => 181,
            'Slip Ons' => 136,
            'High Heels' => 137,
            'Slippers' => 136,
            'Mid Heel Ankle Boots' => 140,
            'Loafers' => 180,
            'Kitten Heels' => 137,
            'Flat Ankle Boots' => 140,
            'Espadrilles' => 136,
            'Flat Sandals' => 181,
            'Slides' => 136,
            'Mid Heels' => 137,
            'Backless Loafers' => 180,
            'Wedges' => 135,
            'Flatforms' => 136,
            'Pointed Toe Flats' => 136,
            'Mid Heel Sandals' => 181,
            'Mid Heel Knee Boots' => 140,
            'Lace Ups' => 138,
            'Apres-Ski' => 140,
            'Low Tops' => 138,
            'Over Knee Boots' => 140,
            'High Heel Ankle Bts' => 140,
            'High Heel Knee Boots' => 140,
            'Mules' => 136,
            'Ballet Flats' => 136,
            'High Tops' => 138,
            'Flat Knee Boots' => 140,
            'Rain Boots' => 140,
            'Platforms' => 137,
            'default' => 135,
        ],
        'Ladies Activewear' => [
            'Leggings' => 177,
            'Sports Bra' => 162,
            'Tank Tops' => 162,
            'Performance Jackets' => 154,
            'Sweatpants' => 177,
            'Bikini Bottom' => 129,
            'Swimsuits' => 129,
            'V Necks' => 161,
            'All In Ones Shorts' => 176,
            'Technical Ski Jkts' => 154,
            'Skinny Ski Pants' => 177,
            'Gloves' => 191,
            'Hats' => 191,
            'Technical Ski Pants' => 177,
            'Sweatshirts' => 162,
            'Technical Ski All In' => 176,
            'High Impact Bra' => 162,
            'Accessories' => 146,
            'All In Ones Long' => 176,
            'Long Sleeve T-Shirts' => 162,
            'Light Crew Necks' => 161,
            'Track Pants' => 177,
            'Light Roll Necks' => 161,
            'Cropped Leggings' => 177,
            'Hair Accessories' => 146,
            'Bodysuits' => 156,
            'Short Sleeve T-Shrts' => 162,
            'Shorts' => 178,
            'Low Impact Bra' => 162,
            'Bomber Jacket' => 154,
            'Bikini Set' => 129,
            'Performance Skirts' => 179,
            'Heavy Roll Necks' => 161,
            'Light Cardigans' => 161,
            'Base Layer Jacket' => 154,
            'Yoga Mat' => 146,
            'Bikini Top' => 129,
            'Socks' => 194,
            'Mid Layer Jacket' => 154,
            'default' => 94,
        ],
        'Ladies Lingerie' => 156,
        'Ladies Bags' => [
            'Shoulder Bags' => 186,
            'Travel Bags' => 189,
            'Cross Body Bags' => 193,
            'Clutch Bags' => 185,
            'Pouches' => 185,
            'Handbags' => 186,
            'Tote Bags' => 187,
            'Basket Bags' => 188,
            'Cross Body Bags S' => 193,
            'Tote Bags Ns' => 187,
            'Tote Bags Ew' => 187,
            'Cross Body Bags Mini' => 193,
            'Shoulder Bags Small' => 186,
            'Bucket Bags' => 188,
            'Shoulder Bags Medium' => 186,
            'Beach Bags' => 188,
            'Bumbags' => 182,
            'Carry On Luggage' => 182,
            'Suitcases' => 182,
            'Backpacks' => 183,
            'Vanity Cases' => 182,
            'default' => 182,
        ],
        '85% Silk 15% Cashmere' => 94,
        '43% Silk 35% Cashmere 22% Cotton' => 94,
        'Heavyweight 100% Cashmere' => 94,
        'Featherweight 85%silk 15%cashmere' => 94,
        '85% Cotton 15% Cashmere' => 94,
        '55% Silk 45% Cashmere' => 94,
        'Lightweight 70% Wool 30% Cashmere' => 94,
        '100% Featherweight Wool' => 94,
        '70% Wool 30% Cashmere' => 94,
        'Super Fine 100% Cashmere' => 94,
        'Lightweight 85% Cotton 15% Cashmere' => 94,
        '100% Cashmere' => 94,
    ];
    
    protected $ftp_server = 'aftp.linksynergy.com';
    protected $ftp_user_name = 'n2315_';
    protected $ftp_user_pass = 'GyTLMNP';
    protected $file_names = [
        '35725_3620548_mp.txt.gz',
        '43650_3620548_mp.txt.gz'
    ];
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        foreach ($this->file_names as $file_name) {
            $this->getFromFtp($file_name);
            $out_file_name = $this->unzipFile($file_name);
            
            $fileHandler = fopen(Yii::getPathOfAlias('application') . '/data/' . $out_file_name, "r");
            $products = [];

            if ($fileHandler !== false) {
                while (($data = fgetcsv($fileHandler , 2000, "|")) !== false) {
                    $products[] = $data;
                }
                fclose($fileHandler);
            }
            
            if ($products) {
                Product::model()->updateAll(['to_delete' => 1], 'imported = 1 AND imported_from = "' . $file_name . '"');
                $this->saveData($products, $file_name);
                Product::model()->deleteAll('to_delete = 1 AND imported = 1 AND imported_from = "' . $file_name . '"');
                unlink(Yii::getPathOfAlias('application') . '/data/' . $file_name);
                unlink(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            }
            
        }
        
        Product::clearImages();
            
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
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
        $parsed = parse_url($params['murl']);
        
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
        
        ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0);
        
        return $image;
    }
    
    protected function getFromFtp($file_name)
    {
        $curl = curl_init();
        $file = fopen(Yii::getPathOfAlias('application') . '/data/' . $file_name, 'w');
        curl_setopt($curl, CURLOPT_URL, "ftp://" . $this->ftp_server . "/" . $file_name);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_IGNORE_CONTENT_LENGTH, 1);
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_USERPWD, $this->ftp_user_name . ":" . $this->ftp_user_pass);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
        
        /*$ftp_server = $this->ftp_server;
        $ftp_user_name = $this->ftp_user_name;
        $ftp_user_pass = $this->ftp_user_pass;
        
        $data = file_get_contents("ftp://$ftp_user_name:$ftp_user_pass@$ftp_server/$file_name");
        file_put_contents(Yii::getPathOfAlias('application') . '/data/' . $file_name, $data);*/
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
    
    protected function saveData($products, $file_name)
    {
        foreach ($products as $product) {
            if ($product[0] != 'HDR' && $product[0] != 'TRL') {
                $category_id = 0;
                if (isset($this->category_link[$product[3]])) {
                    if (is_array($this->category_link[$product[3]])) {
                        if (isset($this->category_link[$product[3]][$product[4]])) {
                            $category_id = $this->category_link[$product[3]][$product[4]];
                        } else {
                            $category_id = $this->category_link[$product[3]]['default'];
                        }
                    } else {
                        $category_id = $this->category_link[$product[3]];
                    }
                }
                
                if ($category_id != 0) {
                    $brand = Brand::model()->find('url = "' . $this->generateUrl($product[20]) . '"');
                    if (!$brand) {
                        $brand = Brand::model()->find('LOWER(name) = "' . strtolower($product[20]) . '"');
                        if (!$brand) {
                            $brand_variant = BrandVariant::model()->find('url = "' . $this->generateUrl($product[20]) . '"');
                            if (!$brand_variant) {
                                $brand_variant = BrandVariant::model()->find('LOWER(name) = "' . strtolower($product[20]) . '"');
                                if (!$brand_variant) {
                                    $brand = new Brand();
                                    $brand->url = $this->generateUrl($product[20]);
                                    $brand->generate_url = false;
                                    $brand->name = $product[20];
                                    $brand->save();
                                }
                            }
                            if ($brand_variant) {
                                $brand = Brand::model()->findByPk($brand_variant->brand_id);
                            }
                        }
                    }
                    $brand_id = $brand->id;
                    
                    $model = Product::model()->find("direct_url = '" . $this->getDirectUrl($product[5]) . "'");
                    if (!$model) {
                        $image = $this->getImage($product[6]);
                        
                        $model = new Product();
                        $model->user_id = 185;
                        $model->category_id = $category_id;
                        $model->brand_id = $brand_id;
                        $model->title = $this->getProductTitle($file_name, $product[1]);
                        $model->description = $product[8];
                        $model->image1 = $image;
                        $model->color = $product[32];
                        $model->price = !empty($product[12]) ? $product[12] : $product[13];
                        $model->init_price = $product[13];
                        $model->condition = 1;
                        $model->direct_url = $this->getDirectUrl($product[5]);
                        $model->external_sale = 1;
                        $model->status = 'active';
                        $model->imported = 1;
                        $model->to_delete = 0;
                        $model->imported_from = $file_name;
                        $model->save();
                    } else {
                        if ($model->price != $product[12]) {
                            $model->price = $product[12];
                        }
                        if ($model->init_price != $product[13]) {
                            $model->init_price = $product[13];
                        }
                        $model->title = $this->getProductTitle($file_name, $product[1]);
                        $model->to_delete = 0;
                        $model->save();
                    }
                }
                die();
            }
        }
    }
    
    protected function getProductTitle($file_name, $full_name)
    {
        $title = '';
        if ($file_name == '35725_3620548_mp.txt.gz') {
            $full_name_parts = explode('-', $full_name);
            $title = trim($full_name_parts[1] . trim($full_name_parts[3]));
        } else {
            $title = $full_name;
        }
        
        return $title;
    }
}