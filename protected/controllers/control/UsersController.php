<?php

class UsersController extends AdminController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $sellerModel = SellerProfile::model()->find("user_id = :userId", array(':userId' => $id));
        $this->render('view',array(
			'model'=>$this->loadModel($id),
            'sellerModel' => $sellerModel,
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
        $sellerModel = new SellerProfile;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			$saved = false;
            if ($model->save()) {
                $saved = true;
                if ($_POST['User']['type'] == User::SELLER) {
                    $sellerModel->attributes = $_POST['SellerProfile'];
                    $sellerModel->user_id = $model->id;
                    if (trim($_POST['SellerProfile']['comission_rate']) == "") {
                        $sellerModel->comission_rate = Yii::app()->params['payment']['default_comission_rate'];
                    } else {
                        $sellerModel->comission_rate = $_POST['SellerProfile']['comission_rate'] / 100;
                    }
                    
                    if (!$sellerModel->save()) {
                        $saved = false;
                        $model->deleteAll("id = :id", array(':id' => $model->id));
                    }
                }
            }
            if ($saved) {
                $this->redirect(array('view', 'id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'sellerModel' => $sellerModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $backParameters = HttpHelper::retrievePreviousGetParameters();

		$model = $this->loadModel($id);
        if ($model->sellerProfile === null) {
            $sellerModel = new SellerProfile;
        } else {
            $sellerModel = $model->sellerProfile;
        }
        

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['User'])) {
            if (isset($_POST['User']['password']) && empty($_POST['User']['password'])) {
                unset($_POST['User']['password']);
            }
			$model->attributes = $_POST['User'];
            $model->scenario = 'adminUpdateUser';
            if ($model->save()) {
                if ($_POST['User']['type'] == User::SELLER) {
                    if (isset($_POST['SellerProfile']['paypal_email'])) {
                        $sellerModel->paypal_email = $_POST['SellerProfile']['paypal_email'];
                    }

                    if (trim($_POST['SellerProfile']['comission_rate']) == "") {
                        $comission = Yii::app()->params['payment']['default_comission_rate'];
                    } else {
                        $comission = $_POST['SellerProfile']['comission_rate'] / 100;
                    }

                    if (!isset($sellerModel->id)) {
                        $sellerModel->attributes = $_POST['SellerProfile'];
                        $sellerModel->user_id = $model->id;
                        $sellerModel->comission_rate = $comission;
                        $sellerModel->save();
                    } else {
                        $sellerModel->attributes = $_POST['SellerProfile'];
                        $sellerModel->user_id = $model->id;
                        $sellerModel->comission_rate = $comission;
                        $sellerModel->save();
                    }
                } else {
                    SellerProfile::model()->deleteAll("user_id = :userId", array(':userId' => $id));
                }
                $this->redirect(array('view', 'id'=>$model->id));
            }
				
		}

        $model->password = '';
		$this->render('update',array(
			'model'=>$model,
            'sellerModel' => $sellerModel,
            'backParameters' => $backParameters
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $sellerModel = new SellerProfile('search');
        $sellerModel->unsetAttributes();
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
            if (!empty($_GET['User']['status']) && strpos('active', strtolower($_GET['User']['status'])) !== 'false') {
                $model->status = User::ACTIVE;
            } elseif (!empty($_GET['User']['status']) && strpos('blocked', strtolower($_GET['User']['status'])) !== 'false') {
                $model->status = User::BLOCKED;
            }
        }

        HttpHelper::saveGetParameters();
        
		$this->render('index', array(
			'model' => $model,
            'sellerModel' => $sellerModel,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionChangeStatus($id, $status)
    {
        User::model()->updateAll(array("status" => $status), "id = :id", array(':id' => $id));
        $this->redirect(array('view', 'id'=>$id));
    }
    
    public function actionAjaxGetDataByDate()
    {
        $filter = $_POST['filter'];
        $userId = $_POST['userId'];
        $userType = $_POST['userType'];
        $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        
        if ($userType == User::SELLER) {
            $total = OrderItem::model()->getTotalByUser($userId, $filter, $startDate, $endDate);
        } else {
            $total = Order::model()->getTotalByUser($userId, $filter, $startDate, $endDate);
        }
        
        $this->renderPartial('_datedata', array(
            'userType' => $userType,
            'total' => $total
        ));
    }

    public function actionMore($id) {
        $model = $this->loadModel($id);
        $shippingDetails = new CActiveDataProvider('ShippingAddress', array(
            'criteria' => array(
                'condition' => "user_id =".$id
            )
        ));
        $userAlerts = new CActiveDataProvider('Alerts', array(
            'criteria' => array(
                'condition' => "user_id =".$id
            )
        ));
        $userWishList = new CActiveDataProvider('Wishlist', array(
            'criteria' => array(
                'condition' => "user_id =".$id
            )
        ));
        $userBillings = new CActiveDataProvider('SellerProfile', array(
            'criteria' => array(
                'condition' => "user_id =".$id
            )
        ));
        $this->render('usermore', array(
            'shippingData' => $shippingDetails,
            'alertsData' => $userAlerts,
            'wishData' => $userWishList,
            'billingData' => $userBillings,
            'model' => $model
        ));
    }
}
