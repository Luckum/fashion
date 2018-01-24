<?php

/**
 * This is the model class for table "shipping_rate".
 *
 * The followings are the available columns in table 'shipping_rate':
 * @property integer $id
 * @property integer $seller_country_id
 * @property integer $buyer_country_id
 * @property integer $rate
 *
 * The followings are the available model relations:
 * @property Country $sellerCountry
 * @property Country $buyerCountry
 */
class ShippingRate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shipping_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_country_id, buyer_country_id, rate', 'required', 'message' => '*required'),
			array('seller_country_id, buyer_country_id, rate', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, seller_country_id, buyer_country_id, rate', 'safe', 'on'=>'search'),
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
			'sellerCountry' => array(self::BELONGS_TO, 'Country', 'seller_country_id'),
			'buyerCountry' => array(self::BELONGS_TO, 'Country', 'buyer_country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'seller_country_id' => Yii::t('base', 'Seller Country'),
			'buyer_country_id' => Yii::t('base', 'Buyer Country'),
			'rate' => Yii::t('base', 'Rate, EUR'),
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
        $criteria->with = array('sellerCountry', 'buyerCountry');

		$criteria->compare('t.id',$this->id);
		$criteria->compare('sellerCountry.name',$this->seller_country_id);
		$criteria->compare('buyerCountry.name',$this->buyer_country_id);
		$criteria->compare('t.rate',$this->rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShippingRate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getRate($seller_country_id, $buyer_country_id) {
		if ($rate = self::model()->findByAttributes(array('seller_country_id'=>$seller_country_id, 'buyer_country_id'=>$buyer_country_id))) {
			return $rate->rate;
		} elseif ($rate = ShippingRateDefault::model()->findByAttributes(array('country_id'=>$seller_country_id))) {
			return $rate->rate;
		} else {
			return Yii::app()->params['shipping']['default_rate'];
		}
	}

	public function getRatesByCountries() {
		$res = array();
		$countries = Country::getListIdCountry();
		$rates = self::model()->findAll();
		
		foreach ($rates as $rate) {
			$res[$rate->sellerCountry->name][$rate->buyerCountry->name] = $rate->rate;
		}

		return $res;
	}

	public function getShippingRate($user_id = null, $order_id = null, $get_shipping_ar = false) {
		if (!$user_id)
			$user_id = Yii::app()->member->id;
		$user = User::model()->findByPk($user_id);
		$product_users = array();
		$shipping_rate = 0;
		if ($order_id) {
			$order = Order::model()->findByPk($order_id);
			if (isset($order->orderItems)) {
				foreach ($order->orderItems as $item) {
					$products[] = $item->product;
				}
			}
		} else {
			$products = Yii::app()->shoppingCart->getPositions();
		}
		
		foreach ($products as $product) {
			$product_users[$product->id] = $product->user->country_id;
		}

		$shipping_ar = array();

		$buyer_country_id = $user->country_id;
		if (isset($_POST['shipping_country_id']) && is_numeric($_POST['shipping_country_id'])) {
			$buyer_country_id = $_POST['shipping_country_id'];
		}

		foreach ($product_users as $product_id => $country_id) {
			$rate = self::getRate($country_id, $buyer_country_id);
			$shipping_ar[$product_id] = $rate;
			$shipping_rate += $rate;
		}
		if (!$get_shipping_ar) {
			return $shipping_rate;
		} else {
			return array($shipping_rate, $shipping_ar);
		}
	}

	public function getItemShippingRate($orderItem) {
		if ($orderItem->order->shipping_cost == 0) return 0;
		if ($orderItem->order->shippingAddress->country_id == 0) return 0;

		$buyer_country_id = $orderItem->order->shippingAddress->country_id;
		$country_id = $orderItem->product->user->country_id;
		return self::getRate($country_id, $buyer_country_id);
	}
}