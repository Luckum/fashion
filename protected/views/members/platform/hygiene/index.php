<?php
/* @var $this HygieneController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Data Hygiene' => '',
);

?>
<h1>Data Hygiene</h1>

<p>
	Use on of the services below to determine validity of your leads
</p>
<div class="row">
    <div class="span4 text-center">
        <?php echo CHtml::link('ImpressionWise', $this->createAbsoluteUrl('/members/platform/hygiene/impressionwise', array('id' => $model->recordid)), array('class' => 'btn btn-large btn-info')); ?>
    </div>
    <div class="span4 text-center">
        <?php echo CHtml::link('SiftLogic', $this->createAbsoluteUrl('/members/platform/hygiene/siftlogic', array('id' => $model->recordid)), array('class' => 'btn btn-large btn-success')); ?>
    </div>
    <div class="span3 text-center">
        <?php echo CHtml::link('HygieneAgent', $this->createAbsoluteUrl('/members/platform/hygiene/hygieneagent', array('id' => $model->recordid)), array('class' => 'btn btn-large btn-danger')); ?>
    </div>
</div>

