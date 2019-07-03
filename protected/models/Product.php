<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $brand_id
 * @property integer $size_type
 * @property string $title
 * @property string $description
 * @property string $image1
 * @property string $image2
 * @property string $image3
 * @property string $image4
 * @property string $image5
 * @property string $color
 * @property string $price
 * @property string $init_price
 * @property string $item_number
 * @property string $added_date
 * @property integer $condition
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $depth
 * @property integer $featured
 * @property integer $featured_order
 * @property integer $our_selection
 * @property integer $status
 * @property integer $alerts_sent
 * @property string $custom_size
 * @property integer $screpped
 * @property integer $imported
 * @property integer $to_delete
 * @property string $imported_from
 *
 * The followings are the available model relations:
 * @property Bid[] $bs
 * @property Cart[] $carts
 * @property OrderItem[] $orderItems
 * @property User $user
 * @property Category $category
 * @property Brand $brand
 * @property Attribute[] $productAttributes
 * @property Rating[] $ratings
 * @property Rating[] $ratings1
 * @property Wishlist[] $wishlists
 */
class Product extends CActiveRecord implements IECartPosition
{
    /*public $oldImage1;
    public $oldImage2;
    public $oldImage3;
    public $oldImage4;
    public $oldImage5;*/
    public $size_type;
    public $from_date;
    public $to_date;
    public $parentCategory;
    public $acceptTerms;
    public $category_search;
    public $parent_category_search;
    public $brand_search;
    public $size_search;
    public $user_search;
    public $alias;
    public $parent_id;

    /**
     * Статусы продукта.
     */
    const PRODUCT_STATUS_ACTIVE   = 'active';
    const PRODUCT_STATUS_DEACTIVE = 'deactive';
    const PRODUCT_STATUS_PENDING  = 'pending';
    const PRODUCT_STATUS_DECLINED = 'declined';
    const PRODUCT_STATUS_SOLD = 'sold';

