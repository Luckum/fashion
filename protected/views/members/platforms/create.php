<?php
/* @var $this PlatformsController */
/* @var $model Platforms */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),    
    'Manage Platforms'=>array('/members/platforms'),
    'Add New' => '',
);
?>
<div>
    <h1>Add New Platform</h1>
<?php $this->renderPartial('/shared/platforms/edit', array('model' => $model)); ?>
</div><!-- form -->