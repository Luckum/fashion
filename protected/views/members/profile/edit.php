<?php
/* @var $this ClientsController */
/* @var $model Clients */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Account Information'=>array('/my-account'),
    'My Details' => '',
);
?>
<div>
<h1><?php echo Yii::t('base', 'My Details'); ?></h1>
<?php $this->renderPartial('_subnav'); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clients-edit-form',
	'enableAjaxValidation'=>false,
    'errorMessageCssClass' => 'alert-error',
)); ?>

<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>' .
	Yii::t('base', 'The following errors occurred') .
	':</strong><br><br>', null, array('class' => 'alert alert-error mid')); ?>
<?php 
if($saved) {
?>
<div class="alert alert-success">
	<?php echo Yii::t('base', 'Changes Saved Successfully!'); ?>
	<a class="close" data-dismiss="alert" href="#">&times;</a></div>
<?php
}
?>


<?php $this->renderPartial('/shared/profile/clientProfile', array('form' => $form, 'model' => $model)); ?>    


<?php $this->renderPartial('_form_actions'); ?>	

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile('/js/statesdropdown.js', CClientScript::POS_END); ?>