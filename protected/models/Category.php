<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_id
 * @property string $alias
 * @property integer $status
 * @property integer $menu_order
 * @property integer $external_sale
 *
 * The followings are the available model relations:
 * @property Category $parent
 * @property Category[] $categories
 * @property CategoryName[] $categoryNames
 * @property Product[] $products
 * @property SizeType[] $sizeType
 */
class Category extends CActiveRecord
{
    public $indent = 0;
    public $hideOrder = false;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('alias, menu_order', 'required', 'message' => '*required'),
            array('parent_id, menu_order, size_chart_cat_id,external_sale', 'numerical', 'integerOnly'=>true),
            array('size_chart_cat_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('alias, status', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, parent_id, alias, status, menu_order', 'safe', 'on'=>'search'),
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
            'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
            'categories' => array(
                self::HAS_MANY,
                'Category',
                'parent_id',
                'order'=>'categories.menu_order ASC'
            ),
            'products'       => array(self::HAS_MANY, 'Product', 'category_id'),
            'categoryNames'  => array(self::HAS_MANY, 'CategoryName', 'category_id'),
            'size_chart_cat' => array(self::HAS_ONE, 'SizeChartCat', 'size_chart_cat_id'),
            'attributes'     => array(self::MANY_MANY, 'Attribute', 'attribute_category(category_id, attribute_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'parent_id' => Yii::t('base', 'Parent Category'),
            'size_chart_cat_id' => Yii::t('base', 'Size Category'),
            'alias' => Yii::t('base', 'Category Alias'),
            'status' => Yii::t('base', 'Status'),
            'menu_order' => Yii::t('base', 'Menu Order'),
            'hideOrder' => Yii::t('base', 'Hide category'),
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
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('menu_order',$this->menu_order);

        $providerOptions = array(
            'criteria'=>$criteria,
            'childRelation'=>'categories',
        );
        if (empty($criteria->condition)) {
            $providerOptions['pagination'] = array(
                'pageSize'=>1,
            );
        }

        return new DTreeActiveDataProvider($this, $providerOptions);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getParents()
    {
        $result = array('' => Yii::t('base', 'Not set'));
        $list = $this->findAllByAttributes(array('parent_id' => null));
        for($i = 0; $i < count($list); $i++) {
            if($this->id != $list[$i]->id)
                $result[$list[$i]->id] = $list[$i]->alias;
        }
        return $result;
    }

    public static function getAllAttributes($categoryId, $additionalParams = array())
    {
        $attributes = array();

        $category = self::model()->findByPk($categoryId);
        if ($category) {
            $attributes = array_merge($attributes, $category->attributes($additionalParams));
            if ($category->parent) {
                $attributes = array_merge($attributes, $category->parent->attributes($additionalParams));
            }
        }

        return $attributes;
    }

    public function getMaxOrder($parent_id = null)
    {
        $sql = "select * from " . $this->tableName() . " where parent_id " . ($parent_id === null ? ' IS NULL' : '= ' . intval($parent_id)). " order by menu_order desc";
        $maxRecord = $this->findBySql($sql);
        if(!$maxRecord) return 0;
        else return $maxRecord->menu_order;
    }

    public function getMinOrder($parent_id = null)
    {
        $sql = "select * from " . $this->tableName() . " where parent_id " . ($parent_id === null ? ' IS NULL' : '= ' . intval($parent_id)). " order by menu_order asc";
        $minRecord = $this->findBySql($sql);
        if(!$minRecord) return 0;
        else return $minRecord->menu_order;
    }

    public function getStatusName()
    {
        return Yii::t('base', $this->status);
    }

    public function getStatuses() {
        return array('active' => Yii::t('base', 'active'), 'inactive' => Yii::t('base', 'inactive'));
    }

    public function getNameByLanguage($lang = 'en') {
        $names = $this->categoryNames;

        /// get default values for new language
        $result = CategoryName::model()->findByAttributes(array('category_id' => $this->id, 'language' => 'en'));
        if(!$result) {
            $defaults = array(
                'name' => '',
                'seo_title' => '',
                'seo_description' => '',
                'seo_keywords' => '',
                'header_text' => ''
            );
            $result = new CategoryName;
            $result->attributes = $defaults;
        }
        $result->language = $lang;
        for($i = 0; $i < count($names); $i++) {
            if($names[$i]->language == $lang)
                $result = $names[$i];
        }
        return $result;
    }

    public function reOrder($order, $parent_id, $direction = 'inc') {
        if($direction == 'inc') $sign = '+';
        else $sign = '-';

        $command = Yii::app()->db->createCommand("update " . $this->tableName() . " set menu_order = menu_order $sign 1 where menu_order >= " . $order . " and parent_id " . (!$parent_id ? " IS NULL" : "= " . intval($parent_id)));
        $command->execute();
    }

    /// recalculate categories order on save for new categories
    public function beforeSave() {
        if($this->isNewRecord && $this->menu_order > 0) {
            $this->reOrder($this->menu_order, $this->parent_id);
        }
        $this->status =  $_POST['Category']['status'];
        $this->parent_id = $_POST['Category']['parent_id'];
        return parent::beforeSave();
    }

    public function afterValidate()  {
        /// check for at least english name
        if($_POST['name_en'] == '') $this->addError('name_en', Yii::t('base', 'You should fill category name for at least English language'));
        return parent::afterValidate();
    }

    public function afterSave() {
        $this->saveNames($_POST);
        return parent::afterSave();
    }

    public function saveNames($data) {
        $languages = UtilsHelper::getLanguages();
        $values = array();
        for($i = 0; $i < count($languages); $i++) {
            $values[$languages[$i]] = array(
                'name' => $data['name_' . $languages[$i]],
                'seo_title' => $data['seo_title_' . $languages[$i]],
                'seo_description' => $data['seo_description_' . $languages[$i]],
                'seo_keywords' => $data['seo_keywords_' . $languages[$i]],
                'header_text' => $data['header_text_' . $languages[$i]]
            );
            $name = CategoryName::model()->findByAttributes(array('category_id' => $this->id, 'language' => $languages[$i]));
            if(!$name) {
                $name = new CategoryName;
                $name->category_id = $this->id;
                $name->language = $languages[$i];
            }
            $name->attributes = $values[$languages[$i]];
            $name->save();
        }
    }

    public static function getFullListForDropDown() {
        $list = Category::getList();

        for($i = 0; $i < count($list); $i++) {
            $result[$list[$i]['id']] = $list[$i]['alias'];
            if(array_key_exists('children', $list[$i]) && count($list[$i]['children']) > 0)
                for($j = 0; $j < count($list[$i]['children']); $j++) {
                    $result[$list[$i]['children'][$j]['id']] = "_ _ _ _" . $list[$i]['children'][$j]['alias'];
                }
        }
        return $result;

    }

    public static function getList($parent_id = null) {
        $result = array();
        $list = Category::model()->findAllByAttributes(array('parent_id' => $parent_id));
        for($i = 0; $i < count($list); $i++) {
            $result[$i] = array('id' => $list[$i]->id, 'alias' => $list[$i]->alias);
            if($parent_id == null)
                $result[$i]['children'] = Category::getList($list[$i]->id);
        }
        return $result;
    }

    public static function getSubCategoryList($parent_id = null, $addParentAlias = true, $isFirstItemEmpty = true) {
        if ($isFirstItemEmpty) {
            $result = array('' => '');
        } else {
            $result = array();
        }

        $condition = '';

        if($parent_id) {
            $condition .= " AND parent_id = ".$parent_id;
        }
        if ($parent_id && $parent_id !== self::getIdByAlias('featured')) {
            if(Category::model()->getExternalSaleCategoryId())
                $condition .= " OR external_sale = 1";
        }
        
        $list = Category::model()->findAll('parent_id IS NOT NULL'.$condition);
        foreach ($list as $key => $value) {
            $parentName = '';
            if ($addParentAlias) {
                if (isset($value->parent)) {
                    $parentName = $value->parent->getNameByLanguage()->name . ' - ';
                }
            }
            $result[$value->id] = $parentName . $value->getNameByLanguage()->name;
        }

        return $result;
    }

    public static function getFullSubCategoryList($delimiter = '/'){
        $list = self::getList();
        $result = array();

        foreach($list as $parent){
            if(!array_key_exists('children', $parent)) continue;
            if(count($parent['children']) == 0) continue;

            foreach($parent['children'] as $child){
                $result[$child['id']] = $parent['alias'] . $delimiter . $child['alias'];
            }
        }

        return $result;
    }

    public static function getParrentCategoryList($isFirstItemEmpty = false,$external = false) {
        if ($isFirstItemEmpty) {
            $result = array('' => '');
        } else {
            $result = array();
        }
        $list = ($external) ? Category::model()->findAll('parent_id IS NULL AND status = "active"') : Category::model()->findAll('parent_id IS NULL AND status = "active" AND alias != "Shop"');
        foreach ($list as $key => $value) {
            $result[$value->id] = $value->getNameByLanguage()->name;
        }

        return $result;
    }

    public static function getSizeTypes() {
        $types = array();
        $sizeTypes = SizeType::model()->findAll();
        foreach ($sizeTypes as $sizeType) {
            $types[$sizeType->id] = $sizeType->type;
        }
        return $types;
    }

    public static function changeCatOrder($id, $move) {
        $model = Category::model()->findByPk($id);

        if($model->parent_id == null) {
            $categories = Category::model()->findAllByAttributes(array('parent_id'=>null),array('order'=>'menu_order ASC'));
        } else {
            $categories = Category::model()->findAllByAttributes(array('parent_id'=>$model->parent_id),array('order'=>'menu_order ASC'));
        }

        foreach ($categories as $key => $value) {
            if ($value->id == $id) {
                $key = ($move == 'up') ? $key - 1 : $key + 1;
                if (!isset($categories[$key])) {
                    return false;
                }
                $currentOrd = $value->menu_order;
                $changeOrd = $categories[$key]->menu_order;

                $command = Yii::app()->db->createCommand("update " . CActiveRecord::model('Category')->tableName() . " set menu_order = ".$changeOrd."  where id = ".$value->id);
                $command->execute();

                $command = Yii::app()->db->createCommand("update " . CActiveRecord::model('Category')->tableName() . " set menu_order = ".$currentOrd."  where id = ".$categories[$key]->id);
                $command->execute();
                return true;
            }
        }
    }

    public function findByPath($path)
    {
        $categories = explode('/', trim($path, '/'));
        $model = null;

        if (count($categories) == 2) {
            if ($categories[0] == 'designers') {
                $brandName = html_entity_decode($categories[1], ENT_QUOTES);
                $brandNameWithSpaces = preg_replace('/-/', ' ', $categories[1]);
                $brandNameWithSpaces1 = html_entity_decode($brandNameWithSpaces, ENT_QUOTES);

                $brandNameUrlDecoded = html_entity_decode(urldecode($categories[1]), ENT_QUOTES);
                $brandNameWithSpaces2 = html_entity_decode(urldecode($brandNameWithSpaces), ENT_QUOTES);
                $model = Brand::model()
                    -> with('size_chart')
                    //-> findByAttributes(array('name'=>$categories[1])); // doesn't work with LOWER(..)
                    ->find('LOWER(name)=:name OR LOWER(name)=:name_decoded OR LOWER(name)=:name_spaces OR LOWER(name)=:name_spaces2 OR REPLACE(LOWER(name), "-", " ")=:name_spaces OR REPLACE(LOWER(name), "-", " ")=:name_spaces2', array(
                        ':name' => strtolower($brandName),
                        ':name_decoded' => strtolower($brandNameUrlDecoded),
                        ':name_spaces' => strtolower($brandNameWithSpaces1),
                        ':name_spaces2' => strtolower($brandNameWithSpaces2)
                    ));
                $model = Brand::model()
                    -> with('size_chart')
                    //-> findByAttributes(array('name'=>$categories[1])); // doesn't work with LOWER(..)
                    ->find('url=:name', array(
                        ':name' => $categories[1]
                    ));
            } elseif ($categories[0] == 'parent') {
                $criteria_parent = new CDbCriteria;
                $criteria_parent->condition = 't.alias = :alias';
                $criteria_parent->params = array(':alias'=>$categories[1]);
                $parent = self::model()->find($criteria_parent);

                if ($parent){
                    $criteria_category = new CDbCriteria;
                    $criteria_category->condition = 't.parent_id = :parent_id';
                    $criteria_category->with = array(
                        'categoryNames' => array(
                            'condition' => 'categoryNames.language = "' . Yii::app()->getLanguage() . '"'
                        )
                    );
                    $criteria_category->params = array(':parent_id'=>$parent->id);
                    $model = self::model()->findAll($criteria_category);
                }
            } else {
                $searchid = array_pop(explode("-", $categories[1]));
                if (Product::model()->findByPk($searchid)) {
                    return 'details';
                }
                
                $isTopCategory = (strcmp($categories[0], $categories[1]) == 0);
                $criteria_parent = new CDbCriteria;
                $criteria_parent->condition = 'LOWER(t.alias) = :alias AND parent_id IS NULL';
                $criteria_parent->params = array(':alias'=>$categories[0]);
                $parent = self::model()->findAll($criteria_parent);
                
                if ($parent){
                    $criteria_category = new CDbCriteria;
                    if ($isTopCategory) {
                        $criteria_category->condition = 't.id = :parent_id';
                    } elseif($parent->external_sale == 1) {
                        $criteria_category->condition = 't.parent_id = :parent_id';
                    } else {
                        $criteria_category->condition = '(LOWER(t.alias) = LOWER(:alias) OR LOWER(t.alias) = LOWER(:alias_spaces)) AND t.parent_id = :parent_id';
                    }

                    $criteria_category->with = array(
                        'categoryNames' => array(
                            'condition' => 'categoryNames.language = "' . Yii::app()->getLanguage() . '"'
                        )
                    );
                    if ($isTopCategory) {
                        $criteria_category->params = array(':parent_id' => $parent[0]['id']);
                    } else {
                        $criteria_category->params = array(':alias'=>$categories[1], ':alias_spaces' => str_replace('-', ' ', $categories[1]), ':parent_id' => $parent[0]['id']);
                    }
                    $model = self::model()->find($criteria_category);
                }
            }
        }
        if (count($categories) == 3) {
            $searchid = array_pop(explode("-", $categories[2]));
            if (Product::model()->findByPk($searchid)) {
                return 'details';
            }
        }

        return $model;
    }

    public function getConditionForTop($topCategoryId, $field) {
        $category_where = "";

        $child_category_ids = array();
        $criteria_category = new CDbCriteria;
        $criteria_category->condition = 't.parent_id = :parent_id';
        $criteria_category->with = array(
            'categoryNames' => array(
                'condition' => 'categoryNames.language = "' . Yii::app()->getLanguage() . '"'
            )
        );
        $criteria_category->params = array(':parent_id'=>$topCategoryId);
        $categories = self::model()->findAll($criteria_category);
        if ($categories) {
            foreach ($categories as $category) {
                $child_category_ids[] = $category->id;
            }
        }
        if (!empty($child_category_ids)) {
            $category_where = "p.{$field} IN(" . implode(',', $child_category_ids) . ") AND ";
        }

        return $category_where;
    }

    public function getUrlSegment($part) {

        $segementsArr = explode('/', Yii::app()->request->pathInfo);

        if (!empty($segementsArr[count($segementsArr)-$part-1]))
            return $segementsArr[count($segementsArr)-$part-1];

        return false;
    }

    public static function getCountProduct($id) {
        $count = Product::model()->count("category_id=:category_id", array("category_id" => $id));
        return $count;
    }

    public function getAliasById($id)
    {
        $category = $this->findByPk($id);
       
        if(!empty($category)) {            
            return $category->alias;
        }
        return null;
    }

    public function getExternalSaleCategoryId()
    {
        $category = $this->findByAttributes(array('external_sale' => 1));
        return ($category) ? $category->id : NULL;
    }
    
    public static function getIdByAlias($alias)
    {
        $cat = self::model()->find("LOWER(alias) = '" . strtolower($alias) . "'");
        if ($cat) {
            return $cat->id;
        }
        return false;
    }
    
    public static function getParentByCategory($cat_id)
    {
        $cat = self::model()->findByPk($cat_id);
        if (!empty($cat->parent_id)) {
            return $cat->parent_id;
        } else {
            return $cat->id;
        }
    }
}
