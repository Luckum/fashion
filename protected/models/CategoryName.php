<?php

/**
 * This is the model class for table "category_name".
 *
 * The followings are the available columns in table 'category_name':
 * @property integer $id
 * @property integer $category_id
 * @property string $language
 * @property string $name
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $header_text
 *
 * The followings are the available model relations:
 * @property Category $category
 */
class CategoryName extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category_name}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, language, name', 'required', 'message' => '*required'),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>2),
			array('name, seo_title, seo_description, seo_keywords, header_text', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, language, name, seo_title, seo_description, seo_keywords, header_text', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'category_id' => Yii::t('base', 'Category'),
			'language' => Yii::t('base', 'Language'),
			'name' => Yii::t('base', 'Category Name'),
			'seo_title' => Yii::t('base', 'SEO Title'),
			'seo_description' => Yii::t('base', 'SEO Description'),
			'seo_keywords' => Yii::t('base', 'SEO Keywords'),
			'header_text' => Yii::t('base', 'Header text')
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('seo_title',$this->seo_title,true);
		$criteria->compare('seo_description',$this->seo_description,true);
		$criteria->compare('seo_keywords',$this->seo_keywords,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryName the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
