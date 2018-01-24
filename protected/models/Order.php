<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $user_id
 * @property string $added_date
 * @property string $total
 * @property integer $shipping_address_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ShippingAddress $shippingAddress
 * @property OrderItem[] $orderItems
 * @property Transaction[] $transactions
 */
class Order extends CActiveRecord
{
    public $from_date;
    public $to_date;
    public $totalAmount;
    public $count_ord;

    /**
     * Статусы заказа.
     */
    const O_STATUS_NEW         = 'new';
    const O_STATUS_OPEN        = 'open';
    const O_STATUS_FAILED      = 'failed';
    const O_STATUS_COMPLETE    = 'complete';
    const O_STATUS_CANCELED    = 'canceled';
    const O_STATUS_PROCESSED   = 'processed';
    const O_STATUS_UNCOMPLETED = 'uncompleted';
    const O_STATUS_RETURNED    = 'returned';
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, added_date, total, shipping_address_id', 'required', 'message' => '*required'),
            array('user_id, shipping_address_id', 'numerical', 'integerOnly' => true),
            array('total', 'length', 'max' => 9),
            array('status', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, added_date, total, shipping_address_id, status', 'safe', 'on' => 'search'),
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
            'shippingAddress' => array(self::BELONGS_TO, 'ShippingAddress', 'shipping_address_id'),
            'orderItems' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'transactions' => array(self::HAS_MANY, 'Transaction', 'order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'user_id' => Yii::t('base', 'User'),
            'added_date' => Yii::t('base', 'Added Date'),
            'total' => Yii::t('base', 'Total, EUR'),
            'shipping_address_id' => Yii::t('base', 'Shipping Address'),
            'status' => Yii::t('base', 'Status'),
            'shipping_cost' => Yii::t('base', 'Shipping cost'),
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

        $criteria = new CDbCriteria;

        $criteria->with = array('user');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('user.username', $this->user_id);
        $criteria->compare('t.added_date', $this->added_date, true);
        $criteria->compare('t.total', $this->total, true);
        $criteria->compare('t.status', $this->status);
        $criteria->order = 't.added_date DESC';
        $status = Yii::app()->request->getQuery('status', 0);
        if ($status !== 0) {
            switch ($status) {
                case 'new':
                    $clause = "t.added_date > NOW() - INTERVAL 24 HOUR";
                    break;
                default:
                    $clause = "t.status = :status";
                    $criteria->params = array(':status' => $status);
                    break;
            }
            $criteria->addCondition($clause);
        }

        if (isset($this->to_date, $this->from_date)) {
            $criteria->condition = "t.added_date BETWEEN '{$this->from_date}' AND '{$this->to_date}'";
        }

        $userId = Yii::app()->request->getQuery('userid', 0);
        if ($userId !== 0) {
            $criteria->addCondition("t.user_id = " . intval($userId));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getTotalByUser($userId, $filter = 0, $startDate = '', $endDate = '')
    {
        switch ($filter) {
            case 1:
                $condition = "added_date LIKE '" . date('Y-m-d') . "%'";
                break;
            case 2:
                $condition = "added_date BETWEEN '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 8, date("Y"))) . "' AND '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))) . "'";
                break;
            case 3:
                $condition = "added_date BETWEEN '" . date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d") - 1, date("Y"))) . "' AND '" . date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))) . "'";
                break;
            case 4:
                $condition = "added_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
                break;
            default:
                $condition = '';
        }

        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(total) AS totalAmount';
        $criteria->condition = 'status IN ("'.Order::O_STATUS_COMPLETE.'","'.Order::O_STATUS_UNCOMPLETED.'","'.Order::O_STATUS_PROCESSED.'") AND user_id = :userId';
        if (!empty($condition)) {
            $criteria->addCondition($condition);
        }
        $criteria->params = array(':userId' => $userId);
        $order = $this->find($criteria);
        return !empty($order->totalAmount) ? $order->totalAmount : 0;
    }

    public function getLastOrderDateByUser()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_id = :userId';
        $criteria->params = array(':userId' => $this->user_id);
        $criteria->order = 'added_date DESC';
        $criteria->limit = '1';
        $order = $this->find($criteria);

