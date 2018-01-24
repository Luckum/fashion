<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $coupon_id
 * @property string $status
 * @property string $price
 * @property string $comission_rate
 * @property string $document
 * @property integer $shipping_cost
 * @property string $tracking_link
 * @property string $tracking_number
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Product $product
 * @property ShippingCoupon $coupon
 */
class OrderItem extends CActiveRecord
{
	public $totalAmount;
    public $seller;
    public $shipping_rate;
	public $document;

	/**
	 * Статусы продуктов заказа.
	 */
	const OI_STATUS_PAID     = 'paid';
	const OI_STATUS_SHIPPED  = 'shipped';
	const OI_STATUS_AWAITING = 'awaiting';
	const OI_STATUS_COUPONED = 'couponed';
	const OI_STATUS_RECEIVED = 'received';

    /**
     * Статусы отгрузки продуктов заказа.
     */
    const OI_SHIP_STATUS_LABEL_SENT   = 'label sent';
    const OI_SHIP_STATUS_SHIPPED = 'shipped';
    const OI_SHIP_STATUS_RECEIVED  = 'received';
    const OI_SHIP_STATUS_RETURNED  = 'returned';
    const OI_SHIP_STATUS_COMPLETE  = 'complete';

    /**
     * Проценты комиссии PayPal
     */

    const USD_PAY = 0.3;
    const USD_FEE_PERCENT = 0.039;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, price, comission_rate', 'required', 'message' => '*required'),
			array('order_id, product_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('price', 'length', 'max'=>9),
            array('tracking_number, tracking_link', 'length', 'max'=>200),
			array('comission_rate', 'numerical'),
            array('shipping_status', 'length', 'max' => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, document, product_id, tracking_number, tracking_link, coupon_id, status, price, comission_rate, shipping_cost', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'coupon' => array(self::BELONGS_TO, 'ShippingCoupon', 'coupon_id'),
            'transaction' => array(self::HAS_ONE, 'TransactionSeller', 'order_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('base', 'ID'),
			'order_id' => Yii::t('base', 'Order'),
			'product_id' => Yii::t('base', 'Product'),
			'coupon_id' => Yii::t('base', 'Coupon'),
			'status' => Yii::t('base', 'Status'),
			'price' => Yii::t('base', 'Price, EUR'),
			'comission_rate' => Yii::t('base', 'Comission Rate'),
            'seller' => Yii::t('base', 'Seller'),
            'shipping_status' => Yii::t('base', 'Shipping Status'),
            'shipping_rate' => Yii::t('base', 'Shipping Rate, EUR'),
			'document' => Yii::t('base', 'Coupon File'),
            'shipping_cost' => Yii::t('base', 'Shipping cost'),
            'tracking_number' => Yii::t('base', 'Tracking number'),
            'tracking_link' => Yii::t('base', 'Tracking link')
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
	public function search($orderId = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('product', 'product.user');
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product.title',$this->product_id,true);
		$criteria->compare('t.status',$this->status,true);
		$criteria->compare('t.price',$this->price,true);
		$criteria->compare('comission_rate',$this->comission_rate,true);
        $criteria->compare('shipping_cost',$this->shipping_cost,true);
        $criteria->compare('t.shipping_status',$this->shipping_status,true);
        
        if (!empty($orderId)) {
            $criteria->addCondition("t.order_id = " . $orderId);
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Возвращает cписок статусов продукта заказа.
     * @returns array.
     */
	public function getStatus()
    {
        $result = array();
        // Список возможных статусов, полученных из схемы базы данных.
        preg_match_all('/\'(.+?)\'/', $this -> tableSchema -> columns['status'] -> dbType, $statuses);
        foreach ($statuses[1] as $item) {
            $result[$item] = Yii :: t('base', $item);
        }
        return $result;
    }

	public function getDeliveryStatus()
	{
		$result = array();
		// Список возможных статусов, полученных из схемы базы данных.
		preg_match_all('/\'(.+?)\'/', $this -> tableSchema -> columns['shipping_status'] -> dbType, $statuses);
		foreach ($statuses[1] as $item) {
			$result[$item] = Yii :: t('base', $item);
		}
		return $result;
	}
    
    public function getTotalByUser($userId, $filter = 0, $startDate = '', $endDate = '')
    {
        switch ($filter) {
            case 1:
                $condition = "order.added_date LIKE '" . date('Y-m-d') . "%'";
            break;
            case 2:
                $condition = "order.added_date BETWEEN '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 8, date("Y"))) . "' AND '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))) . "'";
            break;
            case 3:
                $condition = "order.added_date BETWEEN '" . date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y"))) . "' AND '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))) . "'";
            break;
            case 4:
                $condition = "order.added_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            break;
            default:
                $condition = '';
        }
        
