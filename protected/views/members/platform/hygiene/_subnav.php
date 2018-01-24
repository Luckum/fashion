<?php 
$this->widget('zii.widgets.CMenu',array(
    'htmlOptions' => array('class' => 'nav nav-tabs'),
    'activateItems' => true,
    'items'=>array(
        array('label'=>'ImpressionWise', 'url'=>array('/members/platform/hygiene/impressionwise', 'id' => $model->recordid)),
        array('label'=>'SiftLogic', 'url'=>array('/members/platform/hygiene/siftlogic', 'id' => $model->recordid)),
        array('label'=>'HygieneAgent', 'url'=>array('/members/platform/hygiene/hygieneagent', 'id' => $model->recordid)),
    ),
)); 



