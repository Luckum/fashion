<?php
/* @var $this HealthController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Delivery Reports' => '',
);
?>
<h1>Delivery Reports for "<?=CHtml::encode($model->domainname);?>"</h1>

<?php $this->renderPartial('_subnav', array('model' => $model)); ?>

<?php $this->renderPartial('/shared/platforms/reports', array('model' => $model, 'dataProvider' => $dataProvider, 'date' => $date, 'total' => $total, 'slaves' => $slaves)); ?>