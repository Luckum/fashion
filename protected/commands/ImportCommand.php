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
        //'Accessories' => 146,
        'Beauty' => 196,
        'Homeware' => 199,
        'Jewellery' => 148,
        'Jewelry' => 148,
        'Grooming' => 196,
        'Demi-Fine Jewellery' => 148,
        'Demi-Fine Jewelry' => 148,
        'Watches' => 146,
        'Bags' => 182,
        //'Shoes' => 135,
        'Activewear' => 94,
        'Fine Jewellery' => 148,
        'Fine Jewelry' => 148,
        'Clothing' => 94,
        'Health & Beauty' => 196,
        'Electronics' => 146,
        //'Home & Garden' => 146,
        'Apparel & Accessories' => [
            'Clothing~~Outerwear~~Coats & Jackets' => 154,
            'Clothing~~Shirts & Tops' => 162,
            'Clothing~~Pants' => 177,
            'Clothing~~Dresses' => 153,
            'Handbags, Wallets & Cases~~Wallets & Money Clips' => 188,
            'Shoes' => 135,
            'Clothing~~Skirts' => 179,
            'Clothing' => 94,
            'Handbag & Wallet Accessories' => 190,
            'Clothing Accessories~~Gloves & Mittens' => 191,
            'Clothing~~Swimwear' => 129,
            'Clothing Accessories~~Belts' => 192,
            'Jewelry~~Bracelets' => 148,
            'Clothing~~Underwear & Socks~~Underwear' => 194,
            'Handbag & Wallet Accessories~~Keychains' => 188,
            'Clothing Accessories~~Scarves & Shawls' => 191,
            'Clothing~~Shorts' => 178,
            'Clothing Accessories~~Neckties' => 146,
            'Clothing Accessories~~Hats' => 191,
            'Jewelry~~Earrings' => 148,
            'Jewelry~~Brooches & Lapel Pins' => 148,
            'Jewelry~~Rings' => 148,
            'Clothing Accessories~~Sunglasses' => 149,
            'Jewelry~~Necklaces' => 148,
            'Clothing~~Outfit Sets' => 94,
            'Jewelry~~Jewelry Sets' => 148,
        ],
        'Clothing' => [
            'T-Shirts' => 162,
            'Underwear' => 156,
            'Jeans' => 155,
            'Tops' => 162,
            'Pants & Shorts' => 177,
            'Knitwear' => 94,
            'Dresses' => 153,
            'Skirts' => 179,
            'Shirts' => 162,
            'Jackets' => 154,
            'Coats' => 154,
            'Suits' => 94,
            'Blazers' => 94,
            'Activewear' => 94,
            'Polos' => 162,
            'Swimwear' => 129,
            'Pullovers & Hoodies' => 94,
            'Lingerie And Shapewear' => 156,
            'Tops~~Blouses' => 162,
            'Tops~~T-Shirts & Jersey Shirts' => 162,
            'Pants~~Flared & Bell-Bottom Pants' => 177,
            'Knits~~Knitted Tops' => 94,
            'Skirts~~Fitted Skirts' => 179,
            'Pants~~Slacks' => 177,
            'Jackets~~Blazers' => 154,
            'Pants~~Palazzo Pants' => 177,
            'Knits~~Knitted Sweaters' => 94,
            'Dresses~~Day Dresses' => 153,
            'Skirts~~Full Skirts' => 179,
            'Denim~~Cropped Jeans' => 155,
            'Tops~~Polo Tops' => 162,
            'Tops~~Vests & Tank Tops' => 162,
            'Tops~~Shirts' => 162,
            'Rompers~~Playsuits' => 94,
            'Coats~~Trench Coats & Raincoats' => 154,
            'Pants~~Straight-Leg Pants' => 177,
            'Denim~~Skinny Jeans' => 155,
            'Skirts~~A-Line Skirts' => 179,
            'Dresses~~Cocktail & Party Dresses' => 153,
            'Beachwear~~Beach Dresses' => 153,
            'Jackets~~Waistcoats & Gilets' => 154,
            'Beachwear~~Swimsuits' => 129,
            'Jackets~~Cropped Jackets' => 154,
            'Denim~~Flares & Bell Bottom Jeans' => 155,
            'Beachwear~~Bikinis' => 129,
            'Tops~~Hoodies' => 94,
            'Beachwear~~Beach Cover-Ups' => 129,
            'Knits~~Knitted Skirts' => 179,
            'Pants~~Cropped Pants' => 177,
            'Pants~~Sweatpants' => 177,
            'Knits~~Sweater Dresses' => 94,
            'Skirts~~High-Waisted Skirts' => 179,
            'Knits~~Cardigans' => 94,
            'Skirts~~Pleated Skirts' => 179,
            'Coats~~Parkas' => 154,
            'Skirts~~Asymmetric & Draped Skirts' => 179,
            'Jackets~~Oversized Jackets' => 154,
            'Rompers~~Jumpsuits' => 94,
            'Coats~~Single Breasted Coats' => 154,
            'Skirts~~Straight Skirts' => 179,
            'Coats~~Oversized Coats' => 154,
            'Jackets~~Varsity Jackets' => 154,
            'Tops~~Sweaters' => 94,
            'Pants~~High Waisted Pants' => 177,
            'default' => 94,
        ],
        'Bags' => [
            'Clutches' => 188,
            'Totes' => 187,
            'Shoulder Bags' => 186,
            'Tote Bags' => 187,
            'Briefcases' => 182,
            'Backpacks' => 183,
            'Weekend Bags' => 182,
            'Messenger Bags' => 182,
            'Messenger & Crossbody Bags' => 182,
            'Clutch Bags' => 188,
            'Mini Bags' => 182,
            'Bucket Bags' => 188,
            'Bag Accessories' => 146,
            'Belt Bags' => 184,
            'default' => 182,
        ],
        'Kitchen & Tabletop' => [
            'Drinkware' => 199,
            'Dinnerware' => 199,
            'Kitchenware' => 199,
            'default' => 199,
        ],
        'Accessories' => [
            'Fine Jewellery' => 148,
            'Watches' => 146,
            'Hats & Gloves' => 191,
            'Fashion Jewellery' => 148,
            'Belts' => 192,
            'Scarves & Wraps' => 191,
            'Socks' => 194,
            'High Jewellery' => 148,
            'Cufflinks & Jewellery' => 148,
            'Wallets & Small Accessories' => 193,
            'Wallets & Purses' => 193,
            'Scarves' => 191,
            'Hats' => 191,
            'Eyewear' => 149,
            'Pocket Squares' => 146,
            'Others' => 146,
            'Ties' => 146,
            'Socks & Hosiery' => 194,
            'Hair Accessories' => 196,
            'Gloves' => 191,
            'Fur' => 146,
            'Keyrings & Chains' => 146,
            'default' => 146,
        ],
        'Shoes' => [
            'Boots' => 140,
            'Sneakers' => 138,
            'Loafers' => 180,
            'Flats' => 136,
            'High Heels' => 137,
            'Sandals' => 181,
            'Monk Straps' => 135,
            'Mid Heels' => 137,
            'Lace Ups' => 135,
            'Low Heels' => 137,
            'Slip-Ons' => 135,
            'Mules' => 136,
            'Flip Flops' => 135,
            'Pumps' => 135,
            'Lace-Up Shoes' => 135,
            'default' => 135,
        ],
        'Beauty' => 196,
        'Bedding' => 199,
        //'Lighting' => 199,
        'Bath & Towels' => 199,
        //'Furniture' => 146,
        //'Home Appliances' => 199,
        //'Home Furnishing & Décor' => 199,
        //'Lifestyle' => 146,
    ];
    
    protected $ftp_server = 'aftp.linksynergy.com';
    protected $ftp_user_name = 'n2315_';
    protected $ftp_user_pass = 'GyTLMNP';
    protected $file_names_part_1 = [
        //'35725_3620548_mp.txt.gz',
        '43650_3620548_mp.txt.gz'
    ];
    protected $file_names_part_2 = [
        //'35118_3620548_mp.txt.gz',
        '44162_3620548_mp.txt.gz'
    ];
    protected $file_names_part_3 = [
        '38297_3620548_mp.txt.gz',
        '43009_3620548_mp.txt.gz',
    ];
    
    //'37998_3620548_mp.txt.gz', deleted
    
    protected $key = "3CMGDJJNJAU6JXYFT7GG";
    protected $secret = "bxt9eWx6kJ/E3yvNiNkRG7N9NUbvnN/cwNAFJiQkDZk";
    protected $space_name = "n2315";
    protected $region = "fra1";
    
    public function run($args)
    {
        echo 'started at ' . date('H:i:s') . "\n";
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        $str = 'file_names_part_';
        
        foreach ($this->{$str . $args[0]} as $file_name) {
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
                
                $to_delete_products = Product::model()->findAll('to_delete = 1 AND imported = 1 AND imported_from = "' . $file_name . '"');
                if ($to_delete_products) {
                    foreach ($to_delete_products as $to_delete) {
                        $this->removeFromCdn($to_delete->image1);
                        $to_delete->delete();
                    }
                }
                //Product::model()->deleteAll('to_delete = 1 AND imported = 1 AND imported_from = "' . $file_name . '"');
                unlink(Yii::getPathOfAlias('application') . '/data/' . $file_name);
                unlink(Yii::getPathOfAlias('application') . '/data/' . $out_file_name);
            }
            
        }
        
        //Product::clearImages();
            
        echo 'finished at ' . date('H:i:s') . "\n";
        return true;
    }
    
    protected function generateUrl($name)
    {
        $url = trim(strtolower($name));
        $url = str_replace(' ', '-', $url);
        $url = str_replace(array('\'', '.', ',', '&', '*', '/', '+', ':'), "", $url);
        $url = str_replace('--', '-', $url);
        
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
    
    protected function getImage($img_path, $file_name, $brand, $title)
    {
        $main_upload_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR;
        
        if (($pos_s = strpos($img_path, '?')) !== false) {
            $img_path = substr($img_path, 0, $pos_s);
        }
        $arr = explode('/', $img_path);
        $f_name = end($arr);
        if ($file_name == '37998_3620548_mp.txt.gz') {
            $f_name .= '.jpg';
        }
        
        $arr = explode('.', $f_name);
        $ext = end($arr);
        //$image = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
        $title = str_replace(array('\'', '.', ',', '&', '*', '/', '"', '|'), "", $title);
        $image = strtolower($brand) . '-' . $this->generateUrl($title) . '.' . $ext;
        
        if (ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $img_path, 0)) {
            return $image;
        }
        
        return false;
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
        //$cats = [];
        foreach ($products as $product) {
            if ($product[0] != 'HDR' && $product[0] != 'TRL') {
                /*if ($product[3] == 'Shoes') {
                    $cats[] = $product[4];
                }*/
                
                if ($file_name == '43650_3620548_mp.txt.gz' || (isset($product[33]) && strtolower($product[33]) == 'female')) {
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
                        $brand_file = $file_name == '35118_3620548_mp.txt.gz' ? (isset($product[16]) ? $product[16] : '') : (isset($product[20]) ? $product[20] : '');
                        
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
                            
                            $price = !empty($product[12]) ? $product[12] : $product[13];
                            $init_price = $product[13];
                            
                            $model = Product::model()->find("direct_url = '" . $this->getDirectUrl($product[5]) . "'");
                            if (!$model) {
                                $image = $this->getImage($product[6], $file_name, $brand->url, $this->getProductTitle($file_name, $product[1]));
                                
                                if ($image) {
                                    $model = new Product();
                                    $model->user_id = 185;
                                    $model->category_id = $category_id;
                                    $model->brand_id = $brand_id;
                                    $model->title = $this->getProductTitle($file_name, $product[1]);
                                    $model->description = $product[8];
                                    $model->image1 = $image;
                                    $model->color = isset($product[32]) ? $product[32] : '';
                                    $model->price = $price;
                                    $model->init_price = $init_price;
                                    $model->condition = 1;
                                    $model->direct_url = $this->getDirectUrl($product[5]);
                                    $model->external_sale = 1;
                                    $model->status = 'active';
                                    $model->imported = 1;
                                    $model->to_delete = 0;
                                    $model->imported_from = $file_name;
                                    if ($model->save()) {
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
                            } else {
                                if ($model->price != $price) {
                                    $model->price = $price;
                                }
                                if ($model->init_price != $product[13]) {
                                    $model->init_price = $product[13];
                                }
                                $model->title = $this->getProductTitle($file_name, $product[1]);
                                $model->brand_id = $brand_id;
                                $model->to_delete = 0;
                                $model->save();
                            }
                        }
                    }
                }
            }
        }
        //print_r(array_unique($cats));
    }
    
    protected function getProductTitle($file_name, $full_name)
    {
        $title = '';
        if ($file_name == '35725_3620548_mp.txt.gz') {
            $full_name_parts = explode('-', $full_name);
            $title = trim($full_name_parts[1] . trim($full_name_parts[3]));
        } else if ($file_name == '43009_3620548_mp.txt.gz') {
            $full_name_parts = explode(' ', $full_name);
            array_pop($full_name_parts);
            array_shift($full_name_parts);
            array_shift($full_name_parts);
            $title = implode(' ', $full_name_parts);
        } else {
            $title = "$full_name";
        }
        
        return $title;
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
}