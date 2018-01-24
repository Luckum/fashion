<?php

/**
 * This is the model class for table "attribute_name".
 *
 * The followings are the available columns in table 'attribute_name':
 * @property integer $id
 * @property integer $attribute_id
 * @property string $language
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Attribute $attribute
 */
class AttributeName extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attribute_name}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_id, language, name', 'required', 'message' => '*required'),
			array('attribute_id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>2),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, attribute_id, language, name, values', 'safe', 'on'=>'search'),
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
			'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'attribute_id' => Yii::t('base', 'Attribute'),
			'language' => Yii::t('base', 'Language'),
            'name' => Yii::t('base', 'Displayed name'),
			'values' => Yii::t('base', 'Defined value(s)'),
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
		$criteria->compare('attribute_id',$this->attribute_id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttributeName the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}