    // used in case of manually price setting before serialization
    //
    public $price_memory;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, brand_id, title, price, init_price, added_date, condition', 'required', 'message' => '*required'),
            //array('image1,direct_url','isExternalSale'),
            //array('image1, image2, image3','isNotExternalSale'),
            array('direct_url', 'url', 'defaultScheme' => 'http'),
            array('size_type', 'default', 'setOnEmpty' => true, 'value' => null),
            array('acceptTerms', 'required', 'on' => 'sell', 'message' => 'You must agree with Terms and Conditions'),
            array('parentCategory', 'required', 'on' => 'sell', 'message' => '*required'),
            array('acceptTerms', 'termsAccept', 'on' => 'sell'),
            array('parentCategory', 'parentCat', 'on' => 'sell'),
            array('user_id, category_id, brand_id, our_selection, condition, featured, featured_order, external_sale, is_url, screpped, to_delete, imported', 'numerical', 'integerOnly' => true),
            array('title, custom_size, image1, image2, image3, image4, image5, size_type', 'length', 'max' => 255),
            array('image_url1, image_url2, image_url3, image_url4, image_url5', 'length', 'max' => 255),
            array('image_url1, image_url2, image_url3, image_url4, image_url5', 'url'),
            array('price, init_price', 'length', 'max' => 9),
            array('color', 'length', 'max' => 20, 'allowEmpty' => true),
            array('imported_from', 'length', 'max' => 50, 'allowEmpty' => true),
            array('description', 'length', 'max' => 1000, 'allowEmpty' => true),
            //array('image1, image2, image3, image4, image5', 'file', 'types' => 'jpg, jpeg', 'allowEmpty' => true),
            array('status', 'in', 'range' => array(self::PRODUCT_STATUS_ACTIVE, self::PRODUCT_STATUS_DEACTIVE, self::PRODUCT_STATUS_PENDING, self::PRODUCT_STATUS_DECLINED, self::PRODUCT_STATUS_SOLD)),
            //array('image1, image2, image3, image4, image5', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, custom_size, category_id, size_search, user_search, category_search, parent_category_search, brand_search, brand_id, size_type, title, description, image1, image2, image3, image4, image5, color, price, init_price, added_date, condition, featured, featured_order, our_selection, status, alerts_sent', 'safe', 'on' => 'search'),
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
            'bs' => array(self::HAS_MANY, 'Bid', 'product_id'),
            'carts' => array(self::HAS_MANY, 'Cart', 'product_id'),
            'orderItems' => array(self::HAS_MANY, 'OrderItem', 'product_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'productAttributes' => array(self::MANY_MANY, 'Attribute', 'product_attribute(product_id, attribute_id)'),
            'ratings' => array(self::HAS_MANY, 'Rating', 'product_id'),
            'ratings1' => array(self::HAS_MANY, 'Rating', 'seller_id'),
            'comments' => array(self::HAS_MANY, 'Comments', 'product_id', 'order' => 'added_date DESC'),
            'comments1' => array(self::HAS_MANY, 'Comments', 'seller_id', 'order' => 'added_date DESC'),
            'wishlists' => array(self::HAS_MANY, 'Wishlist', 'product_id'),
            'size_chart' => array(self::BELONGS_TO, 'SizeChart', 'size_type'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'user_id' => Yii::t('base', 'User'),
            'category_id' => Yii::t('base', 'Category'),
            'brand_id' => Yii::t('base', 'Brand'),
            'title' => Yii::t('base', 'Name'),
            'description' => Yii::t('base', 'Description'),
            'image1' => Yii::t('base', 'Image 1'),
            'image2' => Yii::t('base', 'Image 2'),
            'image3' => Yii::t('base', 'Image 3'),
            'image4' => Yii::t('base', 'Image 4'),
            'image5' => Yii::t('base', 'Image 5'),
            'image_url1' => Yii::t('base', 'Image Url 1'),
            'image_url2' => Yii::t('base', 'Image Url 2'),
            'image_url3' => Yii::t('base', 'Image Url 3'),
            'image_url4' => Yii::t('base', 'Image Url 4'),
            'image_url5' => Yii::t('base', 'Image Url 5'),
            'color' => Yii::t('base', 'Color'),
            'price' => Yii::t('base', 'Price'),
            'init_price' => Yii::t('base', 'Original price'),
            'seller_get' => Yii::t('base', 'Seller get'),
            'item_number' => Yii::t('base', 'Item Number'),
            'added_date' => Yii::t('base', 'Added Date'),
            'condition' => Yii::t('base', 'Condition'),
            'featured' => Yii::t('base', 'Featured'),
            'featured_order' => Yii::t('base', 'Featured Order'),
            'status' => Yii::t('base', 'Status'),
            'size_type' => Yii::t('base', 'Size'),
            'category_search' => Yii::t('base', 'Category'),
            'parent_category_search' => Yii::t('base', 'Parent Category'),
            'brand_search' => Yii::t('base', 'Brand'),
            'size_search' => Yii::t('base', 'Size'),
            'user_search' => Yii::t('base', 'User'),
            'alerts_sent' => Yii::t('base', 'Alerts Sent'),
            'custom_size' => Yii::t('base', 'Custom Size'),
        );
    }

    public function isExternalSale($attribute, $params)
    {
        if($this->external_sale && (empty($this->direct_url) || empty($this->image1)) ) {
            $message = '*required';
            $this->addError($attribute, $message);
        } 
    }

