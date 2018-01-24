<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property integer $id
 * @property string $name
 * @property string $code_iso
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
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
			array('name', 'length', 'max'=>64),
			array('code_iso', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code_iso', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'country_id'),
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
			'code_iso' => 'Code Iso',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code_iso',$this->code_iso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getListCountry() {
        $result = array();
        $list = Country::model()->findAll();
        
        foreach ($list as $key => $value) {
        	$result[$value->code_iso] = $value->name;
        }
        
        return $result;
    }

    public static function getListIdCountry() {
        $result = array(""=>Yii::t('base', ''));
        $list = Country::model()->findAll();
        
        foreach ($list as $key => $value) {
        	$result[$value->id] = $value->name;
        }
        
        return $result;
    }

	public static function jquery_source() {
		// An array of objects with label and value properties:
		// [ { label: "Choice1", value: "value1" }, ... ]

		$list = Country::model()->findAll();

		$count = count($list);

		if(!$count) return '[]';

		$result = '[ { label: " ", value: " " }, '; // begin with empty item

		foreach ($list as $key => $value) {
			if(--$count < 0) break;

			$result .= '{ label: "' . $value->name . '", value: "' . $value->id . '" }';

			if($count > 0) $result .= ', ';
		}

		$result .= ' ]'; // close array

		return $result;
	}
}



















