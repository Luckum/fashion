<?php

/**
 * This is the model class for table "rating".
 *
 * The followings are the available columns in table 'rating':
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $seller_id
 * @property integer $communication
 * @property integer $description
 * @property integer $shipment
 * @property string $total
 * @property string $added_date
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property User $user
 * @property Product $seller
 */
class Rating extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rating}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, user_id, seller_id, communication, description, shipment, total, added_date', 'required', 'message' => '*required'),
			array('product_id, user_id, seller_id, communication, description, shipment', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, user_id, seller_id, communication, description, shipment, total, added_date', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'Product', 'seller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'product_id' => Yii::t('base', 'Product'),
			'user_id' => Yii::t('base', 'User'),
			'seller_id' => Yii::t('base', 'Seller'),
			'communication' => Yii::t('base', 'Communication'),
			'description' => Yii::t('base', 'Description'),
			'shipment' => Yii::t('base', 'Shipment'),
			'total' => Yii::t('base', 'Total'),
            'added_date' => Yii::t('base', 'Date Rating'),
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

		$criteria->with = array('user' => array('alias' => 'buyer'), 'product', 'seller.user');
        $criteria->compare('id',$this->id);
		$criteria->compare('product.title',$this->product_id);
		$criteria->compare('buyer.username',$this->user_id);
		$criteria->compare('user.username',$this->seller_id);
		$criteria->compare('added_date',$this->added_date,true);
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function addRating() {
		$product = Product::model()->findByPk($_POST['product_id']);

		$this->product_id = $product->id;
		$this->user_id = Yii::app()->member->id;
		$this->seller_id = $product->user_id;
		$this->communication = $_POST['communication'];
		$this->description = $_POST['description'];
		$this->shipment = $_POST['shipment'];
		$this->total = round(($_POST['communication'] + $_POST['description'] + $_POST['shipment']) * 1.0 / 3, 2);
		$this->added_date = new CDbExpression('NOW()');
		if (!$this->save()) {
			return 0;
		}
		return true;
	}

	public static function alreadyReview($product_id) {
		$exists = self::model()->exists('user_id='.Yii::app()->member->id.' AND product_id='.$product_id.' AND total!="0.00"');
		return $exists;
	}
}
