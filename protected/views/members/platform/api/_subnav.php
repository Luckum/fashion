<?php 
$this->widget('zii.widgets.CMenu',array(
    'htmlOptions' => array('class' => 'nav nav-tabs'),
    'activateItems' => true,
    'items'=>array(
        array('label'=>'Optimus API', 'url'=>array('/members/platform/api/index', 'id' => $model->recordid)),
        array('label'=>'Platform API', 'url'=>array('/members/platform/api/platform', 'id' => $model->recordid)),
    ),
)); 