    public function isNotExternalSale($attribute, $params)
    {
        if(!$this->external_sale && (empty($this->image1) || empty($this->image2) || empty($this->image3) || empty($this->category_id))) {
            $message = '*required';
            $this->addError($attribute, $message);
        } 
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

        $criteria = new CDbCriteria;
        $criteria->with = array('category', 'brand', 'user', 'size_chart');

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.our_selection', $this->our_selection);
        $criteria->compare('LOWER(user.username)', strtolower($this->user_search), true);
        $criteria->compare('LOWER(brand.name)', strtolower($this->brand_search), true);
        $criteria->compare('LOWER(size_chart.size)', strtolower($this->size_search), true);
        $criteria->compare('LOWER(t.title)', strtolower($this->title), true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.image1', $this->image1, true);
        $criteria->compare('t.image2', $this->image2, true);
        $criteria->compare('t.image3', $this->image3, true);
        $criteria->compare('t.image4', $this->image4, true);
        $criteria->compare('t.image5', $this->image5, true);
        $criteria->compare('t.color', $this->color, true);
        $criteria->compare('t.price', $this->price, true);
        $criteria->compare('t.category_id', $this->category_search, true);
        $criteria->compare('category.parent_id', $this->parent_category_search, true);
        $criteria->compare('t.init_price', $this->init_price, true);
        $criteria->compare('t.added_date', $this->added_date, true);
        $criteria->compare('t.condition', $this->condition);
        $criteria->compare('t.featured', $this->featured);
        $criteria->compare('t.featured_order', $this->featured_order);
        $criteria->compare('t.alerts_sent', $this->alerts_sent, true);
        $statuses = $this->getStatuses();
        $statuses = array_flip($statuses);
        if (isset($statuses[$this->status])) {
            $criteria->compare('t.status', $statuses[$this->status]);
        } else {
            $criteria->compare('t.status', $this->status);
        }

        if (isset($this->to_date, $this->from_date)) {
            $criteria->condition = "t.added_date BETWEEN '{$this->from_date}' AND '{$this->to_date}'";
        }

        $userId = Yii::app()->request->getQuery('userid', 0);
        if ($userId !== 0) {
            $criteria->addCondition("t.user_id = " . intval($userId));
        }

        $brandId = Yii::app()->request->getQuery('brandid', 0);
        if ($brandId !== 0) {
            $criteria->addCondition("t.brand_id = " . intval($brandId));
        }

        $categoryId = Yii::app()->request->getQuery('categoryid', 0);
        if ($categoryId !== 0) {
            $criteria->addCondition("t.category_id = " . intval($categoryId));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status DESC, t.added_date DESC',
                'attributes'=>array(
                    'category_search'=>array(
                        'asc'=>'category.alias',
                        'desc'=>'category.alias DESC',
                    ),
                    'brand_search'=>array(
                        'asc'=>'brand.name',
                        'desc'=>'brand.name DESC',
                    ),
                    'size_search'=>array(
                        'asc'=>'size_chart.size',
                        'desc'=>'size_chart.size DESC',
                    ),
                    'user_search'=>array(
                        'asc'=>'user.username',
                        'desc'=>'user.username DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getConditions()
    {
        return Yii::app()->params->conditions['types'];
    }

    public function active()
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'status = :status',
            'params' => array(
                ':status' => self::PRODUCT_STATUS_ACTIVE
            )
        ));

        return $this;
    }

    public function getConditionsName()
    {
        $conditions = self::getConditions();
        return isset($conditions[$this->condition]) ? $conditions[$this->condition] : '';
    }

    public function afterValidate()
    {
        //print_r($this);
        //die();
        /*if ($this->oldImage1 == 'blank') $this->addError('image1', Yii::t('base', '*required'));
        if ($this->oldImage2 == 'blank') $this->addError('image2', Yii::t('base', '*required'));
        if ($this->oldImage3 == 'blank') $this->addError('image3', Yii::t('base', '*required'));

        // don't rewrite images with null
        $temp = $this->model()->findByPk($this->id);

        if($temp){
            $this->image1 = $this->image1 === null ? $temp->image1 : $this->image1;
            $this->image2 = $this->image2 === null ? $temp->image2 : $this->image2;
            $this->image3 = $this->image3 === null ? $temp->image3 : $this->image3;
            $this->image4 = $this->image4 === null ? $temp->image4 : $this->image4;
            $this->image5 = $this->image5 === null ? $temp->image5 : $this->image5;
        }*/
        if($this->isNewRecord) {
            $requiredAttributes = Attribute::model()->getRequiredAttributes($this->category_id);
            foreach ($requiredAttributes as $attr_id => $value) {
                $attributeHtmlName = "Product[Attributes][".$attr_id."]";
                if (!isset($_POST['Product']['Attributes'][$attr_id])) {
                    $this->addError($attributeHtmlName, Yii::t('base', '*required'));
                } else {
                    $postValue = $_POST['Product']['Attributes'][$attr_id];
                    if (!is_array($postValue)) {
                        if (empty($postValue)) {
                            //$this->addError($attributeHtmlName, Yii::t('base', $requiredAttributes[$attr_id] . ' cannot be blank.'));
                            $this->addError($attributeHtmlName, Yii::t('base', '*required'));
                        }
                    } else {
                        $isEmptyAr = true;
                        foreach ($postValue as $arEl) {
                            if (!empty($arEl)) {
                                $isEmptyAr = false;
                                break;
                            }
                        }
                        if ($isEmptyAr) {
                            //$this->addError($attributeHtmlName, Yii::t('base', $requiredAttributes[$attr_id] . ' cannot be blank.'));
                            $this->addError($attributeHtmlName, Yii::t('base', '*required'));
                        }
                    }
                }
            }
        }

        return parent::afterValidate();
    }

    protected function beforeDelete()
    {
        if (!empty($this->image1)) {
            ImageHelper::removeOldProductImages($this->image1);
        }
        if (!empty($this->image2)) {
            ImageHelper::removeOldProductImages($this->image2);
        }
        if (!empty($this->image3)) {
            ImageHelper::removeOldProductImages($this->image3);
        }
        if (!empty($this->image4)) {
            ImageHelper::removeOldProductImages($this->image4);
        }
        if (!empty($this->image5)) {
            ImageHelper::removeOldProductImages($this->image5);
        }

        return parent::beforeDelete();
    }

    protected function beforeValidate()
    {
        
        if ($this->isNewRecord) {
            $this->added_date = new CDbExpression('NOW()');
        }
        if (isset($_POST['Product'])) {
            if (isset($_POST['Product']['custom_color']) && !empty($_POST['Product']['custom_color'])) {
                $this->color = $_POST['Product']['custom_color'];
            }

            if (isset($_POST['Product']['price']) && empty($_POST['Product']['init_price'])) {
                $this->init_price = $_POST['Product']['price'];
            }

            if ((isset($_POST['Product']['new_percentage']) && !empty($_POST['Product']['new_percentage']))) {
                $this->init_price = $_POST['Product']['price'];
                $this->price = $_POST['Product']['price'] * (100 - $_POST['Product']['new_percentage']) / 100;
            } elseif ((isset($_POST['Product']['new_price']) && !empty($_POST['Product']['new_price']))) {
                $this->init_price = $_POST['Product']['price'];
                $this->price = $_POST['Product']['new_price'];
            }
        }
        $this->title = self::getFormatedTitle($this->title);

        return parent::beforeValidate();
    }

    public function afterSave()
    {
        if (isset($_POST['Product'])) {
            $this->checkStatus();
            ProductAttribute::model()->deleteAll("product_id = " . $this->id);
            if (isset($_POST['Product']['Attributes']) && !empty($_POST['Product']['Attributes'])) {
                foreach ($_POST['Product']['Attributes'] as $attr_id => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key => $val) {
                            if (empty($val)) continue;

                            $productAttributes = new ProductAttribute();
                            $productAttributes->product_id = $this->id;
                            $productAttributes->attribute_id = intval($attr_id);
                            $productAttributes->value = $val;
                            $productAttributes->save();
                        }
                    } else {
                        $productAttributes = new ProductAttribute();
                        $productAttributes->product_id = $this->id;
                        $productAttributes->attribute_id = intval($attr_id);
                        $productAttributes->value = $value;
                        $productAttributes->save();
                    }
                }
            }
        }

        return parent::afterSave();
    }

