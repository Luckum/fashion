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
        'Apparel & Accessories > Handbags, Wallets & Cases' => 188,
        'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers' => 94,
        'Apparel & Accessories > Clothing > Activewear' => 94,
        'Apparel & Accessories > Clothing Accessories > Hats' => 191,
        'Apparel & Accessories > Clothing > Underwear & Socks > Underwear' => 156,
        'Apparel & Accessories > Clothing > Shorts' => 178,
        'Apparel & Accessories > Clothing Accessories > Belts' => 192,
        'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Traditional Leather Pants' => 177,
        'Apparel & Accessories > Jewelry > Body Jewelry' => 148,
        'Apparel & Accessories > Jewelry > Necklaces' => 148,
        'Apparel & Accessories > Jewelry > Earrings' => 148,
        'Apparel & Accessories > Jewelry > Rings' => 148,
        'Apparel & Accessories > Jewelry > Bracelets' => 148,
        'Apparel & Accessories > Jewelry > Charms & Pendants' => 148,
        'Apparel & Accessories > Handbag & Wallet Accessories > Keychains' => 188,
        'Apparel & Accessories > Clothing Accessories > Neckties' => 146,
        'Apparel & Accessories > Clothing Accessories > Hair Accessories' => 199,
        'Apparel & Accessories > Jewelry > Brooches & Lapel Pins' => 148,
        'Apparel & Accessories > Clothing Accessories > Scarves & Shaw' => 191,
        'Apparel & Accessories > Clothing Accessories > Scarves & Shawls' => 191,
        'Apparel & Accessories > Shoe Accessories' => 146,
        'Apparel & Accessories > Clothing > Outerwear' => 94,
        'Apparel & Accessories > Clothing > Underwear & Socks > Shapewear' => 156,
        'Apparel & Accessories > Clothing > Underwear & Socks' => 156,
        'Apparel & Accessories > Clothing > Underwear & Socks > Bras' => 156,
        'Apparel & Accessories > Clothing > Sleepwear & Loungewear > Loungewear' => 94,
        'Apparel & Accessories > Clothing > Underwear & Socks > Lingerie' => 156,
        'Apparel & Accessories > Clothing > Activewear > Bicycle Activewear > Bicycle Tights' => 94,
        'Apparel & Accessories > Clothing Accessories > Gloves & Mittens' => 191,
        'Apparel & Accessories > Clothing Accessories > Wristbands' => 146,
        'Apparel & Accessories > Clothing > Uniforms > White Coats' => 94,
        'Apparel & Accessories > Clothing > Outerwear > Vests' => 94,
        'Apparel & Accessories > Handbags, Wallets & Cases > Wallets & Money Clips' => 182,
        'Apparel & Accessories > Clothing > Sleepwear & Loungewear > Robes' => 94,
        'Apparel & Accessories > Clothing > Sleepwear & Loungewear > Nightgowns' => 94,
        'Apparel & Accessories > Clothing > Sleepwear & Loungewear' => 94,
        'Apparel & Accessories > Clothing > Suits' => 94,
        'Apparel & Accessories > Clothing > Uniforms > Sports Uniforms' => 94,
        'Apparel & Accessories > Clothing Accessories > Arm Warmers & Sleeves' => 199,
        'Apparel & Accessories > Clothing Accessories > Suspenders' => 199,
        'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos' => 94,
        'Apparel & Accessories > Clothing > Activewear > Dance Dresses, Skirts & Costumes' => 94,
        'Apparel & Accessories > Clothing > Underwear & Socks > Hosiery' => 156,
        'Apparel & Accessories > Clothing > Suits > Skirt Suits' => 94,
        'Home & Garden' => 199,
        'Home & Garden > Lighting' => 199,
        'Health & Beauty' => 196,
        'Apparel & Accessories > Clothing Accessories' => 146,
        'Luggage & Bags' => 182,
        'Luggage & Bags > Luggage Accessories' => 146,
        'Apparel & Accessories > Jewelry' => 148,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body Gift Sets' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Skin Care' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup' => 196,
        'Health & Beauty > Personal Care > Ear Care > Ear Candles' => 196,
        'Health & Beauty > Personal Care > Hair Care > Shampoo & Conditioner' => 196,
        'Health & Beauty > Personal Care > Hair Care' => 196,
        'Health & Beauty > Health Care' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body > Body Wash' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body > Powdered Hand Soap' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Lip Makeup' => 196,
        'Health & Beauty > Personal Care > Massage & Relaxation > Massage Oil' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Perfume & Cologne' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body > Bar Soap' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Cosmetic Tools > Makeup Tools > False Eyelash Accessories > False Eyelash Remover' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Cosmetic Sets' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Nail Care' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Skin Care > Sunscreen' => 196,
        'Health & Beauty > Personal Care > Deodorant & Anti-Perspirant' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Nail Care > Nail Polish Thinners' => 196,
        'Health & Beauty > Personal Care > Vision Care > Eyeglasses' => 149,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Face Makeup' => 196,
        'Health & Beauty > Personal Care > Shaving & Grooming > Shaving Cream' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Face Makeup > Face Powder' => 196,
        'Health & Beauty > Health Care > Respiratory Care > PAP Masks' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Eye Makeup' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Lip Makeup > Lipstick' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Skin Care > Makeup Removers' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Makeup > Face Makeup > Face Primer' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body > Shower Caps' => 196,
        'Home & Garden > Decor > Home Fragrance Accessories' => 199,
        'Home & Garden > Decor > Flameless Candles' => 199,
        'Home & Garden > Decor > Home Fragrances > Candles' => 199,
        'Home & Garden > Lawn & Garden > Outdoor Living > Outdoor Umbrellas & Sunshades' => 199,
        'Home & Garden > Parasols & Rain Umbrellas' => 199,
        'Home & Garden > Linens & Bedding > Bedding > Pillowcases & Shams' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Dinnerware > Bowls' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Dinnerware > Plates' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Coffee Servers & Tea Pots' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Drinkware > Mugs' => 199,
        'Home & Garden > Kitchen & Dining > Tableware' => 199,
        'Home & Garden > Kitchen & Dining > Kitchen Tools & Utensils > Aprons' => 199,
        'Home & Garden > Linens & Bedding > Towels' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Drinkware' => 199,
        'Home & Garden > Kitchen & Dining > Tableware > Serveware Accessories' => 199,
        'Home & Garden > Kitchen & Dining > Kitchen Tools & Utensils > Oven Mitts & Pot Holders' => 199,
        'Home & Garden > Linens & Bedding > Towels > Kitchen Towels' => 199,
        'Home & Garden > Linens & Bedding > Bedding > Blankets' => 199,
        'Home & Garden > Decor > Vases' => 199,
        'Home & Garden > Decor > Home Fragrance Accessories > Candle Holders' => 199,
        'Home & Garden > Linens & Bedding > Table Linens > Placemats' => 199,
        'Home & Garden > Bathroom Accessories' => 199,
        'Home & Garden > Linens & Bedding > Table Linens' => 199,
        'Home & Garden > Household Supplies > Storage & Organization > Storage Hooks & Racks > Umbrella Stands & Racks' => 199,
        'Arts & Entertainment > Hobbies & Creative Arts > Arts & Crafts > Art & Crafting Materials > Textiles > Fabric' => 199,
        'Health & Beauty > Jewelry Cleaning & Care > Jewelry Cleaning Tools' => 196,
        'Health & Beauty > Personal Care > Cosmetics > Bath & Body' => 196,
        'Sporting Goods > Athletics > Rounders > Rounders Gloves' => 191,
        'Sporting Goods > Athletics > Racquetball & Squash > Racquetball & Squash Eyewear' => 149,
        'Luggage & Bags > Backpacks' => 183,
        'Luggage & Bags > Luggage Accessories > Travel Pouches' => 185,
        'Luggage & Bags > Messenger Bags' => 182,
        'Luggage & Bags > Luggage Accessories > Luggage Straps' => 182,
        'Luggage & Bags > Suitcases' => 182,
        'Luggage & Bags > Shopping Totes' => 187,
        'Luggage & Bags > Luggage Accessories > Dry Box Liners & Inserts' => 182,
        'Luggage & Bags > Cosmetic & Toiletry Bags' => 182,
        'Luggage & Bags > Luggage Accessories > Luggage Racks & Stands' => 185,
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
        '197461/1.A6F0/',
    ];
    
    protected $file_names_part_2 = [
        '201513/156052.2408/',
        '207169/1.AC44/',
        '209091/1.A6B8/'
        //'203945/1.AAFB/', - absent gender
    ];
    
    protected $file_names_part_3 = [
        '180914/1.AAE6/',
        '209895/1.AEE4/',
        '185499/1.A2BE/'
    ];
    
    protected $file_names_part_4 = [
        //'160630/156052.16F9/', - deleted?
        //'180980/156052.202A/' - absend gender
        '193024/156052.21AB/',
        '211253/156074.A84D272FB8996740/',
        '202535/156052.22AD/',
        //'175269/156100.2827/', - absend gender, bad links
        //'196330/156052.2231/' - absend gender
    ];
    
    protected $file_names_part_5 = [
        //'171537/1.9D00/' - absend gender, absend category
        //'199801/1.A802/' - lesgirlslesboys shit
        
        '194020/156100.33A1/',
        '203104/1.A9DA/',
        '189747/1.9A26/',
        //'188219/1.A935/' - absend geneder
    ];
    
    protected $file_names_part_6 = [
        '194849/1.A6B3/',
        '195216/1.A67E/',
        '203133/2.2ADB060C575BA471/',
    ];
    
    protected $file_names_part_7 = [
        //'171717/1.5F67/', - jpg error
        //'202740/156052.23D6/', - absent gender
        '203181/1.ABA9/',
        '209986/156052.2145/',
        '179969/1.9209/'
    ];
    
    protected $file_names_part_8 = [
        '179970/1.A302/',
        '199782/1.A8EA/',
        //'202186/2.3EFA57E9887750DE/' // images copy fail
        '211739/1.AF80/'
    ];
    
    protected $file_names_part_9 = [
        '203300/1.AB30/',
        '208989/156178.8405/',
        //'209025/2.858C228760157FC8/' // absent gender, absent category
        '209396/1.ACC2/'
    ];
    
    protected $file_names_part_10 = [
        //'178564/156178.2B8D/',
        //'199306/156052.2110/' //absent gender
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
            
            //die();
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
            if ((strtolower($rec->gender) == 'female' || strtolower($rec->gender) == 'womens' || strtolower($rec->gender) == 'women' || 
                 stripos($rec->deepLinkUrl, '/women/') !== false || $file_name == '160630/156052.16F9/' || $file_name == '193024/156052.21AB/' ||
                 $file_name == '202535/156052.22AD/' || $file_name == '203181/1.ABA9/' || $file_name == '195216/1.A67E/' || $file_name == '203181/1.ABA9/' ||
                 $file_name == '209986/156052.2145/' || $file_name == '199782/1.A8EA/' || $file_name == '208989/156178.8405/' || $file_name == '211739/1.AF80/') && strtolower($rec->isInStock) == 'true') {
                
                //$cats[] = $rec->category;
                
                $category_id = 0;
                if (isset($this->category_link["$rec->category"])) {
                    $category_id = $this->category_link["$rec->category"];
                }
                if ($file_name == '171455/1.8FDC/') {
                    if (isset($this->category_link[$this->getCategory("$rec->name")])) {
                        $category_id = $this->category_link[$this->getCategory("$rec->name")];
                    }
                }
                if ($file_name == '160630/156052.16F9/') {
                    $category_id = 154;
                }
                if ($file_name == '202535/156052.22AD/') {
                    $category_id = 188;
                }
                if ($category_id != 0) {
                    $brand_file = isset($rec->brand) ? $rec->brand : (isset($rec->manufacturer) ? $rec->manufacturer : '');
                    if ($file_name == '195216/1.A67E/') {
                        $brand_file = 'Malin+Goetz';
                    }
                    
                    if (!empty($brand_file)) {
                        $brand_file = SymbolHelper::getCorrectName("$brand_file");
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
                        
                        if ($file_name == '193024/156052.21AB/' || $file_name == '209091/1.A6B8/' || $file_name == '203133/2.2ADB060C575BA471/' ||
                            $file_name == '179969/1.9209/' || $file_name == '179970/1.A302/') {
                            $d_link = $rec->deepLinkUrl;
                            if (($pos_s = strpos($d_link, '?')) !== false) {
                                $d_link = substr($d_link, 0, $pos_s);
                            }
                        } else if ($file_name == '208989/156178.8405/' || $file_name == '178564/156178.2B8D/') {
                            $d_link = $rec->linkUrl;
                        } else {
                            $d_link = $rec->deepLinkUrl;
                        }
                        
                        $model = Product::model()->find('direct_url = "' . $d_link . '"');
                        
                        $image = $this->getImage($rec->imageUrl, $brand->url, $file_name == '171455/1.8FDC/' ? $this->getNameFromDesc("$rec->shortDescription") : "$rec->name", $file_name);
                        
                        $priceCurrency = $file_name == '211253/156074.A84D272FB8996740/' ? 'USD' : strtoupper($rec->priceCurrency);
                        $currency = Currency::getCurrencyByName($priceCurrency);
                        if ($currency) {
                            $rate = $currency->currencyRate->rate;
                        } else {
                            if (strtoupper($rec->priceCurrency) == 'AUD') {
                                $rate = 0.63;
                            } else if (strtoupper($rec->priceCurrency) == 'HKD') {
                                $rate = 0.12;
                            } else if (strtoupper($rec->priceCurrency) == 'CAD') {
                                $rate = 0.69;
                            }
                        }
                        
                        $price = isset($rec->salePrice) ? floatval($rec->salePrice * $rate) : floatval($rec->price * $rate);
                        $init_price = $rec->price * $rate;
                        
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
                                $model->price = $price;
                                $model->init_price = $init_price;
                                $model->condition = 1;
                                $model->direct_url = "$d_link";
                                $model->external_sale = 1;
                                $model->status = 'active';
                                $model->imported = 1;
                                $model->to_delete = 0;
                                $model->imported_from = $file_name . $this->_file_name;
                                $model->save();
                            } else {
                                if ($model->screpped != 1) {
                                    if ($model->price != $price) {
                                        $model->price = $price;
                                    }
                                    if ($model->init_price != $init_price) {
                                        $model->init_price = $init_price;
                                    }
                                    $model->title = "$rec->name";
                                    $model->brand_id = $brand_id;
                                    $model->image1 = $image;
                                    $model->to_delete = 0;
                                    $model->save();
                                }
                            }
                            
                            //$path = $this->setCdnPath($model->id) . '/' . $model->image1;
//                            $image_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR . 'medium/' . $model->image1;
//                            if ($this->copyToCdn($image_path, $path)) {
//                                $model->image1 = $path;
//                                if ($model->save()) {
//                                    unlink($image_path);
//                                }
//                            }
                        }
                    }
                }
            }
        }
        print_r(array_unique($cats));
    }
    
    protected function generateUrl($name)
    {
        $url = trim(strtolower($name));
        $url = str_replace(' ', '-', $url);
        $url = str_replace(array('\'', '.', ',', '&', '*', '/', '+', ':'), "", $url);
        $url = str_replace('--', '-', $url);
        
        return $url;
    }
    
    protected function getImage($img_path, $brand, $title, $file_name)
    {
        $main_upload_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR;
        
        if ($file_name == '201513/156052.2408/') {
            $img_path = str_replace('h_1080', 'h_680', $img_path);
            $img_path = str_replace('w_1080', 'w_540', $img_path);
        }
        
        if ($file_name == '178564/156178.2B8D/') {
            $img_path = str_replace('/180/', '/1600/', $img_path);
            $img_path = str_replace('/180/', '/1600/', $img_path);
        }
        
        if ($file_name == '160630/156052.16F9/') {
            if (($pos_s = strpos($img_path, '&')) != false) {
                $img_path = substr($img_path, 0, $pos_s);
            }
        } else {
            if (($pos_s = strpos($img_path, '?')) !== false) {
                $img_path = substr($img_path, 0, $pos_s);
            }
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
        //$image = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
        $title = str_replace(array('\'', '.', ',', '&', '*', '/', '"', '|'), "", $title);
        $image = strtolower($brand) . '-' . $this->generateUrl($title) . '-' . uniqid() . '.' . $ext;
        //$image = strtolower($brand) . '-' . $this->generateUrl($title) . '.' . $ext;
        
        $checkit = $file_name == '211253/156074.A84D272FB8996740/' || $file_name == '202535/156052.22AD/' || $file_name == '194849/1.A6B3/' || $file_name == '193024/156052.21AB/' || $file_name = '203181/1.ABA9/' ? false : true;
        if (ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0, $checkit)) {
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
        $path_parts = explode('/', $path);
        array_pop($path_parts);
        $path = implode('/', $path_parts);
        
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