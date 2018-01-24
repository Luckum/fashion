<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Account Information'=>array('/my-account'),
    'Credit Card Details' => '',
);
?>
<div>
    <h1><?php echo Yii::t('base', 'Credit Card Details'); ?></h1>
<?php $this->renderPartial('_subnav'); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'clients-edit-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a>
<strong>' . Yii::t('base',  'The following errors occurred') . ':</strong><br><br>', '', array('class' => 'alert alert-error mid')); ?>
<?php 
if($saved) {
?>
    <div class="alert alert-success">
        <?php echo Yii::t('base', 'Changes Saved Successfully!'); ?>
        <a class="close" data-dismiss="alert" href="#">&times;</a>
    </div>
<?php
}
?>
    <div class="row">
        <div class="span6 offset1">
            <div class="row">
                <?php echo $form->labelEx($model,'Card Type'); ?>
                <?php echo $form->textField($model, 'cctype', array('readonly'=>true)); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'Card Number'); ?>
                <?php echo $form->textField($model, 'cclastfour', array('readonly'=>true, 'class' => 'small')); ?>
            </div>
        </div>
        <div class="span10">
            <h4><?php echo Yii::t('base', 'Enter New Card Information Below'); ?></h4>
        </div>
        
        <div class="span6 offset1">
            <div class="row">
                <?php echo $form->labelEx($model,'Card Type'); ?>
                <?php echo CHtml::dropDownList('cardtype', 'Visa', array('Visa'=>'Visa', 'MasterCard'=>'MasterCard', 'Discover'=>'Discover', 'American Express'=>'American Express', 'JCB'=>'JCB')); ?>
            </div>
            
            <div class="row">
                <?php echo $form->labelEx($model,'Card Number'); ?>
                <?php echo CHtml::textField('cardnum', ''); ?>
            </div>
            
            <div class="row">
                <?php echo $form->labelEx($model,'Expiry Date'); ?>
                <?php echo CHtml::dropDownList('expmonth', '', array('01'=>'01', '02'=>'02', '03'=>'03', '04'=>'04', '05'=>'05', '06'=>'06', '07'=>'07', '08'=>'08', '09'=>'09', '10'=>'10', '11'=>'11', '12'=>'12'), array('style'=> 'width: auto;')); ?> <span class="large">/</span>
                <?php echo CHtml::dropDownList('expyear', '', array(date('Y')=>date('Y'), date('Y')+1=>date('Y')+1, date('Y')+2=>date('Y')+2, date('Y')+3=>date('Y')+3, date('Y')+4=>date('Y')+4, date('Y')+5=>date('Y')+5, date('Y')+6=>date('Y')+6, date('Y')+7=>date('Y')+7, date('Y')+8=>date('Y')+8, date('Y')+9=>date('Y')+9, date('Y')+10=>date('Y')+10, date('Y')+11=>date('Y')+11, date('Y')+12=>date('Y')+12), array('style'=> 'width: auto;')); ?>
            </div>
        </div>

    </div>
<?php $this->renderPartial('_form_actions'); ?>

<?php $this->endWidget(); ?>

</div>