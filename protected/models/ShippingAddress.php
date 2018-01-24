<?php

/**
 * This is the model class for table "shipping_address".
 *
 * The followings are the available columns in table 'shipping_address':
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country_id
 * @property integer $last_used
 * @property string $first_name
 * @property string $surname
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property User $user
 */
class ShippingAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shipping_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, address, city, zip, country_id, phone', 'required', 'message' => '*required'),
            array('first_name, surname', 'required', 'on' => 'saving_profile_settings', 'message' => '*required'),
			array('user_id, last_used', 'numerical', 'integerOnly'=>true),
			array('address, address_2, city, state, first_name, surname', 'length', 'max'=>255),
            array('first_name, surname', 'length', 'max'=>255, 'on' => 'saving_profile_settings'),
			array('zip', 'length', 'max'=>20),
            array('phone', 'length', 'max' => 50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, address, address_2, city, state, zip, country_id, last_used, phone', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'shipping_address_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'address' => 'Address',
			'address_2' => 'Address 2',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Post code',
			'country_id' => 'Country',
			'last_used' => 'Last Used',
			'first_name' => 'First name',
			'surname' => 'Last name',
			'phone' => 'Phone'
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address_2',$this->address_2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('last_used',$this->last_used);
        $criteria->compare('phone',$this->phone);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShippingAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function actualAddress() {
		$shipping_addresses = ShippingAddress::model()->findAllByAttributes(array('user_id'=>Yii::app()->member->id, 'last_used'=>1));
        $isSavedActiveAddress = false;
		foreach ($shipping_addresses as $shipping_address) {
            $isSavedActiveAddress = true;
            if (isset($_POST['rememberAddress']) && $_POST['rememberAddress'] == 1) {
    			$shipping_address->last_used = 0;
    			$shipping_address->save();
            }
		}
        $lastUsedForSave = 0;
        if (isset($_POST['rememberAddress']) && $_POST['rememberAddress'] == 1) {
            $lastUsedForSave = 1;
        }
        $countryId = $_POST['country_pay'];
        // if (isset($_POST['shipping_country_id']) && is_numeric($_POST['shipping_country_id'])) {
        //     $countryId = intval($_POST['shipping_country_id']);
        // }
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'user_id = :userId 
    							AND address = :address 
    							AND address_2 = :address2 
    							AND city = :city 
    							AND state = :state 
    							AND zip = :zip 
    							AND country_id = :country_id
								AND first_name = :first_name
								AND surname = :surname
								AND phone = :phone';
        $criteria->params = array(':userId' => Yii::app()->member->id, 
        						  ':address' => $_POST['address'],
        						  ':address2' => $_POST['address2'],
        						  ':city' => $_POST['city'],
        						  ':state' => $_POST['state'],
        						  ':zip' => $_POST['zip_code'],
								  ':first_name' => $_POST['firstname'],
								  ':surname' => $_POST['lastname'],
        						  ':country_id' => $countryId,
                                  ':phone' => $_POST['phone']);

        $address = self::model()->find($criteria);

        if ($address) {
            if ($isSavedActiveAddress && (!isset($_POST['rememberAddress']) || $_POST['rememberAddress'] != 1)) {
                $lastUsedForSave = 1;
            }
            $address->last_used = $lastUsedForSave;
        } else {
        	$address = new ShippingAddress;
        	$address->user_id = Yii::app()->member->id;
        	$address->address = $_POST['address'];
        	$address->address_2 = $_POST['address2'];
        	$address->city = $_POST['city'];
        	$address->state = $_POST['state'];
        	$address->zip = $_POST['zip_code'];
        	$address->country_id = $countryId;
			$address->first_name = $_POST['firstname'];
			$address->surname = $_POST['lastname'];
            $address->phone = $_POST['phone'];
        	$address->last_used = $lastUsedForSave;
        }
        
        $address->save(false);
        return $address;
	}

    public function getLastUsedShippingAddress($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = Yii::app()->member->id;
        }
        
        $shipping_addresses = ShippingAddress::model()->findAllByAttributes(
            array(
                'user_id'=>$user_id, 
                'last_used'=>1
            )
        );
        if (!$shipping_addresses) {
            $shipping_address = new ShippingAddress();
        } else {
            foreach (array_reverse($shipping_addresses) as $value) {
                $shipping_address = $value;
                break;
            }
        }
       return $shipping_address;
    }
}