<?php
/* @var $this ReportsController */
/* @var $model Report */


$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Reports') => '',
);

?>

<h1><?=Yii::t('base', 'Manage Reports');?></h1>

<p><?php echo CHtml::link(Yii::t('base', 'Products sold') . " (".count($reports->getSalesProducts()).")", array('/control/reports/sale'), array('class' => 'btn btn-large btn-primary')); ?></p>
<p><?php echo CHtml::link(Yii::t('base', 'Active users locations'), array('/control/reports/users'), array('class' => 'btn btn-large btn-primary')); ?></p>
<p><?php echo CHtml::link(Yii::t('base', 'Shipping cost per order'), array('/control/reports/delivery'), array('class' => 'btn btn-large btn-primary')); ?></p>
<p><?php echo CHtml::link(Yii::t('base', 'Order statuses'), array('/control/reports/orders'), array('class' => 'btn btn-large btn-primary')); ?></p>