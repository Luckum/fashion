<?php

/**
 * This is the model class for table "quickbooks_auth".
 *
 * The followings are the available columns in table 'quickbooks_auth':
 * @property integer $id
 * @property string $access_token
 * @property string $access_token_secret
 * @property integer $realm_id
 * @property string $service_type
 * @property string $added_date
 */
class QuickbooksAuth extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quickbooks_auth';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('access_token, access_token_secret, realm_id, service_type, added_date', 'required', 'message' => '*required'),
			array('realm_id', 'numerical', 'integerOnly'=>true),
			array('access_token, access_token_secret, service_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, access_token, access_token_secret, realm_id, service_type, added_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'access_token' => 'Access Token',
			'access_token_secret' => 'Access Token Secret',
			'realm_id' => 'Realm',
			'service_type' => 'Service Type',
			'added_date' => 'Added Date',
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
		$criteria->compare('access_token',$this->access_token,true);
		$criteria->compare('access_token_secret',$this->access_token_secret,true);
		$criteria->compare('realm_id',$this->realm_id);
		$criteria->compare('service_type',$this->service_type,true);
		$criteria->compare('added_date',$this->added_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuickbooksAuth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getToken($realm_id)
    {
    	return $this->findByAttributes(array('realm_id' => $realm_id));
    }

    public function setToken($access_token, $access_token_secret, $realm_id, $service_type)
    {
    	$this->access_token = $access_token;
        $this->access_token_secret = $access_token_secret;
        $this->realm_id = $realm_id;
        $this->service_type = $service_type;
        $this->added_date = new CDbExpression('NOW()');
        $this->save();
    }

    public static function isExpireToken()
    {
    	$qbAuth = self::model()->find();
        if ($qbAuth) {
            $oldToken = new DateTime($qbAuth->added_date);
            $now = new DateTime();
            $interval = $oldToken->diff($now);
            if ($interval->days > 150) {
            	return true;
            }
        }
        return false;
    }
}
