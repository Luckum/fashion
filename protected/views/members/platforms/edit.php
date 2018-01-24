<?php
/* @var $this PlatformsController */
/* @var $model Platforms */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),    
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname => '',
);
?>
<div>
    <h1>Edit Platform "<?=CHtml::encode($model->domainname);?>"</h1>
<?php $this->renderPartial('/shared/platforms/edit', array('model' => $model)); ?>
</div><!-- form -->