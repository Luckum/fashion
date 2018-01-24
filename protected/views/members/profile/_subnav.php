<?php 
$this->widget('zii.widgets.CMenu',array(
    'htmlOptions' => array('class' => 'nav nav-tabs'),
    'activateItems' => true,
    'items'=>array(
        array('label'=>'My Details', 'url'=>array('/members/profile/edit')),
        array('label'=>'Credit Card Details', 'url'=>array('/members/profile/billing')),
        array('label'=>'Change Password', 'url'=>array('/members/profile/changePassword')),
    ),
)); 


