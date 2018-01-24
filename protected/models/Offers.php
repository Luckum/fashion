<?php

/**
 * This is the model class for table "offers".
 *
 * The followings are the available columns in table 'offers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $seller_id
 * @property integer $product_id
 * @property integer $offer
 * @property string $added_date
 * @property bool $confirm
 * @property bool $read
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property User $user
 * @property User $seller
 */
class Offers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, seller_id, product_id, offer, added_date', 'required', 'message' => '*required'),
			array('user_id, seller_id, product_id, offer', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, seller_id, product_id, offer, added_date', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'seller' => array(self::BELONGS_TO, 'User', 'seller_id'),
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
			'seller_id' => 'Seller',
			'product_id' => 'Product',
			'offer' => 'Offer',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('seller_id',$this->seller_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('offer',$this->offer);
		$criteria->compare('added_date',$this->added_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function makeOffer($product) {
		$this->user_id = Yii::app()->member->id;
		$this->seller_id = $product->user_id;
		$this->product_id = $product->id;
		$this->offer = $_POST['new_price'];
		$this->added_date = new CDbExpression('NOW()');
		$this->save();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Offers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getUnreadOffers(){
		$temp = self::getOffersForSeller();

		$new = array();

		foreach($temp as $offer){
			if($offer->read == 0){
				array_push($new, $offer);
			}
		}

		return $new;
	}

	public static function getUnusedOffers(){
		$user_id = Yii::app()->member->id;

		$offers = self::model()->findAllBySql(
			"call fashion.get_offers('unused', $user_id)"
		);

		return $offers;
	}

	public static function getOffersForSeller(){
		$member_id = Yii::app()->member->id;

		$offers = self::model()->findAllBySql(
			"call fashion.get_offers('seller', $member_id);");

		return $offers;
	}

	public function setAsRead($userId)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('seller_id', $userId);
		$this->updateAll(array('read' => 1), $criteria);
	}

	public function setConfirmedAsRead($userId)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('user_id', $userId);
		$criteria->compare('confirm', 1);
		$this->updateAll(array('read_confirmed' => 1), $criteria);
	}

	public static function getOffersForBuyer(){
		$member_id = Yii::app()->member->id;

		$offers = self::model()->findAllBySql(
			"call fashion.get_offers('buyer', $member_id);");

		return $offers;
	}

	public static function getOffersFromBuyer(){
		$member_id = Yii::app()->member->id;

		$offers = self::model()->findAll('user_id ='.$member_id);

		return $offers;
	}

	public static function deleteExpireOffers($hours){
		$user_id = Yii::app()->member->id;

		$command =
			Yii::app()->db->createCommand("call fashion.delete_offers($user_id, $hours)");

		$command->execute();
	}
}



















