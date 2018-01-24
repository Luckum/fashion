<?php

/**
 * This is the model class for table "wishlist".
 *
 * The followings are the available columns in table 'wishlist':
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Product $product
 */
class Wishlist extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wishlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, product_id', 'required', 'message' => '*required'),
			array('user_id, product_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, product_id', 'safe', 'on'=>'search'),
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
			'user'    => array(self::BELONGS_TO, 'User',    'user_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'brand'   => array(self::BELONGS_TO, 'Brand',   '', 'on' => 'product.brand_id = brand.id'),
            'size'    => array(self::HAS_ONE,    'SizeChart',    '', 'on' => 'product.size_type = size.id')
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
			'product_id' => 'Product',
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
		$criteria->compare('product_id',$this->product_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wishlist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function changeWish($product_id) {
		$wishlist = self::model()->findByAttributes(array('product_id'=>$product_id));
		if ($wishlist) {
			if ($wishlist->delete()) {
				return 1;
			}
		} else {
			$wishlist = new Wishlist;
			$wishlist->user_id = Yii::app()->member->id;
			$wishlist->product_id = $product_id;
			if ($wishlist->save()) {
				return 1;
			}
		}
		return 0;
	}

	public static function in_wishlist($product_id) {
		$inWish = self::model()->exists(
			'product_id = :product_id AND user_id = :user_id',
			array(':product_id'=> $product_id, ':user_id' => Yii::app()->member->id)
		);
		return $inWish;
	}
}
