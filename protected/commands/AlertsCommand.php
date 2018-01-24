<?php

class AlertsCommand extends CConsoleCommand {

    public function run($args) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'alerts_sent = 0 AND t.status = :status';
        $criteria->with = array('brand', 'category');
        $criteria->params = array(':status' => Product::PRODUCT_STATUS_ACTIVE);
        $products = Product::model()->findAll($criteria);
        $productIds = CHtml::listData($products, 'id', 'id');
        $template = Template::model()->find("alias = 'price_alert_notification' AND language = :lang", array(':lang' => 'en'));
        if (!count($template)) die();
        foreach ($products as $product) {
            $alerts = Alerts::model()
                ->with('user')
                ->findAll(
                    array(
                        'condition' => 'subcategory_id=:subcategory_id AND size_type=:size_type',
                        'params' => array(
                            ':subcategory_id' => $product->category_id,
                            ':size_type' => $product->size_type
                        ),
                    )
                );

            if ($alerts && $product->status == Product::PRODUCT_STATUS_ACTIVE) {
                foreach ($alerts as $alert) {
                    $user = $alert->user;
                    $url = Product::getProductUrl($product->id, $product);
                    $parameters = EmailHelper::setValues($template->content, array(
                            $user,
                            $product,
                            array(
                                'Option' => array(
                                    'link' => 'http://23-15.com' . $url,
                                )
                            )
                        )
                    );
                    $mail = new Mail();
                    $mail->send(
                        $user->email,
                        $template->subject,
                        Yii::t('base', $template->content, $parameters),
                        $template->priority
                    );
                }
            }
        }
        Product::model()->updateByPk($productIds, array(
            'alerts_sent' => 1
        ));
    }
}