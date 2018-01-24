<?php
/* @var $this OrdersController */
/* @var $model Order */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Orders') => array('control/orders' . $backParameters),
    Yii::t('base', 'View Order') . ' ' . $model->id => ''
);

?>

    <h1>
    <?=Yii::t('base', 'View Order'); ?> "<?php echo $model->id; ?>"
        <a style="float:right" title="Get CSV file" href="<?= Yii::app()->createUrl("control/orders/getOrderCsv", array("id"=>$model->id)) ?>">
        <?php echo CHtml::image(
                Yii::app()->request->getBaseUrl(true) . '/images/csv-64.png', 
                'Get CSV file'
              ); 
        ?>
    </a>
    </h1>
    



<?php if (Yii::app()->user->hasFlash('pay_error')): ?>
    <div class="row-fluid">
        <div class="alert alert-danger">
            <?php echo Yii::app()->user->getFlash('pay_error'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('pay_success')): ?>
    <div class="row-fluid">
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('pay_success'); ?>
        </div>
    </div>
<?php endif; ?>

<div class="row-fluid">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'added_date',
            'status',
            array('name' => Yii::t('base', 'Subtotal'), 'value' => $model->subtotal),
            'shipping_cost',
            'total',

        ),
    )); ?>
</div>
<h4>Buyer info</h4>
<div class="row-fluid">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name' => Yii::t('base', 'Username'), 'value' => $model->user->username),
            array(
                'name' => Yii::t('base', 'Name, Last name'),
                'value' => $model->shippingAddress->first_name . ' ' . $model->shippingAddress->surname
            ),
            array(
                'name' => Yii::t('base', 'Shipping Address'),
                'value' => $model->shippingAddress->address . ', ' .
                    $model->shippingAddress->address_2 . ', ' .
                    $model->shippingAddress->state . ', ' .
                    $model->shippingAddress->city . ', ' .
                    $model->shippingAddress->country->name . ', ' .
                    $model->shippingAddress->zip,
            ),
            array(
                'name' => Yii::t('base', 'E-mail'),
                'value' => $model->user->email,
            )
        ),
    )); ?>
</div>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'startShipping',
        'options'=>array(
            'title'=>Yii::t('base', 'Send shipp. label'),
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=>'false',
        ),
    ));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'giveDataToBuyer',
    'options'=>array(
        'title'=>Yii::t('base', 'Send shipp. info'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=>'false',
    ),
));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'changeDeliveryStatus',
    'options'=>array(
        'title'=>Yii::t('base', 'Change shipp. status'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=>'false',
    ),
));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'changeStatus',
    'options'=>array(
        'title'=>Yii::t('base', 'Change Order Item Status'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=>'false',
    ),
));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'givePayment',
    'options'=>array(
        'title'=>Yii::t('base', 'Pay vendor'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=>'false',
    ),
));
$this->endWidget();
$count = count(OrderItem::model()->findAll('order_id ='.$orderId));
$class = ($count>1) ? 'btn-group' : 'dropup';
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'order-item-grid',
    'enableHistory' => true,
    'dataProvider'=>$itemModel->search($orderId),
    'rowHtmlOptionsExpression'=>'array("data-product-id"=>$data->product_id)',
    'columns'=>array(
        array('name' => 'product_id', 'value' => '$data->product->brand->name.", ".
            $data->product->title.", size ".
            (empty($data -> product -> size_chart) ? Yii :: t(\'base\', \'No size\') : $data -> product -> size_chart -> size) . ", ID#".
            $data->product->id'),
        array('name' => 'seller', 'value' => '$data->product->user->username'),
        array('name' => 'Price', 'value' => '$data->price'),
        array('name' => 'shipping_status', 'value' => 'ucfirst($data->shipping_status)'),
        array(
            'name' => Yii::t('base', 'Actions'),
            'type' => 'raw',
            'value' => function ($data) {
                $count = count(OrderItem::model()->findAll('order_id ='.$data->order_id));
                $class = ($count>1) ? 'btn-group' : 'dropup';
                $menu = '<div class="'.$class.'" style="width:100%">
                  <button style="width:100%" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">' . Yii::t('base', 'Choose an action') . ' <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a id="start_shipping_menu" href="' . Yii::app()->createUrl("control/orders/startShipping", array("id"=>$data->id)) . '">' . Yii::t('base', 'Send shipp. label') . '</a></li>
                    <li><a id="change_shipping_menu" href="' . Yii::app()->createUrl("control/orders/changeOrderDeliveryItemStatus", array("id"=>$data->id)) . '">' . Yii::t('base', 'Change shipp. status') . '</a></li>
                    <li><a id="give_buyer_data_menu" href="' . Yii::app()->createUrl("control/orders/giveData", array("id"=>$data->id)) . '">' . Yii::t('base', 'Send shipp. info') . '</a></li>';

                $payItemColor = OrderItem::model()->checkItem($data->id);
                if ($payItemColor == 'red' || $payItemColor == 'blue') {
                    $menu .= '<li><a style="color:' . $payItemColor . '" id="pay_seller_menu" href="' . Yii :: app() -> createUrl("control/orders/givePayment", array("id"=>$data->id)) . '">' . Yii::t('base', 'Pay vendor') . '</a></li>';
                }
                $menu .= '</ul></div>';
                return $menu;
            }
        ),
    ),
)); 
?>

<script>
    jQuery(document).ready(function($) {
        $(document).on('click', '#start_shipping_menu', function(event) {
            var url = $(this).attr('href');
            $.get(url, function(r){
                $("#startShipping").html(r).dialog("open");
            });
            return false;
        });

        $(document).on('click', '#give_buyer_data_menu', function(event) {
            var url = $(this).attr('href');
            $.get(url, function(r){
                $("#giveDataToBuyer").html(r).dialog("open");
            });
            return false;
        });

        $(document).on('click', '#change_shipping_menu', function(event) {
            var url = $(this).attr('href');
            $.get(url, function(r){
                $("#changeDeliveryStatus").html(r).dialog("open");
            });
            return false;
        });

        $(document).on('click', '#pay_seller_menu', function(event) {
            var url = $(this).attr('href');
            $.get(url, function(r){
                $("#givePayment").html(r).dialog("open");
            });
            return false;
        });

        $(document).on('click', '#order-item-grid tr', function(event) {
            var product_id = $(this).data('product-id');
            window.location='<?= Yii::app()->createUrl('control/products/view', array('id'=>'')) ?>' + product_id;
            return false;
        });
    });
</script>