<?php
/* @var $this PlatformsController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
	'Manage Platforms'=>array('/members/platforms'),
	$model->domainname => '',
);
?>
<div>
    <form>
    <?php $this->renderPartial('/shared/platforms/view', array('model' => $model)); ?>

    <div class="form-actions buttons">
        <div align="center">
            <?php echo CHtml::link('Edit RBL Info', $this->createAbsoluteUrl('/members/platforms/editrbl', array('id' => $model->recordid), array('class' => 'btn btn-success'))); ?>
            <?php echo CHtml::link('Platform Health', $this->createAbsoluteUrl('/members/platform/health/index', array('id' => $model->recordid, 'date' => date('Y-m-d'))), array('class' => 'btn btn-warning')); ?>
            <?php echo CHtml::link('Manage WP Blog', 'http://blog.'.$model->domainname.'/wp-admin/', array('class' => 'btn btn-inverse', 'target' => '_blank')); ?>
            <?php echo CHtml::link('APIs', $this->createAbsoluteUrl('/members/platform/api/index', array('id' => $model->recordid)), array('class' => 'btn btn-danger')); ?>
            <?php echo CHtml::link('Upload Data', $this->createAbsoluteUrl('/members/platform/upload/index', array('id' => $model->recordid)), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('Data Hygiene', $this->createAbsoluteUrl('/members/platform/hygiene/index', array('id' => $model->recordid)), array('class' => 'btn btn-success')); ?>
            <?php if(Yii::app()->client->kayakoid != 0) echo CHtml::link('Support Request', $this->createAbsoluteUrl('/members/platform/support/index', array('id' => $model->recordid)), array('class' => 'btn btn-info')); ?><br /><br />
            <?php echo CHtml::link('Login to Platform', $this->createAbsoluteUrl('/members/platforms/platformLogin', array('id' => $model->recordid)), array('class' => 'btn', 'target' => '_blank'));?>
        </div>
    </div>
    </form>
</div>
