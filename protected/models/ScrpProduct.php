<?php

/**
 * This is the model class for table "scrp_product".
 *
 * The followings are the available columns in table 'scrp_product':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $brand
 * @property string $brand_from_url
 * @property string $currency
 * @property string $sale_price
 * @property string $price
 * @property string $category_lvl1
 * @property string $category_lvl2
 * @property string $category_lvl3
 * @property string $category_lvl4
 * @property string $source_site
 * @property string $original_picture_url
 * @property string $picture_path
 * @property integer $_in_latest_scrape
 * @property string $time_crawled
 * @property string $product_id
 */
class ScrpProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'scrp_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, url, brand, brand_from_url, currency, sale_price, price, category_lvl1, category_lvl2, category_lvl3, category_lvl4, source_site, original_picture_url, picture_path, _in_latest_scrape, time_crawled, product_id', 'safe'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'url' => 'Url',
			'brand' => 'Brand',
			'brand_from_url' => 'Brand From Url',
			'currency' => 'Currency',
			'sale_price' => 'Sale Price',
			'price' => 'Price',
			'category_lvl1' => 'Category Lvl1',
			'category_lvl2' => 'Category Lvl2',
			'category_lvl3' => 'Category Lvl3',
			'category_lvl4' => 'Category Lvl4',
			'source_site' => 'Source Site',
			'original_picture_url' => 'Original Picture Url',
			'picture_path' => 'Picture Path',
			'_in_latest_scrape' => 'In Latest Scrape',
			'time_crawled' => 'Time Crawled',
			'product_id' => 'Product',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScrpProduct the static model class
	 */
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
        
        //$datas = self::model()->findAllByPk(1);
        if ($datas) {
            Product::model()->updateAll(['to_delete' => 1], 'screpped = 1');
            foreach ($datas as $k => $data) {
                $category_id = 0;
                for ($i = 4; $i > 0 ; $i --) {
                    $category_level = 'category_lvl' . $i;
                    $category = Category::model()->find("LOWER(alias) = '" . strtolower($data->$category_level) . "' AND (parent_id != " . $feat_cat_id . " OR parent_id is null)");
                    if ($category) {
                        /*if (strtolower($category->alias) == 'accessories') {
                            $category = Category::model()->find("LOWER(alias) = 'other' AND parent_id = " . $category->id);
                        }*/
                        $category_id = $category->id;
                        break;
                    }
                }
                
                if ($category_id != 0) {
                    $brand = Brand::model()->find('LOWER(url) = "' . strtolower($data->brand_from_url) . '"');
                    if (!$brand) {
                        $brand = Brand::model()->find('LOWER(name) = "' . strtolower($data->brand) . '"');
                        if (!$brand) {
                            $brand_variant = BrandVariant::model()->find('LOWER(url) = "' . strtolower($data->brand_from_url) . '"');
                            if (!$brand_variant) {
                                $brand_variant = BrandVariant::model()->find('LOWER(name) = "' . strtolower($data->brand) . '"');
                                if (!$brand_variant) {
                                    $brand = new Brand();
                                    if (strpos($data->brand_from_url, 'search-results') === false) {
                                        $brand->url = strtolower($data->brand_from_url);
                                        $brand->generate_url = false;
                                    }
                                    
                                    $brand->name = $data->brand;
                                    $brand->save();
                                }
                            }
                            if ($brand_variant) {
                                $brand = Brand::model()->findByPk($brand_variant->brand_id);
                            }
                        }
                    }
                    $brand_id = $brand->id;
                    
                    $product = Product::model()->find("direct_url = '" . $data->url . "'");
                    if (!$product) {
                        if (file_exists($data->picture_path)) {
                            //$arr = explode('\\', $data->picture_path);
                            $arr = explode('/', $data->picture_path);
                            $f_name = end($arr);
                            $crop_mode = 0;
                            $image = ImageHelper::getUniqueValidName(Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MAX_DIR, $f_name);
                            ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $image, $data->picture_path, $crop_mode);
                            unlink($data->picture_path);
                            
                            $product = new Product();
                            $product->user_id = 185;
                            $product->category_id = $category_id;
                            $product->brand_id = $brand_id;
                            $product->title = $data->name;
                            $product->description = '';
                            $product->image1 = $image;
                            $product->color = '';
                            $product->price = $data->sale_price;
                            $product->init_price = $data->price;
                            $product->condition = 1;
                            $product->direct_url = $data->url;
                            $product->external_sale = 1;
                            $product->status = 'active';
                            $product->screpped = 1;
                            $product->to_delete = 0;
                            $product->save();
                        }
                    } else {
                        if ($product->price != $data->sale_price) {
                            $product->price = $data->sale_price;
                        }
                        if ($product->init_price != $data->price) {
                            $product->init_price = $data->price;
                        }
                        $product->to_delete = 0;
                        $product->save();
                    }
                    self::model()->deleteByPk($data->id);
                }
            }
            Product::model()->deleteAll('to_delete = 1 AND screpped = 1');
            Product::clearImages();
        }
        return true;
    }
}
