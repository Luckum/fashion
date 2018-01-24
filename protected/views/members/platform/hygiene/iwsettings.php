<?php
/* @var $this HygieneController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms' => array('/members/platforms'),
    $model->domainname => array('/members/platforms/view', 'id' => $model->recordid),
    'Data Hygiene' => array('/members/platform/hygiene/index', 'id' => $model->recordid),
    'ImpressionWise' => array('/members/platform/hygiene/impressionwise', 'id' => $model->recordid),
    'Settings' => '',
);
?>
<h1>Data Hygiene :: ImpressionWise Settings</h1>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'impressionwise-settings-iwsettings-form',
	'enableAjaxValidation'=>false, 
    'htmlOptions' => array('class' => 'form-inline'),
)); ?>

<?php
if($saved) {
?>
<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Changes has been successfully saved.</div>
<?php
}
?>
<br />
    <div class="row offset1">
        Use your own settings instead of shared ones: 
        <div class="btn-group" data-toggle="buttons-radio">
            <button id="btnon" class="btn<?=($settings->type=='own')?' active':'';?>" type="button" onclick="location.href='/members/platform/hygiene/iwsettings/id/<?=$model->recordid;?>/toggle/own'">YES</button>
            <button id="btnoff" class="btn btn-danger<?=($settings->type=='shared')?' active':'';?>" type="button" onclick="location.href='/members/platform/hygiene/iwsettings/id/<?=$model->recordid;?>/toggle/shared'">NO</button>
        </div>
    </div>
<br />
<?php
if($settings->type == 'own') {
?>

    <?php echo $form->errorSummary($settings, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', null, array('class' => 'alert alert-error mid')); ?>

<h4>FTP Server Settings</h4>
	<div class="row">
		<?php echo $form->labelEx($settings,'ftp_server'); ?>
		<?php echo $form->textField($settings,'ftp_server'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($settings,'ftp_user'); ?>
		<?php echo $form->textField($settings,'ftp_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($settings,'ftp_password'); ?>
		<?php echo $form->textField($settings,'ftp_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($settings,'ftp_file_prefix'); ?>
		<?php echo $form->textField($settings,'ftp_file_prefix'); ?>
	</div>
<h4>Live Feed API Settings</h4>    
    <div class="row">
        <?php echo $form->labelEx($settings,'feed_url'); ?>
        <?php echo $form->textField($settings,'feed_url'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($settings,'account_code'); ?>
        <?php echo $form->textField($settings,'account_code'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($settings,'password'); ?>
        <?php echo $form->textField($settings,'password'); ?>
    </div>

	<div class="form-actions row">
        <div class="offset2">
		<?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
        </div>
	</div>
<?php
}
?>
<?php $this->endWidget(); ?>

<!-- form -->