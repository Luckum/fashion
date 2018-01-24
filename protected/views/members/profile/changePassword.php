<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Account Information'=>array('/my-account'),
	'Change Password' => '',
);
?>
<div>
<h1><?php echo Yii::t('base', 'Change Password'); ?></h1>
<?php $this->renderPartial('_subnav'); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'clients-edit-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php $this->renderPartial('/shared/profile/changePassword', array('model' => $model, 'form' => $form, 'saved' => $saved, 'self' => true)); ?>

<?php $this->renderPartial('_form_actions'); ?>

<?php $this->endWidget(); ?>

</div>