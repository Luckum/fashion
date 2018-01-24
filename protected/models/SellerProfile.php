<?php

/**
 * This is the model class for table "seller_profile".
 *
 * The followings are the available columns in table 'seller_profile':
 * @property integer $id
 * @property integer $user_id
 * @property string $seller_type
 * @property string $comission_rate
 * @property string $paypal_email
 * @property string $rating
 *
 * The followings are the available model relations:
 * @property User $user
 */
class SellerProfile extends CActiveRecord
{
	const BUSI = 'business';
    const PRIV = 'private';
	public $email;
	public $registration_date;
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seller_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, comission_rate, seller_type', 'required', 'message' => '*required'),
			array('paypal_email', 'required', 'on' => 'saving_profile_settings', 'message' => '*required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('seller_type', 'length', 'max'=>12),
			array('comission_rate', 'numerical'),
			array('rating', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, seller_type, comission_rate, rating', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'billing_country_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'seller_type' => Yii::t('base', 'Seller'),
			'email' => Yii::t('base', 'Email'),
			'registration_date' => Yii::t('base', 'Registration date'),
			'comission_rate' => Yii::t('base', 'Comission Rate, %'),
			'paypal_email' => Yii::t('base', 'Paypal Email'),
			'billing_address' => Yii::t('base', 'Address '),
			'billing_city' => Yii::t('base', 'City'),
			'billing_state' => Yii::t('base', 'State'),
			'billing_zip' => Yii::t('base', 'Post code'),
			'billing_country_id' => Yii::t('base', 'Country'),
			'billing_first_name' => Yii::t('base', 'First name'),
			'billing_surname' => Yii::t('base', 'Last name'),
			'bank_first_name' => Yii::t('base', 'First name'),
			'bank_surname' => Yii::t('base', 'Last name'),
			'bank_iban' => Yii::t('base', 'IBAN'),
			'bank_swift_bik' => Yii::t('base', 'SWIFT/BIC'),
			'username' => Yii::t('base', 'Name'),
			'userEmail' => Yii::t('base', 'Email'),
			'user_id' => Yii::t('base', 'ID'),

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
		$criteria->with = array('user');
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('seller_type',$this->seller_type,true);
		$criteria->compare('comission_rate',$this->comission_rate,true);
		$criteria->compare('rating',$this->rating,true);
		$criteria->order = 'user.registration_date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellerProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getConditions()
	{
		return array(0 => self::PRIV, 1 => self::BUSI);
	}
    
    public function getTypes()
    {
        return array(self::PRIV  => Yii::t('base', 'Private'),
			         self::BUSI  => Yii::t('base', 'Business')
        );
    }

    public function getTypeName()
    {
        $types = $this->getTypes();
        
        return $types[$this->seller_type];
    }

	public function getUsername()
	{
		return $this->user->username;
	}

	public function getUserEmail()
	{
		return $this->user->email;
	}

	public function getRegistrationDate()
	{
		return $this->user->registration_date;
	}

	public function getStatus()
	{
		return $this->user->getStatusName();
	}
}