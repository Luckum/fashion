<?php

/**
 * This is the model class for table "size_chart".
 *
 * The followings are the available columns in table 'size_chart':
 * @property string $id
 * @property string $type
 * @property string $size
 * @property string $size_chart_cat_id
 *
 * The followings are the available model relations:
 * @property SizeChartCat $sizeChartCat
 */
class SizeChart extends CActiveRecord
{
    public $size_cat_search;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'size_chart';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, size, size_chart_cat_id', 'required', 'message' => '*required'),
            array('type, size', 'length', 'max'=>20),
            array('size_chart_cat_id', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, size, size_cat_search', 'safe', 'on'=>'search'),
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
            'sizeChartCat' => array(self::BELONGS_TO, 'SizeChartCat', 'size_chart_cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'size' => 'Size',
            'size_chart_cat_id' => 'Size Chart Cat',
            'size_cat_search' => 'Size Chart Cat',
        );
    }

    /**
     * @param integer $size_cat ID категории размеров.
     * @return array Массив размеров указанной категории.
     */
    public function getSizes($size_cat, $natsort = true, $catModel = null)
    {
        $sizes = array();
        $showAllTypesForTopCategory = false;
        if (!is_null($size_cat)) {
            $data  = $this
               -> with('sizeChartCat')
               -> findAllByAttributes(array('size_chart_cat_id' => $size_cat));            
        } elseif (!is_null($catModel) && ($catModel instanceof Category) && !$catModel->parent_id) {
            $showAllTypesForTopCategory = true;
            $data  = $this->with(array('sizeChartCat' => array(
                    'condition' => 'top_category = :top_category',
                    'params'=>array('top_category'=>$catModel->id)
                )
               ))
               -> findAll();
        } elseif (!is_null($catModel) && ($catModel instanceof Category) && $catModel->parent_id) {
            $showAllTypesForTopCategory = true;
            $data  = $this->with(array('sizeChartCat' => array(
                    'condition' => 'top_category = :top_category',
                    'params'=>array('top_category'=>$catModel->parent_id)
                )
               ))
               -> findAll();
        } else {
            $showAllTypesForTopCategory = true;
            $data  = $this->with(array('sizeChartCat'))
               -> findAll();            
        }
        
        foreach ($data as $item) {
            if (!$showAllTypesForTopCategory) {
                $type = $item['type'];
            } else {
                $type = $item->sizeChartCat['name'] . ' (' . $item['type'] . ')';
            }
            
            if (!isset($sizes[$type])) {
                $sizes[$type] = array();
            }
            $sizes[$type][] = array($item['id'], $item['size']);
        }
        if ($natsort) {
            foreach ($sizes as &$sizeAr) {
                usort($sizeAr, function($a, $b){
                    return strnatcmp($a[1], $b[1]);
                });
            }
        }
        $topName = $data[0]['sizeChartCat']['name'];
        if (is_array($catModel) && empty($catModel)) {
            $topName = Yii::t('base', 'All');
        }
        if ($showAllTypesForTopCategory && isset($catModel->categoryNames) && isset($catModel->categoryNames[0]['name'])) {
            $topName = ucfirst(strtolower($catModel->categoryNames[0]['name']));
        } elseif (!is_null($catModel) && ($catModel instanceof Brand) && isset($catModel->name)) {
            $topName = $catModel->name;
        }
 
        return array($topName, $sizes);
    }

    public static function getSizeOptions($size_cat) {
        $result = array();

        $sizeCountry=SizeChart::model()->findAll(
            array(
                'select'=>'type',
                'condition'=>'size_chart_cat_id=:id',
                'group'=>'type',
                'params'=>array(
                    ':id'=>$size_cat,
                ),
            )
        );

        foreach ($sizeCountry as $value) {
            $result[$value->type] = $value->type;
        }

        return $result;
    }

    public static function getSizeTypeOptions($size_cat, $size_country) {
        $result = array();

        $sizeType=SizeChart::model()->findAll(
            array(
                'select'=>'size',
                'condition'=>'size_chart_cat_id=:id AND type=:type',
                'group'=>'size',
                'params'=>array(
                    ':id'=>$size_cat,
                    ':type'=>$size_country
                ),
            )
        );

        foreach ($sizeType as $value) {
            $result[$value->size] = $value->size;
        }

        return $result;
    }

    public static function getCountrySize($cat_id) {
        $result = array();
        $category = Category::model()->find('id = :id', array(':id' => $cat_id));
        $sizeCountry=SizeChart::model()->findAll(
            array(
                'select'=>'type',
                'condition'=>'size_chart_cat_id=:scci',
                'group'=>'type',
                'params'=>array(
                    ':scci'=>$category->size_chart_cat_id,
                ),
            )
        );

        foreach ($sizeCountry as $value) {
            $result[$value->type] = $value->type;
        }

        return $result;
    }

    public static function getSizeType($cat_id) {
        $result = array();
        $category = Category::model()->find('id = :id', array(':id' => $cat_id));
        $sizeCountry=SizeChart::model()->findAll(
            array(
                'select'=>'size',
                'condition'=>'size_chart_cat_id=:scci',
                'group'=>'size',
                'params'=>array(
                    ':scci'=>$category->size_chart_cat_id,
                ),
            )
        );

        foreach ($sizeCountry as $value) {
            $result[$value->size] = $value->size;
        }

        return $result;
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

        $criteria->with = array( 'sizeChartCat' );

        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('LOWER(t.type)',strtolower($this->type),true);
        $criteria->compare('LOWER(t.size)',strtolower($this->size),true);
        $criteria->compare('sizeChartCat.name',$this->size_cat_search,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'size_cat_search'=>array(
                        'asc'=>'sizeChartCat.name',
                        'desc'=>'sizeChartCat.name DESC',
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
     * @return SizeChart the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getSizeChartCategories($keyFieldName = 'id')
    {
        $data = array();
        $categories = SizeChartCat::model()->findAll();
        foreach($categories as $category) {
            $data[$category->{$keyFieldName}] = $category->name;
        }
        return $data;
    }

    public function getAllFieldValues($fieldName)
    {
        $result = array();
        $sizes = SizeChart::model()->findAll(
            array(
                'select' => $fieldName, 
                'order' => $fieldName . ' ASC'              
            )
        );

        foreach ($sizes as $value) {
            $result[$value->{$fieldName}] = $value->{$fieldName};
        }

        return $result;
    }
}
