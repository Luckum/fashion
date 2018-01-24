<?php

/**
 * This is the model class for table "size_chart_cat".
 *
 * The followings are the available columns in table 'size_chart_cat':
 * @property string $id
 * @property string $name
 * @property integer $top_category
 *
 * The followings are the available model relations:
 * @property Category[] $categories
 * @property SizeChart[] $sizeCharts
 * @property Category $topCategory
 */
class SizeChartCat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'size_chart_cat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, top_category', 'required', 'message' => '*required'),
			array('top_category', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, top_category', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY, 'Category', 'size_chart_cat_id'),
			'sizeCharts' => array(self::HAS_MANY, 'SizeChart', 'size_chart_cat_id'),
			'topCategory' => array(self::BELONGS_TO, 'Category', 'top_category'),
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
			'top_category' => 'Top Category',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('top_category',$this->top_category);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SizeChartCat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTopCategories()
	{
		$data = array();
		$categories = Category::model()->findAll('parent_id IS NULL');
		foreach($categories as $category) {
			$data[$category->id] = $category->alias;
		}
		return $data;
	}
}
