<?php 
$date = $this->date;
$this->widget('zii.widgets.CMenu',array(
    'htmlOptions' => array('class' => 'nav nav-tabs'),
    'activateItems' => true,
    'items'=>array(
        array('label'=>'Delivery Reports', 'url'=>array('/members/platform/health/index', 'id' => $model->recordid, 'date' => $date)),
        array('label'=>'ISP Delivery', 'url'=>array('/members/platform/health/delivery', 'id' => $model->recordid, 'date' => $date)),
        array('label'=>'Reputation', 'url'=>array('/members/platform/health/reputation', 'id' => $model->recordid, 'date' => $date)),
        array('label'=>'Blocks', 'url'=>array('/members/platform/health/blocks', 'id' => $model->recordid, 'date' => $date)),
        array('label'=>'ISP Remediation', 'url'=>array('/members/platform/health/remediation', 'id' => $model->recordid, 'date' => $date)),
        array('label'=>'Seed Delivery Monitoring', 'url'=>array('/members/platform/health/seed', 'id' => $model->recordid, 'date' => $date)),
    ),
)); 

$this->renderPartial('/shared/platforms/calendar', array('controller' => '/members/platform/health/', 'model' => $model, 'date' => $date));