        return $order;
    }

    public function getStatus()
    {
        return array(
            self::O_STATUS_NEW => Yii::t('base', 'New'),
            'open' => Yii::t('base', 'Open'),
            self::O_STATUS_PROCESSED => Yii::t('base', 'Processed'),
            self::O_STATUS_UNCOMPLETED => Yii::t('base', 'Uncompleted'),
            self::O_STATUS_COMPLETE => Yii::t('base', 'Complete'),
            self::O_STATUS_FAILED => Yii::t('base', 'Failed'),
            'returned' => Yii::t('base', 'Returned'),
            'canceled' => Yii::t('base', 'Canceled'),
        );
    }

    public function getFilterStatus()
    {
        return array(
            self::O_STATUS_NEW => Yii::t('base', 'New'),
            'open' => Yii::t('base', 'Open'),
            self::O_STATUS_PROCESSED => Yii::t('base', 'Processed'),
            self::O_STATUS_UNCOMPLETED => Yii::t('base', 'Uncompleted'),
            self::O_STATUS_COMPLETE => Yii::t('base', 'Complete'),
            self::O_STATUS_FAILED => Yii::t('base', 'Failed'),
            'returned' => Yii::t('base', 'Returned'),
            'canceled' => Yii::t('base', 'Canceled'),
        );
    }

    public function getOrdersFromChart()
    {
        $from = new DateTime(date('Y-m-d', strtotime($this->from_date)));
        $to = new DateTime(date('Y-m-d', strtotime($this->to_date)));
        $to = $to->modify('+1 day');
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function ($item) {
                return $item->format('Y-m-d H:i:s');
            },
            iterator_to_array($period)
        );

        $result = array();
        $ordersStatus = $this->getStatus();

        $dataProvider = $this->search();
        $dataProvider->pagination = false;

        foreach ($ordersStatus as $status => $name) {
            $result['orders'][$status]['count'] = 0;
            $result['totalCount'] = 0;
            $result['orders'][$status]['name'] = $name;
        }
        foreach ($arrayOfDates as $key => $value) {
            $value = date('Y-m-d', strtotime($value));
            $result['labels'][$key] = $value;

            foreach ($ordersStatus as $status => $name) {
                $result['data'][$status][$key] = 0;
            }

            foreach ($dataProvider->getData() as $order) {
                $add_date = date('Y-m-d', strtotime($order->added_date));

                if ($add_date == $value) {
                    $result['data'][$order->status][$key]++;
                    $result['orders'][$order->status]['count']++;
                    $result['totalCount']++;
                }
            }
        }

        return $result;
    }

    /**
     * Список проданных товаров текущего пользователя.
     */
    public static function getSoldOrders()
    {
        // ID пользователя.
        $uid = Yii::app()->member->id;

        $sql = "SELECT `order_id`
                FROM   `order_item`
                WHERE  `product_id` IN (SELECT `id` FROM `product` WHERE `user_id` = {$uid})";
        $oids = [];
        foreach (Yii::app()->db->createCommand($sql)->queryAll() as $i) {
            $oids[] = $i['order_id'];
        }

        $criteria = new CDbCriteria;
        $criteria->params = array(':status' => self::O_STATUS_COMPLETE);
        $criteria->condition = 'status = :status';
        $criteria->addInCondition('id', $oids);
        $criteria->order = 'added_date DESC';

        $orders = self::model()->findAll($criteria);

        $sold_item = array(0 => 0);
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $sold_item[0] += $item->price * (1 - $item->comission_rate);
                $sold_item[] = $item;
            }
        }

        return $sold_item;
    }

    public static function paymentSuccess()
    {
        return true;
    }

    public function pay($storedProductIds = array()) {
        $req = json_encode(array(
            "actionType" => "CREATE",
            "currencyCode" => Yii::app()->params['payment']['currency'],
            "receiverList" => array(
                "receiver" => array(
                    "amount" => $this->total,
                    "email" => Yii::app()->params['paypal']['email']
                )
            ),
            "returnUrl" => Yii::app()->createAbsoluteUrl('members/shop/pay?paypal_return=1&order_id=' . $this->id),
            "cancelUrl" => Yii::app()->createAbsoluteUrl('members/shop/pay?paypal_cancel=1'),
            "requestEnvelope" => array(
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            ),
            "ipnNotificationUrl" => Yii::app()->createAbsoluteUrl('members/shop/ipn?id='.$this->id)
        ));

        $url = Yii::app()->params['payment']['paypal_svcs_url'];
        if (!($res = $this->sendPaypalRequest($url, $req))) {
            return '';
        }

        if ($res->responseEnvelope->ack === 'Success') {
            $payKey = $res->payKey;

            $items = array();
            foreach ($this->orderItems as $orderItem) {
                $items[] = array(
                    "name" => $orderItem->product->title,
                    "price" => $orderItem->price,
                    "itemPrice" => $orderItem->price,
                    "itemCount" => 1
                );
            }

            $req = json_encode(array(
                "payKey" => $payKey,
                "displayOptions" => array(
                    "businessName" => "23-15.com"
                ),
                "receiverOptions" => array(
                    "description" => Yii::t('base', 'Payment on www.23-15.com'),
                    "invoiceData" => array(
                        "item" => $items
                    ),
                    "receiver" => array(
                        "email" => Yii::app()->params['paypal']['email']
                    )
                ),
                // "senderOptions" => array(
                //     "shippingAddress" => array(
                //         "addresseeName" => "John",
                //         "city" => "San Jose",
                //         "state" => "CA",
                //         "street1" => "17 Magneson St",
                //         "street2" => "building 1",
                //         "zip" => "12345"
                //     )
                // ),
                "requestEnvelope" => array(
                    "errorLanguage" => "en_US",
                    "detailLevel" => "ReturnAll"
                ),
            ));

            $url = 'https://svcs.paypal.com/AdaptivePayments/SetPaymentOptions';
            if (PAYPAL_SANDBOX) {
                $url = 'https://svcs.sandbox.paypal.com/AdaptivePayments/SetPaymentOptions';
            }
            if (!($res = $this->sendPaypalRequest($url, $req))) {
                return '';
            }

            if ($res->responseEnvelope->ack === 'Success') {
                foreach ($storedProductIds as $productId) {
                    Yii::app()->shoppingCart->remove($productId);
                }
                header('Location: ' . Yii::app()->params['payment']['paypal_ap-payment_url'] . $payKey);
                exit;
            } else {
                return $this->getPaypalError($res);
            }
        } else {
            return $this->getPaypalError($res);
        }
        return '';
    }

    protected function sendPaypalRequest($url, $req)
    {
        $headers = array(
            "Content-type: application/x-www-form-urlencoded",
            "Content-Length: " . strlen ($req),
            "Connection: Close",
            "X-PAYPAL-SECURITY-USERID: " . Yii::app()->params['paypal']['user_id'],
            "X-PAYPAL-SECURITY-SIGNATURE: " . Yii::app()->params['paypal']['signature'],
            "X-PAYPAL-SECURITY-PASSWORD: " . Yii::app()->params['paypal']['password'],
            "X-PAYPAL-APPLICATION-ID: " . Yii::app()->params['paypal']['app_id'],
            "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
            "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON"
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if( !($res = curl_exec($ch)) ) {
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        $res = json_decode($res);

        return $res;
    }

    protected function getPaypalError($res)
    {
        if (isset($res->error) && !empty($res->error)) {
            $msgs = array();
            foreach ($res->error as $error) {
                $msgs[] = $error->message;
            }

            return implode('. ', $msgs);
        } else {
            return '';
        }
    }

    public function ipn($order_id)
    {
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        $ch = curl_init(Yii::app()->params['payment']['paypal_webscr_url']);

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:40.0) Gecko/20100101 Firefox/40.0'));

        if (!($res = curl_exec($ch))) {
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        if (isset($_POST['reason_code']) && $_POST['reason_code'] == 'Refund') {
            exit;
        }

        if (strcmp($res, "VERIFIED") == 0) {
            if (!Transaction::txnExist($order_id)
                && $_POST['status'] == "COMPLETED" && !empty($order_id)
            ) {
                PaypalLog::log(array('result', $res, $order_id, $_POST));
                $transaction = new Transaction();
                $transaction->txn_id = $_POST['verify_sign'];
                $transaction->order_id = $order_id;
                $transaction->total = $this->total;
                $transaction->status = 1;
                $transaction->date = new CDbExpression('NOW()');
                $transaction->save();

                $this->status = self::O_STATUS_PROCESSED;
                $this->update();

                try {
                    $template = Template:: model()->find("alias = 'order_complete' AND language = :lang",
                        array(':lang' => Yii::app()->getLanguage()));

                    if (count($template)) {
                        $mail = new Mail;
                        $itemsString = '';
                        $baseUrl = Yii:: app()->request->getBaseUrl(true);
                        $medium_dir = $baseUrl . ShopConst::IMAGE_THUMBNAIL_DIR;
                        $itemsString.= '<table style="width:100%;"><tr><th style="padding-right:20px;width: 180px;">Item</th><th style="padding-right:20px;width: 400px;">Details</th><th style="padding-right:20px;width: 150px;">Price</th><th></th></tr>';
                        foreach($this->orderItems as $item)
                        {
                            $itemsString.="<tr><td style='padding-right:20px'><img src='".$medium_dir.$item->product->image1."'></td><td style='padding-right:20px'>".
                                $item->product->brand->name.' '.
                                $item->product->title.
                                " [#". $item->product->id."]</td><td style='padding-right:20px;text-align:center;'> &euro;".
                                $item->product->price."&nbsp;</td><td></td></tr>";
                        }
                        $itemsString.= '<tr><td colspan="4" style="padding-top: 40px;"><hr /></td></tr>';
                        $itemsString.= "<tr><td style='padding-right:20px;padding-top: 20px;'>Shipping from:</td><td style='padding-right:20px;padding-top: 20px;'>Shipping to:<br />{Order/shipping_to}</td><td style='padding-right:20px;padding-top: 20px;'>Shipping: &euro;{Order/shipping_cost}<br />Total: &nbsp;&nbsp;&nbsp;&euro;{Order/total}</td><td></td></tr>";
                        $itemsString.='</table>';
                        $parameters = EmailHelper::setValues($template->content . $itemsString, array(
                            $this, $this->user
                        ));
                        $message = Yii::t('base', $template->content, $parameters);
                        $itemsString = Yii::t('base', $itemsString, $parameters);
                        $message = str_replace('{items}',$itemsString,$message);
                        $mail->send(
                            $this->user->email,
                            $template->subject,
                            $message,
                            $template->priority
                        );
                    }
                } catch (Exception $e) {

                }

                $soldProducts = array();
                foreach ($this->orderItems as $item) {
                    $item->status = 'paid';
                    $item->update();

                    $soldProducts[] = $item->product_id;

                    try {
                        $template = Template:: model()->find("alias = 'sold_item' AND language = :lang",
                            array(':lang' => Yii::app()->getLanguage()));

                        if (count($template)) {
                            $mail = new Mail;
                            $parameters = EmailHelper::setValues($template->content, array(
                                $item, $item->product, $item->product->user
                            ));
                            $message = Yii::t('base', $template->content, $parameters);
                            $mail->send(
                                $item->product->user->email,
                                $template->subject,
                                $message,
                                $template->priority
                            );
                        }
                    } catch (Exception $e) {

                    }
                }

                Product::model()->soldProducts($soldProducts);

                $qb = new Quickbooks();
                $qbPayments = $qb->prepareData($order_id);
                $qb->createBill($qbPayments);
            }
            // in this place should be add payment in quickbooks
        } else if (strcmp($res, "INVALID") == 0) {
        }
    }

    public function txnExist($txnId)
    {
        return $this->exists('txn_id = :txn_id', array(':txn_id' => $txnId));
    }

    public function createOrder($total, $shipping_address_id, $paypal_id = '', $shipping_cost = 0)
    {
        $this->user_id = Yii::app()->member->id;
        $this->added_date = new CDbExpression('NOW()');
        $this->total = $total;
        $this->shipping_address_id = $shipping_address_id;
        $this->status = self::O_STATUS_OPEN;
        $this->paypal_id = $paypal_id;
        $this->shipping_cost = $shipping_cost;
        $this->save();
    }

    public function getComission()
    {
        $comission = 0;
        foreach ($this->orderItems as $orderItem) {
            $comission += $orderItem->comission;
        }
        return number_format($comission, 2);
    }

    public function getSubtotal()
    {
        $subtotal = $this->total - $this->shipping_cost;
        return number_format($subtotal, 2);
    }

    public function isCompleted()
    {
        $completeOrder = true;
        foreach ($this->orderItems as $orderItem) {
            if (!$orderItem->transaction || $orderItem->transaction->status != 1) {
                $completeOrder = false;
                break;
            }
        }
        if ($completeOrder) {
            $this->status = self::O_STATUS_COMPLETE;
            $this->save();
        }
    }
}