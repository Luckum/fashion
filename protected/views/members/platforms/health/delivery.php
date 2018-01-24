<?php
/* @var $this HealthController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'ISP Delivery' => '',
);
?>
<h1>ISP Delivery for "<?=CHtml::encode($model->domainname);?>"</h1>

<?php $this->renderPartial('_subnav', array('model' => $model)); ?>
<?php $this->renderPartial('/shared/platforms/delivery', array('model' => $model, 'dataProvider' => $dataProvider, 'date' => $date, 'total' => $total, 'slaves' => $slaves));
