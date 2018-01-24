<?php

/**
 * This is the model class for table "size".
 *
 * The followings are the available columns in table 'size':
 * @property integer $id
 * @property integer $size_type_id
 * @property string $country
 * @property string $size
 * @property string $gender
 *
 * The followings are the available model relations:
 * @property SizeType $sizeType
 */
class Size extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'size';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size_type_id, country, size, gender', 'required'),
			array('size_type_id', 'numerical', 'integerOnly'=>true),
			array('country, size', 'length', 'max'=>20),
			array('gender', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, size_type_id, country, size, gender', 'safe', 'on'=>'search'),
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
			'sizeType' => array(self::BELONGS_TO, 'SizeType', 'size_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'size_type_id' => 'Size Type',
			'country' => 'Country',
			'size' => 'Size',
			'gender' => 'Gender',
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
		$criteria->compare('size_type_id',$this->size_type_id);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('gender',$this->gender,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Size the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getAllSize($size_type_id, $gender) {
		$result = array();

    	$sizeCountry=Size::model()->findAll(
        	array(
	        	'condition'=>'gender=:gender AND size_type_id=:size_type_id',
	        	'group'=>'country',
	        	'params'=>array(
	        		':gender'=>$gender, 
	        		':size_type_id'=>$size_type_id
	        	),
        	)
        );  
        
        foreach ($sizeCountry as $value) {
        	$result[$value->country] = $value->country;
        }

    	return $result;
	}

	public static function getSizeForGender($size_type_id, $gender) {
		$result = array();

    	$sizeCountry=Size::model()->findAll(
        	array(
        		'select'=>'country',
	        	'condition'=>'gender=:gender AND size_type_id=:size_type_id',
	        	'group'=>'country',
	        	'params'=>array(
	        		':gender'=>$gender, 
	        		':size_type_id'=>$size_type_id
	        	),
        	)
        );  
        
        foreach ($sizeCountry as $value) {
        	$result[$value->country] = $value->country;
        }

    	return $result;
	}

	public static function getSizeForCountry($size_type_id, $gender, $size_country) {
		$result = array();

    	$size=Size::model()->findAll(
        	array(
	        	'condition'=>'country=:country AND gender=:gender AND size_type_id=:size_type_id',
	        	'params'=>array(
	        		':country'=>$size_country, 
	        		':gender'=>$gender,
	        		':size_type_id'=>$size_type_id
	        	),
        	)
        );  

    	foreach ($size as $value) {
        	$result[$value->id] = $value->size;
        }
        
	    return $result;
	}

	public static function getSizeForSizeType($size_type) {
		$result = array();

    	$size = Size::model()->findAll('size_type_id='.$size_type);  

    	foreach ($size as $value) {
        	$result[$value->id] = $value->size." (".$value->country.")";
        }
        
	    return $result;
	}

	public static function getSizeCountry() {
		$result = array();

    	$size = Size::model()->findAll();  

    	foreach ($size as $value) {
        	$result[$value->country] = $value->country;
        }
        
	    return $result;
	}

	public static function getSizeForCountrySize($country) {
		$result = array();

    	$size = Size::model()->findAll('country=:country', array(':country' =>$country));  
    	
    	foreach ($size as $value) {
        	$result[$value->size] = $value->size;
        }
        
	    return $result;
	}

	public static function getSizeChart($size_type_id) {
		$result = array();

		$sizeCountry=Size::model()->findAll(
        	array(
                'select' => 'country, size',
        		'condition'=>'size_type_id=:size_type_id',
	        	'group'=>'country, size',
	        	'params'=>array(
	        		':size_type_id'=>$size_type_id,
	        	)
        	)
        );
		
        foreach ($sizeCountry as $key => $value) {
        	$sizes=Size::model()->findAll(
        		array(
                    'select' => 'size',
	        		'condition'=>'country=:country',
		        	'group'=>'size',
		        	'params'=>array(
		        		':country'=>$value->country,
		        	)
		        )
	        );
	        
	        foreach ($sizes as $size) {
	        	if ($value->country == 'International') {
	        		$key = 'INT';
	        	} elseif ($value->country == 'Inches') {
	        		$key = 'INCH';
	        	} else {
	        		$key = $value->country;
	        	}
	        	$result[$key][] = $size->size;
	        }
        }
        
        return $result;
	}

    public static function getAllSizeList($size_type_id, $gender = null) {
        $result = array();

        if (!is_null($gender)) {
            $condition = 'gender=:gender AND size_type_id=:size_type_id';
            $params = array(
                ':gender'=>$gender, 
                ':size_type_id'=>$size_type_id
            );
        } else {
            $condition = 'size_type_id=:size_type_id';
            $params = array(
                ':size_type_id'=>$size_type_id
            );
        }

        $sizes = Size::model()->findAll(
            array(
                'condition'=>$condition,
                //'group'=>'size',
                'params'=>$params,
            )
        );

        $result = array();
        
        foreach ($sizes as $value) {
            $result[$value->id] = $value->size." (".$value->country.")";
        }

        return $result;
    }
}