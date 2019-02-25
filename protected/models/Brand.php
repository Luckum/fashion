<?php

/**
 * This is the model class for table "brand".
 *
 * The followings are the available columns in table 'brand':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class Brand extends CActiveRecord
{
    public $generate_url = true;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{brand}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required', 'message' => '*required'),
            array('name, url', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, url', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products'   => array(self::HAS_MANY, 'Product', 'brand_id'),
            'size_chart' => array(self::HAS_ONE, 'SizeChart', 'size_type', 'through' => 'products')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'name' => Yii::t('base', 'Brand Name'),
            'url' => Yii::t('base', 'Brand URL'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('LOWER(name)', strtolower($this->name), true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Brand the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getAllBrands() {
        $brands = self::model()->findAll();

        $array = array();

        foreach ($brands as $one) {
            $array[$one->id] = $one->name;

        }
        
        return $array;
    }

    public static function getCountProduct($id) {
        $count = Product::model()->count("brand_id=:brand_id", array("brand_id" => $id));
        return $count;
    }

    public function beforeValidate()
    {
        $this->name = self::getFormatedTitle($this->name);
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $ret = parent::beforeSave();
        if ($ret) {
            if ($this->isNewRecord){
                $this->name = ucwords(strtolower($this->name));
                if ($this->generate_url) {
                    $this->generateUrl();
                }
            }
        }

        return $ret;
    }

    public static function jquery_source() {
        // An array of objects with label and value properties:
        // [ { label: "Choice1", value: "value1" }, ... ]

        $list = Brand::model()->findAll();

        $count = count($list);

        if(!$count) return '[]';

        $result = '[ { label: " ", value: " " }, '; // begin with empty item

        foreach ($list as $key => $value) {
            if(--$count < 0) break;

            $result .= '{ label: ' . json_encode($value->name) . ', value: "' . $value->id . '" }';

            if($count > 0) $result .= ', ';
        }

        $result .= ' ]'; // close array

        return $result;
    }

    public static function getBrandLink($itemLink)
    {
        $model = self::model()->find('LOWER(name)=:name', array(
                ':name' => strtolower($itemLink),
        ));
        return '/brands/'.$model->url;
//       $base = Yii::app()->createAbsoluteUrl('shop/brands');
//       $itemLink = trim($itemLink);
//       $itemLink = preg_replace('/\s/', '-', $itemLink);
//       $itemLink = urlencode(strtolower(CHtml::encode($itemLink)));
       /*
       for links like Öhlin/d - double slash encoding
       */
       //$itemLink = urlencode($itemLink);

       //return $base . '/' . $itemLink;
       // return '/brands/'.$itemLink;
    }

    public function generateUrl()
    {
        $this->url = trim(strtolower($this->name));
        $this->url = str_replace(' ', '-', $this->url);
        $this->url = str_replace('--', '-', $this->url);
        $this->url = str_replace(array('\'', '.', ',', '&', '*', '/'), "", $this->url);
    }

    public static function getFormatedTitle($title)
    {
        return $title;
        //return ucwords(strtolower($title));
    }
    
    /*public static function getBrandsSorted()
    {
        return self::model()->findAll(['select' => 'DISTINCT(name), url', 'order' => 'url']);
    }*/
    public static function getBrandsSorted($category, $subcategory)
    {
        $cats = [];
        $in_cats = $join = $where = '';
        if (empty($subcategory)) {
            $model = Category::model()->findByPath('brands/' . $category);
        } elseif ($subcategory == 'all') {
            $model = Category::model()->findByPath($category . '/' . $category);
            $cats = Category::model()->findAllByAttributes(['parent_id' => $model->id]);
            $in_cats .= $model->id;
        } else {
            $model = Category::model()->findByPath($category . '/' . $subcategory);
            $in_cats .= $model->id;
        }
        
        if (!empty($cats)) {
            foreach ($cats as $cat) {
                $in_cats .= ', ' . $cat->id;
            }
        }
        
        if (!empty($subcategory)) {
            $join = 'LEFT JOIN product p ON t.id = p.brand_id';
            $where = 'p.category_id IN (' . $in_cats . ')';
        } 
        
        return self::model()->findAll([
            'select' => 'DISTINCT(name), url',
            'join' => $join,
            'condition' => $where,
            'order' => 'url'
        ]);
    }
}
