<?php

class IndexController extends AdminController
{
    public function actionIndex()
    {
        $products = new Product('search');
        $products->unsetAttributes();
        $orders = new Order('search');
        $orders->unsetAttributes();
        $users = new User('search');
        $users->unsetAttributes();

        $quickBooksFailedUsers = User::model()->findAll('qb_user_id IS NULL');
        if (count($quickBooksFailedUsers) > 0) {
            Yii::app()->user->setFlash(
                'quickBooksFailed',
                Yii::t(
                    'base',
                    'Your QuickBooks account doesn\'t work. You must configure him and reload last registered users'));
        }

        $this->render('index', array(
            'products' => $products,
            'orders' => $orders,
            'users' => $users,
        ));
    }

    public function actionDateRange()
    {
        Yii::app()->clientScript
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END)
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/bootstrap-daterangepicker/daterangepicker.js', CClientScript::POS_END)
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/chartJs/Chart.min.js', CClientScript::POS_END)
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/reportCharts.js', CClientScript::POS_END)
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/dateRange.js', CClientScript::POS_END)
            ->registerScriptFile(Yii::app()->request->getBaseUrl(true) . '/js/script.js', CClientScript::POS_END)
            ->registerCssFile(Yii::app()->request->getBaseUrl(true) . '/js/bootstrap-daterangepicker/daterangepicker.css');

        $products = new Product('search');
        $orders = new Order('search');
        $users = new User('search');

        $products->unsetAttributes();
        $orders->unsetAttributes();
        $users->unsetAttributes();

        if (isset($_POST['from_date'], $_POST['to_date'])) {
            $from = $_POST['from_date'];
            $to   = $_POST['to_date'];
        } else {
            $from = date('Y-m-d H:i:s', strtotime('-1 day'));
            $to   = date('Y-m-d') . ' 23:59:59.999';
        }

        $products->from_date = $users->from_date = $orders->from_date = $from;
        $products->to_date   = $users->to_date   = $orders->to_date   = $to;

        $this->renderPartial('_index', array(
            'products' => $products->getProductsFromChart(),
            'orders'   => $orders->getOrdersFromChart(),
            'users'    => $users->getUsersFromChart(),
        ));
    }

    public function actionDataChart()
    {
        if (!isset($_POST['type_chart'])) throw new Exception('missing type of chart');

        $type = $_POST['type_chart'];

        $model = $result = null;

        switch ($type) {
            case 'users' :
                $model = new User();
                break;
            case 'products' :
                $model = new Product();
                break;
            case 'orders' :
                $model = new Order();
                break;
        }

        if ($model === null) throw new Exception('undefined type of chart - ' . $type);

        $model->unsetAttributes();

        if (isset($_POST['from_date'], $_POST['to_date'])) {
            $model->from_date = $_POST['from_date'];
            $model->to_date = $_POST['to_date'];
        }

        switch ($type) {
            case 'users' :
                $result = $model->getUsersFromChart();
                break;
            case 'products' :
                $result = $model->getProductsFromChart();
                break;
            case 'orders' :
                $result = $model->getOrdersFromChart();
                break;
        }

        if ($result) {
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }

    public function actionReloadQuickBooksUsers()
    {
        $quickBooksFailedUsers = User::model()->findAll('qb_user_id IS NULL');

        if (count($quickBooksFailedUsers) > 0) {

            foreach ($quickBooksFailedUsers as $user) {
                try {
                    $qb = new Quickbooks(Yii::app()->params['misc']['quickBooks_IsDemo']);
                    $customer = $qb->addCustomer($user->username);
                    $user->qb_user_id = $customer->Id;
                    $user->save();
                } catch (Exception $e) {
                    Yii::log($e->getMessage());
                }
            }
        }

        $this->redirect('index');
    }
}