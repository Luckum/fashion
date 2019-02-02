<?php

/**
 * This is the model class for table "scrp_product".
 *
 * The followings are the available columns in table 'scrp_product':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $brand
 * @property string $currency
 * @property float $sale_price
 * @property string $price
 * @property string $category_lvl1
 * @property string $category_lvl2
 * @property string $category_lvl3
 * @property string $category_lvl4
 * @property string $source_site
 * @property string $original_picture_url
 * @property string $picture_path
 * @property integer $_in_latest_scrape
 */
class ScrpProduct extends CActiveRecord
{
    public function tableName()
    {
        return 'scrp_product';
    }
    
    public function rules()
    {
        return array(
            array('id, name, url, brand, currency, sale_price, price, category_lvl1, category_lvl2, category_lvl3, category_lvl4, source_site, original_picture_url, picture_path, _in_latest_scrape', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'name' => 'Name',
            'url' => 'Url',
            'brand' => 'Brand',
            'currency' => 'Currency',
            'sale_price' => 'Sale_price',
            'price' => 'Price',
            'category_lvl1' => 'Category lvl1',
            'category_lvl2' => 'Category lvl2',
            'category_lvl3' => 'Category lvl3',
            'category_lvl4' => 'Category lvl4',
            'source_site' => 'Source_site',
            'original_picture_url' => 'Original picture url',
            'picture_path' => 'Picture path',
            '_in_latest_scrape' => 'In latest scrape'
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function setDataToProduct()
    {
        set_time_limit(10000);
        ini_set('memory_limit', '512M');
        $feat_cat_id = Category::getIdByAlias('featured');
        $datas = self::model()->findAll();
        if ($datas) {
            foreach ($datas as $k => $data) {
                $category_id = 0;
                for ($i = 4; $i > 0 ; $i --) {
                    $category_level = 'category_lvl' . $i;
                    $category = Category::model()->find("LOWER(alias) = '" . strtolower($data->$category_level) . "' AND (parent_id != " . $feat_cat_id . " OR parent_id is null)");
                    if ($category) {
                        if (strtolower($category->alias) == 'accessories') {
                            $category = Category::model()->find("LOWER(alias) = 'other' AND parent_id = " . $category->id);
                        }
                        $category_id = $category->id;
                        break;
                    }
                }
                
                if ($category_id != 0) {
                    $brand = Brand::model()->find('LOWER(name) = "' . strtolower($data->brand) . '"');
                    if (!$brand) {
                        $brand = new Brand();
                        $brand->name = $data->brand;
                        $brand->save();
                    }
                    $brand_id = $brand->id;
                    
                    if (!Product::model()->exists("direct_url = '" . $data->url . "'")) {
                        if (file_exists($data->picture_path)) {
                            //$arr = explode('\\', $data->picture_path);
                            $arr = explode('/', $data->picture_path);
                            $f_name = end($arr);
                            $crop_mode = 0;
                            $image = ImageHelper::getUniqueValidName(Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MAX_DIR, $f_name);
                            ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $data->picture_path, $crop_mode);
                            //unlink($data->picture_path);
                            
                            $product = new Product();
                            $product->user_id = 185;
                            $product->category_id = $category_id;
                            $product->brand_id = $brand_id;
                            $product->title = $data->name;
                            $product->description = '';
                            $product->image1 = $image;
                            $product->color = '';
                            $product->price = $data->price;
                            $product->init_price = $data->price;
                            $product->condition = 1;
                            $product->direct_url = $data->url;
                            $product->external_sale = 1;
                            $product->status = 'active';
                            $product->save();
                        }
                    }
                    //self::model()->deleteByPk($data->id);
                    
                }
                
            }
        }
        return true;
    }
}