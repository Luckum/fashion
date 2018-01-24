<?php

class PaymentController extends AdminController
{
    public function actionIndex()
    {
        $data = Yii::app()->params->payment;
        if (isset($_POST['save'])) {
            $default_comission_rate = round($_POST['default_comission_rate'] / 100, 2);
            UtilsHelper::addParams('payment', 'default_comission_rate', $default_comission_rate);
            $data['default_comission_rate'] = $default_comission_rate;
        }
        $this->render('index',array(
            'data' => $data
        ));
    }
}