<?php
/* @var $this ReportsController */
/* @var $model Report */

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Reports') => array('control/reports'),
    Yii::t('base', 'Report Shipping cost per order') => '',
);
?>

<h1><?=Yii::t('base', 'Report Shipping cost per order');?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>'/control/reports/createDeliveryExcel',
    'method'=>'post',
    'id' => 'frmsearch',
    'htmlOptions' => array(
        'name' => 'frmsearch',
        ),
)); ?>

<script>
    var server_date = '<?=date('Y-m-d H:i:s')?>';
</script>

<div class="row">
    <div class="span4 pull-right" id="deliveryReportRange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
        <i class="icon-calendar"></i>&nbsp;
        <span></span>
    </div>
</div>
<?php echo CHtml::hiddenField(Yii::t('base', 'from_date')); ?>
<?php echo CHtml::hiddenField(Yii::t('base', 'to_date')); ?>
<?php echo CHtml::button(Yii::t('base', 'Export Shipping cost per order'), array('class' => 'btn btn-large btn-primary', 'onclick' => 'return export_exel();')); ?>
<?php $this->endWidget(); ?>

<div id="grid-container"><?php $this->actionDeliveryGrid(); ?></div>