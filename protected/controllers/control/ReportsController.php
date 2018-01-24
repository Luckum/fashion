<?php

class ReportsController extends AdminController
{

	public function actionIndex()
	{
		$reports = new Report();
		$reports->unsetAttributes();

		// echo "<pre>";print_r($sales);echo "</pre>";die();
		$this->render('index',array(
			'reports'=>$reports,
		));
	}

	public function actionSale()
	{
		$reports = new Report();
		$reports->unsetAttributes();

		$this->render('sale',array(
			'reports'=>$reports,
		));
	}

	public function actionSaleGrid()
    {
    	$cs=Yii::app()->clientScript;
    	$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/chartJs/Chart.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/reportCharts.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/dateRange.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/script.js', CClientScript::POS_END);

        $reports = new Report();
		$reports->unsetAttributes();

		$lastYear = date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1,   date("Y")));
		$reports->from_date = $lastYear;
		$reports->to_date = date("Y-m-d H:i:s");

        if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    		$reports->from_date = $_POST['from_date'];
			$reports->to_date = $_POST['to_date'];
    	}

    	if (isset($_POST['category'])) {
    		$reports->category_id = $_POST['category'];
    	}

        $this->renderPartial('sale_grid',array(
            'reports'=>$reports,
        ));
    }

    public function actionUsers()
	{
		$reports = new Report();
		$reports->unsetAttributes();
		
		$this->render('users',array(
			'reports'=>$reports,
		));
	}

	public function actionUsersGrid()
    {
    	$cs=Yii::app()->clientScript;
    	$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/chartJs/Chart.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/reportCharts.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/dateRange.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/script.js', CClientScript::POS_END);

        $reports = new Report();
		$reports->unsetAttributes();

		$lastYear = date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1,   date("Y")));
		$reports->from_date = $lastYear;
		$reports->to_date = date("Y-m-d H:i:s");

        if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    		$reports->from_date = $_POST['from_date'];
			$reports->to_date = $_POST['to_date'];
    	}

    	if (isset($_POST['country'])) {
    		$reports->user_country = $_POST['country'];
    	}

        $this->renderPartial('users_grid',array(
            'reports'=>$reports,
        ));
    }

    public function actionOrders()
	{
		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js');

		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');

		$reports = new Report();
		$reports->unsetAttributes();

		$this->render('orders',array(
			'reports'=>$reports,
		));
	}

	public function actionOrdersGrid()
    {
    	$cs=Yii::app()->clientScript;
    	$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/chartJs/Chart.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/reportCharts.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/dateRange.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/script.js', CClientScript::POS_END);

        $reports = new Report();
		$reports->unsetAttributes();

		$lastYear = date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1,   date("Y")));
		$reports->from_date = $lastYear;
		$reports->to_date = date("Y-m-d H:i:s");

	    if(isset($_GET['Report'])) {
	    	foreach ($_GET['Report'] as $key => $value) {
	    		$reports->{$key} = $value;
	    	}
        }

        if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    		$reports->from_date = $_POST['from_date'];
			$reports->to_date = $_POST['to_date'];
    	}

        $this->renderPartial('orders_grid',array(
            'reports'=>$reports,
        ));
    }

    public function actionDelivery()
	{
		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js');

		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');

		$reports = new Report();
		$reports->unsetAttributes();

		$this->render('delivery',array(
			'reports'=>$reports,
		));
	}

	public function actionDeliveryGrid()
    {
    	$cs=Yii::app()->clientScript;
    	$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/js/bootstrap-daterangepicker/daterangepicker.css');
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/chartJs/Chart.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/reportCharts.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/dateRange.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/script.js', CClientScript::POS_END);

        $reports = new Report();
		$reports->unsetAttributes();

		$lastYear = date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1,   date("Y")));
		$reports->from_date = $lastYear;
		$reports->to_date = date("Y-m-d H:i:s");

	    if(isset($_GET['Report'])) {
	    	foreach ($_GET['Report'] as $key => $value) {
	    		$reports->{$key} = $value;
	    	}
        }

        if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    		$reports->from_date = $_POST['from_date'];
			$reports->to_date = $_POST['to_date'];
    	}

        $this->renderPartial('delivery_grid',array(
            'reports'=>$reports,
        ));
    }

    public function actionCreateExcel(){
		if(!empty($_POST)) {
			$criteria=new CDbCriteria;

	        $criteria->with = array('sellerProfile','orders');
	        $criteria->together = true;
	        $criteria->condition = '`sellerProfile`.`id` is null AND `t`.`status` = "active"';

	        if(!empty($_POST['country']))
	        {
	        	$country = $_POST['country'];
	            $criteria->addCondition("`t`.`country` = '$country'");
	        }

	        if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
	        {
	        	$from_date = $_POST['from_date'];
	        	$to_date = $_POST['to_date'];
	            $criteria->addCondition("`orders`.`added_date` >= '$from_date' and `orders`.`added_date` <= '$to_date'");
	        }
	        
			$model = User::model()->findAll($criteria);
		} else {
			$model = User::model()->findAll();
		}
		
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator(Yii::app()->name)
			->setLastModifiedBy(Yii::app()->name)
			->setTitle(Yii::app()->name." Reports")
			->setSubject(Yii::app()->name." Reports")
			->setDescription(Yii::app()->name." Reports")
			->setKeywords(Yii::app()->name." Reports")
			->setCategory("result file");

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "User ID")
			->setCellValue('B1', 'User Name')
			->setCellValue('C1', 'User Country')
			->setCellValue('D1', 'Total price')
			->setCellValue('E1', 'Last purchases date');
		
		foreach ($model as $key => $value) {
			$row = $key + 2;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $value->id)
				->setCellValue('B'.$row, $value->username)
				->setCellValue('C'.$row, $value->country)
				->setCellValue('D'.$row, $value->orders[0]->getTotalByUser($value->id))
				->setCellValue('E'.$row, $value->orders[0]->getLastOrderDateByUser()->added_date);
		}

		$objPHPExcel->getActiveSheet()->setTitle("Unisex resale store Reports");
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel .xlsx');
		header('Content-Disposition: attachment;filename="active_users_locations_reports.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
			  Yii::app()->end();
	}

	public function actionCreateSaleExcel(){
		$reports = new Report();
		$reports->unsetAttributes();

		if(!empty($_POST)) {
	        if(!empty($_POST['country']))
	        {
	        	$reports->user_country = $_POST['country'];
	        }

	        if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
	        {
	        	$reports->from_date = $_POST['from_date'];
	        	$reports->to_date = $_POST['to_date'];
	        }
	        
			$model = $reports->getSalesProducts();
		} else {
			$model = $reports->getSalesProducts();
		}
		
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator(Yii::app()->name)
			->setLastModifiedBy(Yii::app()->name)
			->setTitle(Yii::app()->name." Reports")
			->setSubject(Yii::app()->name." Reports")
			->setDescription(Yii::app()->name." Reports")
			->setKeywords(Yii::app()->name." Reports")
			->setCategory("result file");		 

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "ID")
			->setCellValue('B1', 'Category')
			->setCellValue('C1', 'Brand')
			->setCellValue('D1', 'Size')
			->setCellValue('E1', 'Title')
			->setCellValue('F1', 'Price')
			->setCellValue('G1', 'Init Price')
			->setCellValue('H1', 'Condition');
		
		$conditions = Product::getConditions();
		foreach ($model as $key => $value) {
			$row = $key + 2;
			$condition = $value['condition'];
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $value['id'])
				->setCellValue('B'.$row, $value['category_name'])
				->setCellValue('C'.$row, $value['brand_name'])
				->setCellValue('D'.$row, $value['size'])
				->setCellValue('E'.$row, $value['title'])
				->setCellValue('F'.$row, $value['price'])                
				->setCellValue('G'.$row, $value['init_price'])
				->setCellValue('H'.$row, $conditions[$condition]);
		}

		$objPHPExcel->getActiveSheet()->setTitle("Unisex resale store Reports");
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel .xlsx');
		header('Content-Disposition: attachment;filename="products_sold_reports.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
			  Yii::app()->end();
	}

	public function actionCreateOrderExcel() {
		$criteria=new CDbCriteria;

        $criteria->select = '`t`.*, count(`t`.`id`) AS count_ord';
        $criteria->group = '`t`.`status`';
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
        {
        	$from_date = $_POST['from_date'];
        	$to_date = $_POST['to_date'];
            $criteria->addCondition("`t`.`added_date` >= '$from_date' and `t`.`added_date` <= '$to_date'");
        }
        
		$model = Order::model()->findAll($criteria);
		
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator(Yii::app()->name)
			->setLastModifiedBy(Yii::app()->name)
			->setTitle(Yii::app()->name." Reports")
			->setSubject(Yii::app()->name." Reports")
			->setDescription(Yii::app()->name." Reports")
			->setKeywords(Yii::app()->name." Reports")
			->setCategory("result file");

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "Order Status")
			->setCellValue('B1', 'Count');
		
		foreach ($model as $key => $value) {
			$row = $key + 2;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $value->status)
				->setCellValue('B'.$row, $value->count_ord);
		}

		$objPHPExcel->getActiveSheet()->setTitle("Unisex resale store Reports");
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel .xlsx');
		header('Content-Disposition: attachment;filename="order_statuses_reports.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
			  Yii::app()->end();
	}

	public function actionCreateDeliveryExcel() {
		$criteria=new CDbCriteria;

        $criteria->select = '`t`.*';
        $criteria->with = array('user', 'shippingAddress');
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
        {
        	$from_date = $_POST['from_date'];
        	$to_date = $_POST['to_date'];
            $criteria->addCondition("`t`.`added_date` >= '$from_date' and `t`.`added_date` <= '$to_date'");
        }
        
		$model = Order::model()->findAll($criteria);
		
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator(Yii::app()->name)
			->setLastModifiedBy(Yii::app()->name)
			->setTitle(Yii::app()->name." Reports")
			->setSubject(Yii::app()->name." Reports")
			->setDescription(Yii::app()->name." Reports")
			->setKeywords(Yii::app()->name." Reports")
			->setCategory("result file");

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "Order added date")
			->setCellValue('B1', 'Order status')
			->setCellValue('C1', 'User email')
			->setCellValue('D1', 'Shipping country')
			->setCellValue('E1', 'Shipping cost');			
		
		foreach ($model as $key => $value) {
			$row = $key + 2;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $value->added_date)
				->setCellValue('B'.$row, $value->status)
				->setCellValue('C'.$row, $value->user->email)
				->setCellValue('D'.$row, $value->shippingAddress->country->name)
				->setCellValue('E'.$row, $value->shipping_cost);
		}

		$objPHPExcel->getActiveSheet()->setTitle("Unisex resale store Reports");
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel .xlsx');
		header('Content-Disposition: attachment;filename="shipping_cost_per_order_reports.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
			  Yii::app()->end();
	}

    public function actionDataChart()
	{
		$reports = new Report();
		$reports->unsetAttributes();

		if (isset($_POST['type_chart']) && $_POST['type_chart'] == 'sale') {
			if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
	    		$reports->from_date = $_POST['from_date'];
				$reports->to_date = $_POST['to_date'];
	    	}
	    	if (isset($_POST['category'])) {
	    		$reports->category_id = $_POST['category'];
	    	}
	    	echo json_encode($reports->getSalesChart());
	    	Yii::app()->end();
		}

		if (isset($_POST['type_chart']) && $_POST['type_chart'] == 'users') {
			if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
	    		$reports->from_date = $_POST['from_date'];
				$reports->to_date = $_POST['to_date'];
	    	}
	    	if (isset($_POST['country'])) {
	    		$reports->user_country = $_POST['country'];
	    	}
	    	echo json_encode($reports->getUsersChart());
	    	Yii::app()->end();
		}

		if (isset($_POST['type_chart']) && $_POST['type_chart'] == 'orders') {
			if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
	    		$reports->from_date = $_POST['from_date'];
				$reports->to_date = $_POST['to_date'];
	    	}
	    	echo json_encode($reports->getOrdersChart());
	    	Yii::app()->end();
		}	

		if (isset($_POST['type_chart']) && $_POST['type_chart'] == 'delivery') {
			if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
	    		$reports->from_date = $_POST['from_date'];
				$reports->to_date = $_POST['to_date'];
	    	}
	    	echo json_encode($reports->getDeliveryChart());
	    	Yii::app()->end();
			}	
	}
}
