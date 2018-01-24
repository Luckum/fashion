<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Users') => array('control/users'),
    $model->username => '',
);

?>

<h2><?=Yii::t('base', 'More info about'); ?> "<?php echo CHtml::encode($model->username); ?>"</h2>

<h5><?=Yii::t('base', 'Shipping details'); ?></h5>

<?php $this->widget('FGridView', array(
    'id'=>'shipping-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$shippingData,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        array('name' => 'user_id', 'value' => '$data->user->username'),
        'firstname',
        'surname',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        array('name' => 'country_id', 'value' => '$data->country->name')
    ),
)); ?>

<?php if(!empty($billingData->getData())) : ?>
<h5><?=Yii::t('base', 'Billing details'); ?></h5>

<?php $this->widget('FGridView', array(
    'id'=>'shipping-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$billingData,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        'billing_address',
        'billing_address2',
        'billing_city',
        'billing_state',
        'billing_zip',
        array('name' => 'billing_country_id', 'value' => '$data->country->name'),
        'billing_first_name',
        'billing_surname'
    ),
)); ?>

<h5><?=Yii::t('base', 'Bank details'); ?></h5>

<?php $this->widget('FGridView', array(
    'id'=>'shipping-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$billingData,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        'bank_first_name',
        'bank_surname',
        'bank_iban',
        'bank_swift_bik'
    ),
)); ?>
<?php endif; ?>

<h5><?=Yii::t('base', 'User wishlist'); ?></h5>

<?php $this->widget('FGridView', array(
    'id'=>'shipping-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$wishData,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        array('name' => 'user_id', 'value' => '$data->user->username'),
        array('name' => 'product_id', 'value' => '$data->product->title'),
    ),
)); ?>

<h5><?=Yii::t('base', 'User alerts'); ?></h5>

<?php $this->widget('FGridView', array(
    'id'=>'shipping-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$alertsData,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        array('name' => 'user_id', 'value' => '$data->user->username'),
        array('name' => 'category_id', 'value' => '$data->category->alias'),
        array('name' => 'subcategory_id', 'value' => '$data->subcategory->alias'),
        'size_type'
    ),
)); ?>
