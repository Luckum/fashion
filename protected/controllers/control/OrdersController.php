<?php

class OrdersController extends AdminController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $orderItemModel = OrderItem::model()->find("order_id = :orderId", array(':orderId' => $id));
        $orderItemModel->unsetAttributes();
        if(isset($_GET['OrderItem']))
            $orderItemModel->attributes=$_GET['OrderItem'];
        $this->render('view',array(
			'model'=>$this->loadModel($id),
            'orderId' => $id,
            'itemModel' => $orderItemModel,
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Order('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Order']))
            $model->attributes=$_GET['Order'];

        HttpHelper::saveGetParameters();

        $this->render('index',array(
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionChangeStatus($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Order'])) {
            $model->status = $_POST['Order']['status'];
            if ($model->save()) {
                if ($model -> status == Order :: O_STATUS_PROCESSED) {
                    OrderItem :: model()
                        -> findByAttributes(array('order_id' => $model -> id))
                        -> updateAll(array('shipping_status' => OrderItem :: OI_SHIP_STATUS_PROCESSED));
                }
                $this->redirect(array('index'));
            }
        }
        $this->renderPartial('_changeStatus', array(
            'model' => $model,
        ));
    }

    /**
     * Изменяет статус продукта заказа.
     * @param integer $id ID продукта заказа.
     */
    public function actionChangeOrderItemStatus($id)
    {
        // Продукт заказа с ID = $id.
        $model = OrderItem :: model() -> findByPk($id);

        if (isset($_POST[get_class($model)])) {

            // Меняем статус продуката заказа на указанный.
            $model -> status = $_POST[get_class($model)]['status'];

            if ($model -> status == OrderItem :: OI_STATUS_COUPONED) {
                $model -> shipping_status = OrderItem :: OI_SHIP_STATUS_STARTED;
            } elseif ($model -> status == OrderItem :: OI_STATUS_SHIPPED) {
                $model -> shipping_status = OrderItem :: OI_SHIP_STATUS_PROCESSED;
            }

            // Сохраняем изменения в базу.
            if ($model -> save()) {

                if ($model -> shipping_status == OrderItem :: OI_SHIP_STATUS_PROCESSED &&
                    !count(OrderItem :: model() -> findAllByAttributes(
                        array('order_id'  => $model -> order_id),
                        array('condition' => "shipping_status != '" . OrderItem :: OI_SHIP_STATUS_PROCESSED . "'")
                    ))) {
                        // Если все продукты заказа имеют статус shipping_status = 'processed',
                        //то статус заказа меняется на 'processed'.
                        $order = Order :: model() -> findByPk($model -> order_id);
                        $order -> status = Order :: O_STATUS_PROCESSED;
                        $order -> save();
                } elseif ($model -> shipping_status == OrderItem :: OI_SHIP_STATUS_RECEIVED &&
                    !count(OrderItem :: model() -> findAllByAttributes(
                        array('order_id'  => $model -> order_id),
                        array('condition' => "shipping_status != '" . OrderItem :: OI_SHIP_STATUS_RECEIVED . "'")
                    ))) {
                    // Если все продукты заказа имеют статус shipping_status = 'received',
                    //то статус заказа меняется на 'uncompleted'.
                    $order = Order :: model() -> findByPk($model -> order_id);
                    $order -> status = Order :: O_STATUS_UNCOMPLETED;
                    $order -> save();
                }

                $this->redirect(array(
                    'control/orders/view',
                    'id' => $model -> order_id
                ));
            } else {
                print_r($model->getErrors());
                die();
            }
        }
        $this->renderPartial('_changeStatus', array(
            'model' => $model,
        ));
    }
    /**
     * Изменяет статус доставки заказа.
     * @param integer $id ID продукта заказа.
     */

    public function actionChangeOrderDeliveryItemStatus($id)
    {
        // Продукт заказа с ID = $id.
        $model = OrderItem :: model() -> findByPk($id);

        if (isset($_POST[get_class($model)])) {
            // Меняем статус доставки продукта на указанный.
            $model -> shipping_status = $_POST[get_class($model)]['shipping_status'];
            // Сохраняем изменения в базу.
            if ($model -> save()) {
                if ($model->shipping_status == OrderItem::OI_SHIP_STATUS_LABEL_SENT) {
                    $order = Order::model()->findByPk($model->order_id);
                    $order->status = Order::O_STATUS_PROCESSED;
                    $order->save();
                } elseif ($model -> shipping_status == OrderItem :: OI_SHIP_STATUS_SHIPPED) {
                    $order = Order :: model() -> findByPk($model -> order_id);
                    $order -> status = Order :: O_STATUS_PROCESSED;
                    $order -> save();
                } elseif ($model -> shipping_status == OrderItem :: OI_SHIP_STATUS_RECEIVED) {
                    $order = Order :: model() -> findByPk($model -> order_id);
                    $order -> status = Order :: O_STATUS_UNCOMPLETED;
                    $order -> save();
                } elseif ($model->shipping_status == OrderItem::OI_SHIP_STATUS_RETURNED) {
                    $order = Order::model()->findByPk($model->order_id);
                    $order->status = Order::O_STATUS_RETURNED;
                    $order->save();
                } elseif ($model->shipping_status == OrderItem::OI_SHIP_STATUS_COMPLETE) {
                    $order = Order::model()->findByPk($model->order_id);
                    $order->status = Order::O_STATUS_COMPLETE;
                    $order->save();
                }

                $this->redirect(array(
                    'control/orders/view',
                    'id' => $model -> order_id
                ));
            }
        }
        $this->renderPartial('_changeDeliveryStatus', array(
            'model' => $model,
        ));
    }

    public function actionGetCsv($id)
    {

        Yii::import('ext.ECSVExport');
        $data = array();
        
        $orderItem = OrderItem::model()->findByPk($id);
        if ($orderItem) {
            $filename = 'order_' . $orderItem->order->id . '_item_' . $orderItem->id . '_' . date('m-d-Y_h-i-s') . '.csv';
            $sender = $orderItem->product->user;
            $receiver = $orderItem->order->user;

            $senderShippingAddress = ShippingAddress::model()->getLastUsedShippingAddress($sender->id);
            $receiverShippingAddress = ShippingAddress::model()->getLastUsedShippingAddress($receiver->id);

            $receiverAddress = $receiverShippingAddress->address;
            if (!empty($receiverShippingAddress->address_2)) {
                $receiverAddress .= ', ' . $receiverShippingAddress->address_2;
            }
            $senderAddress = $senderShippingAddress->address;
            if (!empty($senderShippingAddress->address_2)) {
                $senderAddress .= ', ' . $senderShippingAddress->address_2;
            }

            $data[] = array(
                'Sender address' =>  $senderAddress,
                'Sender tel' => $senderShippingAddress->phone,
                'Receiver address' =>  $receiverAddress,
                'Receiver tel' => $receiverShippingAddress->phone,
                'Size' => (empty($orderItem->product->size_chart) ? Yii::t('base', 'No size') : $orderItem->product->size_chart->size)
            );
        } else {
            $this->redirect(array('control/orders'));
        }

        $csv = new ECSVExport($data);
        $output = $csv->setDelimiter(';')->toCSV();
        Yii::app()->getRequest()->sendFile($filename, $output, "text/csv", false);
        exit();
    }

    public function actionGetOrderCsv($id)
    {
        Yii::import('ext.ECSVExport');
        $data = array();
        
        $order = Order::model()->findByPk($id);
        if ($order) {
            $filename = 'order_' . $order->id . '_' . date('m-d-Y_h-i-s') . '.csv';
            foreach ($order->orderItems as $orderItem) {
                $sender = $orderItem->product->user;
                $receiver = $orderItem->order->user;

                $senderShippingAddress = ShippingAddress::model()->getLastUsedShippingAddress($sender->id);
                $receiverShippingAddress = ShippingAddress::model()->getLastUsedShippingAddress($receiver->id);

                $receiverAddress = $receiverShippingAddress->address;
                if (!empty($receiverShippingAddress->address_2)) {
                    $receiverAddress .= ', ' . $receiverShippingAddress->address_2;
                }
                $senderAddress = $senderShippingAddress->address;
                if (!empty($senderShippingAddress->address_2)) {
                    $senderAddress .= ', ' . $senderShippingAddress->address_2;
                }

                $data[] = array(
                    'Order Item ID' => $orderItem->product->id,
                    'Sender address' => $senderAddress,
                    'Sender tel' => $senderShippingAddress->phone,
                    'Receiver address' => $receiverAddress,
                    'Receiver tel' => $receiverShippingAddress->phone,
                    'Size' => (empty($orderItem->product->size_chart) ? Yii::t('base', 'No size') : $orderItem->product->size_chart->size)
                );
            }
        } else {
            $this->redirect(array('control/orders/view', 'id' => $id));
        }        

        $csv = new ECSVExport($data);
        $output = $csv->setDelimiter(';')->toCSV();
        Yii::app()->getRequest()->sendFile($filename, $output, "text/csv", false);
        exit();
    }
    
    public function actionStartShipping($id)
    {
        $model = OrderItem::model()->findByPk($id);
        if(isset($_POST['OrderItem'])) {
            $model->attributes = $_POST['OrderItem'];
            $model->document=CUploadedFile::getInstance($model,'document');
            $path=Yii::getPathOfAlias('webroot.documents.upload').DIRECTORY_SEPARATOR.$model->document;
            $model->document->saveAs($path);
        }
        if (isset($_POST['seller_email']) && !empty($_POST['seller_email'])) {
            $model->shipping_status = OrderItem::OI_SHIP_STATUS_LABEL_SENT;
            $order = Order::model()->findByPk($model->order_id);
            $order->status = Order::O_STATUS_PROCESSED;
            $order->save();
            if ($model->save()) {

                try {
                    $template = Template:: model()->find("alias = 'seller_shipping_info' AND language = :lang",
                        array(':lang' => Yii::app()->getLanguage()));

                    if (count($template)) {
                        $mail = new Mail;
                        $parameters = EmailHelper::setValues($template->content, array(
                            $model, $model->product, $model->product->user
                        ));
                        $message = Yii::t('base', $template->content, $parameters);
                        $mail->send(
                            $_POST['seller_email'],
                            $template->subject,
                            $message,
                            $template->priority,
                            Yii::getPathOfAlias('webroot.documents.upload').DIRECTORY_SEPARATOR.$model->document->name
                        );
                    }
                }catch(Exception $e){

                }

                $this->redirect(array('view', 'id' => $model->order_id));
            }
        }
        $this->renderPartial('_startShipping', array(
            'model' => $model
        ));
    }

    public function actionGiveData($id)
    {
        $model = OrderItem::model()->findByPk($id);
        if(isset($_POST['OrderItem'])) {
            $model->attributes = $_POST['OrderItem'];
        }
        if (isset($_POST['buyer_email']) && !empty($_POST['buyer_email'])) {
            if(!empty($_POST['tracking_number'])) {
                $model->tracking_number = $_POST['tracking_number'];
                $model->tracking_link = $_POST['link'];
                $model->save();
                $alias = 'shipping_confirmation';
            } else {
                $alias = 'shipping_confirmation_without_tracking';
            }
                try {
                    $template = Template:: model()->find("alias = '".$alias."' AND language = :lang",
                        array(':lang' => Yii::app()->getLanguage()));

                    if (count($template)) {
                        $mail = new Mail;
                        $parameters = EmailHelper::setValues($template->content, array(
                            $model, $model->product, $model->order, $model->order->user
                        ));
                        $message = Yii::t('base', $template->content, $parameters);
                        $mail->send(
                            $_POST['buyer_email'],
                            $template->subject,
                            $message,
                            $template->priority
                        );
                    }
                }catch(Exception $e){

                }

                $this->redirect(array('view', 'id' => $model->order_id));
        }
        $this->renderPartial('_giveDataToBuyer', array(
            'model' => $model
        ));
    }

    public function actionGivePayment($id)
    {
        $orderItem = OrderItem::model()->findByPk($id);

        $this->renderPartial('_givePayment', array(
            'model' => $orderItem,
        ));
    }

    public function actionPayVendor()
    {
        $order_item_id = Yii::app()->request->getPost('order_item_id');
        $amount = Yii::app()->request->getPost('amount');

        $orderItem = OrderItem::model()->findByPk($order_item_id);
        if (!$orderItem) {
            throw new CHttpException('Order item not found');
        }
        $order_id = $orderItem->order->id;

        if (!$amount || !is_numeric($amount)) {
            Yii::app()->user->setFlash('pay_error', Yii::t('base', 'Wrong data'));
            $this->redirect(array('view', 'id' => $order_id));
        }

        try {
            OrderItem::payVendor($orderItem, $amount);
        } catch (Exception $e) {
            Yii::app()->user->setFlash('pay_error', $e->getMessage());
            $this->redirect(array('view', 'id' => $order_id));
        }
        Yii::app()->user->setFlash('pay_success', Yii::t('base', 'You payout was successfully sended'));
        $this->redirect(array('view', 'id' => $order_id));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
}