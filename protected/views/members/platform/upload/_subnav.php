<?php 
$this->widget('zii.widgets.CMenu',array(
    'htmlOptions' => array('class' => 'nav nav-tabs'),
    'activateItems' => true,
    'items'=>array(
        array('label'=>'Upload Data', 'url'=>array('/members/platform/upload/index', 'id' => $model->recordid), 'active' => $active),
        array('label'=>'Upload History', 'url'=>array('/members/platform/upload/history', 'id' => $model->recordid)),
    ),
)); 