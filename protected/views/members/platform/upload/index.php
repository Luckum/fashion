<?php
/* @var $this PlatformsController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Upload Data' => '',
);
?>

<h1>Upload Data to "<?=$model->domainname;?>"</h1>
<?php $this->renderPartial('_subnav', array('model' => $model, 'active'=> true)); ?>
    

<?php $this->beginWidget('CActiveForm', array('action' => array('/members/platform/upload/mapping', 'id' => $model->recordid), 'htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>
<?php echo CHtml::hiddenField('responder_name', '');?>


<?php
if($error != '') {
?>
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert" href="#">&times;</a>
    <?=$error;?>
</div>
<?php
}
?>

<div class="row">
    <?php echo CHtml::label('Autoresponder Name','responderid', array('required' => true)); ?>
    <?php echo CHtml::dropDownList('responderid', '', $list, array('onchange' => 'setName(this)')); ?>
    <div class="span6 smaller right text-success">Please choose an autoresponder you want to upload the data to</div>
</div>
<div class="row">
    <?php echo CHtml::label('File', 'file', array('required' => true)); ?>
    <?php echo CHtml::fileField('file', '', array('style' => 'width: 220px;')); ?>
    <div class="span6 smaller right text-success">Only CSV or TXT files allowed for uploading</div>
</div>
<div class="row">
    <?php echo CHtml::label('List Format','format', array('required' => true)); ?>
    <?php echo CHtml::dropDownList('format', '', $format); ?>
    <div class="span6 smaller right text-success">Specify the format of your list by using the dropdown menu. Your list must have one subscriber record per line, & each field must be separated by either a comma, semicolon, tab or pipe.</div>
</div>

<h4>Data Hygiene</h4>
<div class="row">
    <?php echo CHtml::label('Verify with SiftLogic','verifysl', array('required' => true)); ?>
    <div class="span1"><input type="radio" name="verifysl" value="no" checked="checked" /> No </div>
    <div class="span1"><input type="radio" name="verifysl" value="yes" /> Yes </div>
</div>
<div class="row">
    <?php echo CHtml::label('Verify with ImpressionWise','verifyiw', array('required' => true)); ?>
    <div class="span1"><input type="radio" name="verifyiw" value="no" checked="checked" /> No </div>
    <div class="span1"><input type="radio" name="verifyiw" value="yes" /> Yes </div>
    
</div>


<div class="form-actions buttons">
    <div class="offset2">
        <?php echo CHtml::submitButton('Continue', array('class' => 'btn btn-primary')); ?>
    </div>
</div>
        
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('setName', "
function setName(select) {
    select.form.responder_name.value = select.options[select.selectedIndex].text;
}
", CClientScript::POS_END);
