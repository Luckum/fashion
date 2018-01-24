<?php
/* @var $this SellersProfileController */
/* @var $data SellerProfile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_type')); ?>:</b>
	<?php echo CHtml::encode($data->seller_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comission_rate')); ?>:</b>
	<?php echo CHtml::encode($data->comission_rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paypal_email')); ?>:</b>
	<?php echo CHtml::encode($data->paypal_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php echo CHtml::encode($data->rating); ?>
	<br />


</div>