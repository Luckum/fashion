<?php

/**
 * This is the model class for table "transaction_seller".
 *
 * The followings are the available columns in table 'transaction_seller':
 * @property integer $id
 * @property string $txn_id
 * @property integer $order_item_id
 * @property string $total
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property OrderItem $orderItem
 */
class TransactionSeller extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction_seller';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txn_id, order_item_id, total', 'required', 'message' => '*required'),
			array('order_item_id, status', 'numerical', 'integerOnly'=>true),
			array('txn_id', 'length', 'max'=>255),
			array('total', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, txn_id, order_item_id, total, status', 'safe', 'on'=>'search'),
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
			'orderItem' => array(self::BELONGS_TO, 'OrderItem', 'order_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'txn_id' => 'Txn',
			'order_item_id' => 'Order Item',
			'total' => 'Total',
			'status' => 'Status',
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
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('order_item_id',$this->order_item_id);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionSeller the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function txnExist($txnId)
    {
		return self::model()->find(array(
		        'select'=>'id',
		        'condition'=>'txn_id=:txn_id',
		        'params'=>array(':txn_id' => $txnId)
		    ),
			array(
				'limit' => 1
			)
	    );    	
    }
}