        $criteria = new CDbCriteria;
        $criteria->with = array('product', 'order');
        $criteria->select = 'SUM(t.price - t.price * t.comission_rate) AS totalAmount';
        $criteria->condition = 'order.status IN ("'.Order::O_STATUS_COMPLETE.'","'.Order::O_STATUS_UNCOMPLETED.'","'.Order::O_STATUS_PROCESSED.'") AND product.user_id = :userId';
        if (!empty($condition)) {
            $criteria->addCondition($condition);
        }
        $criteria->params = array(':userId' => $userId);
        $order = $this->find($criteria);
        return !empty($order->totalAmount) ? $order->totalAmount : 0;
    }
    
    public function getShippingRate($orderId)
    {
        $order = Order::model()->findByPk($orderId);
        $sRate = ShippingRate::model()->find('buyer_country_id = :country', array(':country' => $order->user->country_id));
        return $sRate ? number_format($sRate->rate,2) : number_format(Yii::app()->params->shipping['default_rate'],2);
    }
    
    public function afterSave()
    {
        //$tmpl = Template::model()->find("alias = 'goods shipped' AND language = :lang", array(':lang' => $this->product->user->language));
        /* :: DEBUG :: */
        //die('<pre>' . print_r($tmpl, true) . '</pre>');
        /* :: DEBUG :: */
        //$mail = new Mail;
        //$mail->send($this->product->user->email, $tmpl->subject, $tmpl->content);
        //mail('', 'test', 'text', 'From: ');
    }

    public function ipn($orderItem)
	{
        $order_item_id = $orderItem->id;
        
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
		     $myPost[$keyval[0]] = urldecode($keyval[1]);
		}

		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
		   $get_magic_quotes_exists = true;
		} 
		foreach ($myPost as $key => $value) {        
		   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
		        $value = urlencode(stripslashes($value)); 
		   } else {
		        $value = urlencode($value);
		   }
		   $req .= "&$key=$value";
		}
		
		$ch = curl_init(Yii::app()->params['payment']['paypal_webscr_url']);

		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:40.0) Gecko/20100101 Firefox/40.0'));

		if( !($res = curl_exec($ch)) ) {
		    curl_close($ch);
		    exit;
		}
		curl_close($ch);

        if (strcmp ($res, "VERIFIED") == 0) {
			if (!TransactionSeller::txnExist($_POST['txn_id'])
			    && $_POST['payment_status'] == "Completed") {
			 	
			    $transaction_seller = new TransactionSeller();
				$transaction_seller->txn_id = $_POST['txn_id'];
				$transaction_seller->order_item_id = $order_item_id;
				$transaction_seller->total = $_POST['mc_gross'];
				$transaction_seller->status = 1;
			    $transaction_seller->save();

                $orderItem->order->isCompleted();
			 } 
		} else if (strcmp ($res, "INVALID") == 0) {

		}		
	}

	public function addOrderItem($order_id, $product, $shipping_cost = 0) {
		$this->order_id = $order_id;
		$this->product_id = $product->id;
		$this->status = 'awaiting';
        $this->shipping_cost = $shipping_cost;
		$this->price = $product->getPrice() + $shipping_cost;
		$this->comission_rate = $product->user->sellerProfile->comission_rate;
		$this->save();
	}

	public function checkItem($id)
	{
		$orderItem = OrderItem::model()->findByPk($id);

		if($orderItem->order->status == Order::O_STATUS_UNCOMPLETED && !$this->checkTxnOrderItem($id)) {
            $payment = Transaction::model()->find('order_id='.$orderItem->order_id.' AND status=1');
            if ($payment != null) {
    			$date1 = new DateTime($payment->date);
    			$date2 = new DateTime(date('Y-m-d'));
    			$interval = $date1->diff($date2);
    			if($interval->format('%a') >= 3) {
    				return 'red';
    			} else {
    				return 'blue';
    			}
            } else {
                return 'red';
            }
			return true;
		} else {
			return false;
		}
	}

	public function checkTxnOrderItem($id)
	{
		$model = TransactionSeller::model()->find('order_item_id ='.$id);
		if($model == null) {
			return false;
		} else {
			return true;
		}
	}

    public function checkSuccessTxnOrderItem($id)
    {
        $model = TransactionSeller::model()->find('order_item_id ='.$id.' AND status=1');
        if($model == null) {
            return false;
        } else {
            return true;
        }
    }

    public function payVendor($orderItem, $amount)
    {
        $validator = new CEmailValidator;
        $senderId = uniqid();

        try {
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    Yii::app()->params['paypal']['ClientID'],     // ClientID
                    Yii::app()->params['paypal']['ClientSecret']      // ClientSecret
                )
            );
            
            if (!PAYPAL_SANDBOX) {
                $apiContext->setConfig(
                      array(
                        'mode' => 'live',                        
                      )
                );  
            }
        } catch (Exception $e) {
            throw new Exception(Yii::t('base', 'We have some error with paypal api'));
        }

        if ($orderItem) {
            $order_item_id = $orderItem->id;
            $sellerProfile = $orderItem->product->user->sellerProfile;
            if (!$sellerProfile) {
                throw new Exception(Yii::t('base', 'Seller profile is empty'));
            }

            $paypalEmail = $sellerProfile->paypal_email;
            if (empty($paypalEmail) || !$validator->validateValue($paypalEmail)) {
                throw new Exception(Yii::t('base', 'Wrong paypal email'));
            }

            if ($orderItem->status != OrderItem::OI_STATUS_PAID) {
                throw new Exception(Yii::t('base', 'Order item status not equal to paid'));
            }

            if ($orderItem->shipping_status != 'complete') {
                throw new Exception(Yii::t('base', 'Shipping status doesn\'t complete'));
            }

            if (OrderItem::model()->checkSuccessTxnOrderItem($order_item_id)) {
                throw new Exception(Yii::t('base', 'This order item just already paid'));
            }

            if (!is_numeric($amount)) {
                $amount = ($orderItem->price + $orderItem->shipping) * (1 - $orderItem->comission_rate);
            } else {
                $amount = floatval($amount);
            }

            if ($amount <= 0) {
                throw new Exception(Yii::t('base', 'Amount must be greater then zero'));
            }

            $payouts = new \PayPal\Api\Payout();

            $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
            $senderBatchHeader->setSenderBatchId($senderId)->setEmailSubject("You have a Payout!");

            $senderItem = new \PayPal\Api\PayoutItem(); 

            $currency = Yii::app()->params['payment']['currency'];
            if (PAYPAL_SANDBOX) {
                $currency = 'USD';  //testing
            }
            $senderItem->setRecipientType('Email')->setNote('Thanks for your patronage!') 
                ->setReceiver($paypalEmail) 
                ->setSenderItemId($order_item_id)
                ->setAmount(new \PayPal\Api\Currency('{
                    "value":"' . $amount . '",
                    "currency":"' . $currency . '"
                }')
            ); 
            $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

            $request = clone $payouts;
            try { 
                $output = $payouts->createSynchronous($apiContext); 
            } catch (Exception $ex) {
                throw new Exception(Yii::t('base', $ex->getMessage()));
            }
            if (isset($output->batch_header->batch_status)) {
                if ($output->batch_header->batch_status == 'SUCCESS') {
                    $transactionSeller = TransactionSeller::model()->find('order_item_id = ' . intval($order_item_id));
                    if (!$transactionSeller) {
                        $transactionSeller = new TransactionSeller();
                        $transactionSeller->order_item_id = $order_item_id;
                        $transactionSeller->total = $amount;
                    }
                    $transactionSeller->status = 1;
                    $transactionSeller->txn_id = $order_item_id;
                    $transactionSeller->save();

                    $orderItem->order->isCompleted();

                    return true;
                } else {
                    $errorMessages = array('Payout failed');
                    if (isset($output->items)) {
                        foreach ($output->items as $outputItem) {
                            if (isset($outputItem->errors)) {
                                $errorMessages[] = $outputItem->errors->message;
                            }
                        }
                    }
                    throw new Exception(Yii::t('base', implode('<br />', $errorMessages)));
                }
            } else {
                throw new Exception(Yii::t('base', 'Unknown error'));
            }
        }

        throw new Exception(Yii::t('base', 'Unknown error'));
    }

    public function getShipping()
    {
        return ShippingRate::model()->getItemShippingRate($this);
    }

    public function getComission()
    {
        return number_format($this->subtotal * $this->comission_rate, 2);
    }

    public function getSubtotal()
    {
        return number_format($this->price - $this->shipping_cost, 2);
    }

    public function getTotal()
    {
        $total = round($this->price - $this->comission, 2);
        return $total;
    }

    public function getTotalWithPaypalComission()
    {
        $total = $this->total;
        $totalWithComission = ($total + self::USD_PAY)/(1 - self::USD_FEE_PERCENT);
        return round($totalWithComission, 2);
    }

    public function getItemPrice()
    {
        return $this->subtotal;
    }

    public function getPaypalComission()
    {
        return $this->totalWithPaypalComission - $this->total;
    }
}