    public function soldProducts($products)
    {
        if (!empty($products)) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition("id", $products);
            $this->updateAll(array('status' => self::PRODUCT_STATUS_SOLD), $criteria);
        }
    }

    public function termsAccept($attribute, $params)
    {
        if ($this->$attribute == 0)
            $this->addError($attribute, 'You must agree with Terms and Conditions');
    }

    public function parentCat($attribute, $params)
    {
        if (empty($this->$attribute))
            $this->addError($attribute, '*required');
    }

    public function existImg($img)
    {
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = 'image1 = :image OR image2 = :image OR image3 = :image OR image4 = :image OR image5 = :image';
        $criteria->params = array(':image' => $img);
        $product = Product::model()->findAll($criteria);
        return count($product);
    }

    public function attributes()
    {
        $result = '';
        $prodAttributes = $this->getProductAttributes($this->id);
        foreach ($prodAttributes as $prodAttribute) {
            if ($prodAttribute['isActive']) {
                $result .= $prodAttribute['attributeName']->name . ": " . $prodAttribute['definedValue'] . "<br>";
            }
        }

        return $result;
    }

    public function arrayAttributes()
    {
        $result = array();

        $attributes = Category::getAllAttributes($this->category_id);

        if ($attributes) {
            foreach ($attributes as $attribute) {
                $row = array();
                $row['type'] = $attribute->type;
                $row['isActive'] = ($attribute->status == 'active');
                $row['isRequired'] = ($attribute->required == 'yes');
                $row['attributeId'] = $attribute->id;
                $row['attributeName'] = $attribute->getNameByLanguage();
                $result[$attribute->id] = $row;
            }
        }

        return $result;
    }

    public function getStatuses()
    {
        return array(
            self::PRODUCT_STATUS_DECLINED => Yii::t('base', 'Disabled'),
            self::PRODUCT_STATUS_SOLD => Yii::t('base', 'Sold'),
            self::PRODUCT_STATUS_ACTIVE   => Yii::t('base', 'Enabled'),
            self::PRODUCT_STATUS_PENDING  => Yii::t('base', 'Pending'),
            self::PRODUCT_STATUS_DEACTIVE => Yii::t('base', 'New'),
        );
    }

    public function getStatusName()
    {
        $statuses = $this->getStatuses();
        $statusName = isset($statuses[$this->status]) ?
            $statuses[$this->status] :
            Yii::t('base', $this->status);
        return $statusName;
    }

    public function getFullSize()
    {
        return empty($this->size_chart) ?
            Yii :: t('base', 'No size') : $this -> size_chart -> size;
    }

    public function checkStatus()
    {
        if (isset($_POST['Product']['status'])) {
            if ($_POST['Product']['status'] == 'invalid') {
                foreach ($_POST['Product']['Invalid'] as $field => $value) {
                    if ($value && !is_array($value)) {
                        $invalidProd = new ProductInvalid;
                        $invalidProd->product_id = $this->id;
                        $invalidProd->field_alias = $field;
                        $invalidProd->value = $_POST['Product'][$field];
                        $invalidProd->comment = $value;
                        $invalidProd->save();
                    } else if ($value) {
                        foreach ($value as $attr => $val) {
                            $invalidProd = new ProductInvalid;
                            $invalidProd->product_id = $this->id;
                            $invalidProd->field_alias = $attr;
                            $invalidProd->value = $_POST['Product'][$field][$attr];
                            $invalidProd->comment = $val;
                            $invalidProd->save();
                        }
                    }
                }
            }

            if ($_POST['Product']['status'] == 'declined' && !empty($_POST['Product']['Declined'])) {
                $invalidProd = new ProductInvalid;
                $invalidProd->product_id = $this->id;
                $invalidProd->field_alias = 'declined';
                $invalidProd->comment = $_POST['Product']['Declined'];
                $invalidProd->save();
            }

            if ($_POST['Product']['status'] == 'active'
                && !empty($_POST['Product']['custom_color'])
                && !isset(Yii::app()->params['colors'][$_POST['Product']['custom_color']])
            ) {
                UtilsHelper::addParams('colors', strtolower($_POST['Product']['custom_color']), $_POST['Product']['custom_color']);
            }

            if ($_POST['Product']['status'] == 'active') {
                ProductInvalid::model()->deleteAll("product_id ='" . $this->id . "'");
            }
        }
    }

    public function checkInvalidField()
    {
        $invalidModel = ProductInvalid::model()->findAllByAttributes(array('product_id' => $this->id));
        $result = array();
        $fields = array('custom_color' => '');

        foreach ($this as $key => $value) {
            $fields[$key] = $value;
        }

        foreach ($this->productAttributes as $key => $value) {
            $fields[$value->getNameByLanguage()->name] = $value->getNameByLanguage()->values;
        }

        foreach ($invalidModel as $key => $value) {
            if ($fields[$value->field_alias] != $value->value) {
                $value->delete();
            } else {
                $result[$value->field_alias] = $value->comment;
            }
        }

        return $result;
    }

    public function getProductsFromChart()
    {
        $from = new DateTime(date('Y-m-d', strtotime($this->from_date)));
        $to = new DateTime(date('Y-m-d', strtotime($this->to_date)));
        $to = $to->modify('+1 day');
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function ($item) {
                return $item->format('Y-m-d H:i:s');
            },
            iterator_to_array($period)
        );

        $result = array();
        $categoryList = Category::getParrentCategoryList();

        $dataProvider = $this->search();
        $dataProvider->pagination = false;

        $result['totalCount'] = 0;
        foreach ($categoryList as $id => $name) {
            $result['category'][$id]['count'] = 0;
            $result['category'][$id]['name'] = $name;
        }
        foreach ($arrayOfDates as $key => $value) {
            $value = date('Y-m-d', strtotime($value));
            $result['labels'][$key] = $value;

            foreach ($categoryList as $id => $name) {
                $result['data'][$id][$key] = 0;
            }

            foreach ($dataProvider->getData() as $product) {
                $add_date = date('Y-m-d', strtotime($product->added_date));

                if ($add_date == $value) {
                    $result['data'][$product->category->parent->id][$key]++;
                    $result['category'][$product->category->parent->id]['count']++;
                    $result['totalCount']++;
                }
            }
        }
        return $result;
    }

    public function deleteImage($image = null)
    {
        if (!is_null($image)) {
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $image;
            if (is_file($imagePath) && $this->existImg($image) < 2) {
                unlink($imagePath);
            }
        } else {
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $this->image1;
            if (is_file($imagePath) && $this->existImg($this->image1) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $this->image2;
            if (is_file($imagePath) && $this->existImg($this->image2) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $this->image3;
            if (is_file($imagePath) && $this->existImg($this->image3) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $this->image4;
            if (is_file($imagePath) && $this->existImg($this->image4) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $this->image5;
            if (is_file($imagePath) && $this->existImg($this->image5) < 2)
                unlink($imagePath);
        }
    }

    public function getShopProducts($model, $where, $limit, $offset = 0, $order = null, $isTopCategory = false)
    {
        $category_where = "";
        $categoriesArray = [];
        if (!empty($model)) {
            $field = strtolower(get_class($model)) . '_id';

            if (!$isTopCategory || (isset($model->external_sale) && $model->external_sale)) {
                $category_where = "p.{$field} = {$model->id} AND ";
            } else {
                $category_where = Category::model()->getConditionForTop($model->id, $field);
            }
            if($isTopCategory && (isset($model->external_sale) && $model->external_sale)) {
                $child_categories = Category::model()->findAll('parent_id ='.$model->id.' AND status != "inactive"');
                foreach($child_categories as $child_category) {
                    $categoriesArray[] = $child_category->id;
                }
                if(!empty($categoriesArray)) $category_where = 'category_id IN ('.implode(',', $categoriesArray).') AND';
            }
        }

        $command = Yii:: app()->db->createCommand();
        $command->select(array('t.*'));
        $command->from(array("(SELECT p.*,
                                      u.country_id,
                                      b.name brand_name,
                                      s.size full_size, concat(pc.alias, '/', c.alias) cat,
                                      sp.seller_type
                                FROM product p
                                LEFT JOIN brand b
                                ON p.brand_id = b.id
                                LEFT JOIN size_chart s
                                ON p.size_type = s.id
                                LEFT JOIN user u
                                ON p.user_id = u.id
                                LEFT JOIN category c
                                ON p.category_id = c.id
                                LEFT JOIN category pc
                                ON pc.id = c.parent_id
                                LEFT JOIN seller_profile sp
                                ON p.user_id = sp.user_id
                                WHERE " . $category_where . " p.status IN ('active','sold')) t"));

        $command->limit($limit, $offset);
        if (!is_null($order)) {
            $command->order($order);
        }

        $command->where($where);
        $products = $command->queryAll();

        return $products;
    }

    public function getCountShopProducts($model, $where, $isTopCategory = false)
    {
        $category_where = "";
        $categoriesArray = [];
        if (!empty($model)) {
            $field = strtolower(get_class($model)) . '_id';

            if (!$isTopCategory) {
                $category_where = "p.{$field} = {$model->id} AND ";
            } else {
                $category_where = Category::model()->getConditionForTop($model->id, $field);
            }
            if($isTopCategory && (isset($model->external_sale) && $model->external_sale)) {
                $child_categories = Category::model()->findAll('parent_id ='.$model->id.' AND status != "inactive"');
                foreach($child_categories as $child_category) {
                    $categoriesArray[] = $child_category->id;
                }
                if(!empty($categoriesArray)) $category_where = 'category_id IN ('.implode(',', $categoriesArray).') AND';
            }
        }

        $item_command = Yii:: app()->db->createCommand();
        $item_command->select('COUNT(*) count');
        $item_command->from(array("(SELECT p.category_id,
                                           p.brand_id,
                                           p.our_selection,
                                           p.size_type,
                                           p.condition,
                                           p.price,
                                           p.init_price,
                                           u.country_id,
                                           sp.seller_type
                                      FROM product   p
                                      LEFT JOIN user u
                                      ON p.user_id = u.id
                                      LEFT JOIN seller_profile sp
                                      ON p.user_id = sp.user_id
                                      WHERE " . $category_where . " p.status IN ('active','sold')) t"));

        $item_command->where($where);
        $item_count = $item_command->queryRow();

        return $item_count['count'];
    }

    function getId()
    {
        return 'Product_' . $this->id;
    }

    function getPrice()
    {
        return $this->price;
    }

    public static function getProductAttributes($productId)
    {
        $result = array();
        $productAttributes = array();

        $criteria = new CDbCriteria();
        $criteria->select = array('category_id');
        $criteria->condition = 'id = ' . intval($productId);
        $product = self::model()->find($criteria);
        if (!$product) return $result;

        $attributes = Category::getAllAttributes($product->category_id);
        $productAttributeModels = ProductAttribute::model()->findAllByAttributes(array('product_id' => $productId));
        if ($productAttributeModels) {
            foreach ($productAttributeModels as $productAttributeModel) {
                $productAttributes[$productAttributeModel->attribute_id][] = $productAttributeModel;
            }
        }

        if ($attributes) {
            foreach ($attributes as $attribute) {
                $attrId = $attribute->id;
                if (isset($result[$attrId])) continue;
                if (!isset($productAttributes[$attrId])) {
                    $productAttributes[$attrId][] = array(
                        'attribute_id' => $attrId,
                        'product_id' => $productId,
                        'value' => ''
                    );
                }
                $result[$attrId] = array();
                $result[$attrId]['definedValue'] = implode(',', array_map(function ($el) {
                    return $el->value;
                }, $productAttributes[$attrId]));
                $result[$attrId]['productAttribute'] = array_pop($productAttributes[$attrId]);
                $result[$attrId]['type'] = $attribute->type;
                $result[$attrId]['isRequired'] = ($attribute->required == 'yes');
                $result[$attrId]['isActive'] = ($attribute->status == 'active');
                $result[$attrId]['attributeId'] = $attrId;
                $result[$attrId]['attributeName'] = $attribute->getNameByLanguage();
            }
        }

        return array_values($result);
    }

    public static function getProductUrl($id, $model = null)
    {
        if (is_null($model)) $model = self::model()->findByPk($id);

        $brand = $model->brand->name;
        $brand = str_replace(' ', '-', $brand);
        $category = $model->category->alias;
        $category = str_replace(' ', '-', $category);
        $parentCategory = $model->category->parent->alias;
        $title = str_replace(array('"',","),"",$model['title']);
        $changeHyphens = strtolower(str_replace(array(" ",'&','/'), "-", $title));
        $lastSymb = substr($changeHyphens, -1) == '-' ? '' : '-';
        $newid = $changeHyphens . $lastSymb . $model['id'];
        $link = strtolower('/shop/' . $parentCategory . '-' . $category . '/' . $brand . '/' . $newid);

        //return $link;
        return strtolower('/'.$newid);
    }

    public function getIsVisible()
    {
        return ($this->status == self::PRODUCT_STATUS_ACTIVE || $this->status == self::PRODUCT_STATUS_PENDING);
    }

    public function getIsSold()
    {
        return $this->status == self::PRODUCT_STATUS_SOLD;
    }

    public static function getFormatedTitle($title)
    {
        return strtolower($title);
    }

    public function canUserAddCommentsAndMakeOffers()
    {
        $isCanAddCommentsAndMakeOffers = !Yii::app()->member->isGuest;
        if ($isCanAddCommentsAndMakeOffers) {
            if (isset($this->user->sellerProfile) && $this->user->sellerProfile !== null && $this->user->sellerProfile->seller_type == SellerProfile::BUSI) {
                $isCanAddCommentsAndMakeOffers = !Yii::app()->params['misc']['business_deactive'];
            } else {
                $isCanAddCommentsAndMakeOffers = true;
            }
        }

        return $isCanAddCommentsAndMakeOffers;
    }

    // necessary after deserialization in case of manually price setting
    //
    public function __wakeup()
    {
        if($this->price_memory){
            $this->price = $this->price_memory;
        }
    }

    public function convertImage($value)
    {
        $info = pathinfo($value);
        $filename = basename($value,'.'.$info['extension']); 
        $filePath_1 = $_SERVER['DOCUMENT_ROOT'].ShopConst::IMAGE_MEDIUM_DIR.$value;
        $filePath_2 = $_SERVER['DOCUMENT_ROOT'].ShopConst::IMAGE_THUMBNAIL_DIR.$value;

        $image_1 = imagecreatefrompng($filePath_1);
        $bg = imagecreatetruecolor(imagesx($image_1), imagesy($image_1));        
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1));
        imagedestroy($image_1);       
        imagejpeg($bg, $_SERVER['DOCUMENT_ROOT'].ShopConst::IMAGE_MEDIUM_DIR.$filename .'.jpg');
        imagedestroy($bg);

        $image_2 = imagecreatefrompng($filePath_2);
        $bg = imagecreatetruecolor(imagesx($image_2), imagesy($image_2));        
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image_2, 0, 0, 0, 0, imagesx($image_2), imagesy($image_2));
        imagedestroy($image_2);       
        imagejpeg($bg, $_SERVER['DOCUMENT_ROOT'].ShopConst::IMAGE_THUMBNAIL_DIR.$filename .'.jpg');
        imagedestroy($bg);
        return $filename.'.jpg';
        
    }
    
    public static function getExternalSiteName($url)
    {
        $name = '';
        if (!empty($url)) {
            $url_arr = parse_url($url);
            $url_host = str_replace('www.', '', $url_arr['host']);
            $name = $url_host;
            //$url_host_ar = explode('.', $url_host);
            //$name = strtoupper($url_host_ar[0]);
            $url = $url_arr['scheme'] . '://' . $url_arr['host'];
        }
        
        return array('name' => $name, 'url' => $url);
    }
    
    public static function clearImages()
    {
        set_time_limit(10000);
        ini_set('memory_limit', '512M');
        
        $excluded = ['.', '..', 'blocks', 'lg', 'medium', 'thumbnail', 'images'];
        //$path = Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MAX_DIR;
        $path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR;
        $files = scandir($path);
        if (count($files) > 2) {
            foreach ($files as $file) {
                if (!in_array($file, $excluded)) {
                    $product = self::model()->find("image1 = '" . $file . "' OR image2 = '" . $file . "' OR image3 = '" . $file . "' OR image4 = '" . $file . "' OR image5 = '" . $file . "'");
                    if (!$product) {
                        unlink($path . $file);
                    }
                }
            }
        }
        
        //$path = Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR;
        $path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MEDIUM_DIR;
        $files = scandir($path);
        if (count($files) > 2) {
            foreach ($files as $file) {
                if (!in_array($file, $excluded)) {
                    $product = self::model()->find("image1 = '" . $file . "' OR image2 = '" . $file . "' OR image3 = '" . $file . "' OR image4 = '" . $file . "' OR image5 = '" . $file . "'");
                    if (!$product) {
                        unlink($path . $file);
                    }
                }
            }
        }
        
        //$path = Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_THUMBNAIL_DIR;
        $path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_THUMBNAIL_DIR;
        $files = scandir($path);
        if (count($files) > 2) {
            foreach ($files as $file) {
                if (!in_array($file, $excluded)) {
                    $product = self::model()->find("image1 = '" . $file . "' OR image2 = '" . $file . "' OR image3 = '" . $file . "' OR image4 = '" . $file . "' OR image5 = '" . $file . "'");
                    if (!$product) {
                        unlink($path . $file);
                    }
                }
            }
        }
        
        return true;
    }
}