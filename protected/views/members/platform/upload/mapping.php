<?php
/* @var $this UploadController */
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Upload Data' => array('/members/platform/upload/index', 'id' => $model->recordid)
);
?>
<div>
<h1>Upload Data to "<?=$model->domainname;?>"</h1>

<?php $this->renderPartial('_subnav', array('model' => $model, 'active' => true)); ?>
    
Importing "<strong><?=$real_filename;?></strong>" file  into autoresponder "<strong><?=$responder_name;?></strong>"
<?php $this->beginWidget('CActiveForm', array('action' => array('/members/platform/upload/process', 'id' => $model->recordid), 'htmlOptions' => array('onsubmit' => 'return check(this)'))); ?>
    
    <?php echo CHtml::hiddenField('filename', $real_filename); ?>
    <?php echo CHtml::hiddenField('uploadedfilename', $filename); ?>
    <?php echo CHtml::hiddenField('format', $format); ?>
    <?php echo CHtml::hiddenField('responderid', $responderid); ?>
    <?php echo CHtml::hiddenField('respondername', $responder_name); ?>
    <?php echo CHtml::hiddenField('verifysl', $verifysl); ?>
    <?php echo CHtml::hiddenField('verifyiw', $verifyiw); ?>
    
    <h3>Fields Mapping</h3>
    <div class="row">
    
        <div class="span11">
            <div class="row">
                <?php
                while(list($key, $value) = each($fields)) {
                ?>
                <div class="span5">
                    <div class="row">
                        <?php echo CHtml::label($value, $key, array('required' => ($key=='email')));?>
                        <?php echo CHtml::dropDownList($key, '-1', $headers); ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::submitButton('Continue', array('class' => 'btn btn-primary')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>

<?php
Yii::app()->clientScript->registerScript('mapping', "
function check(form) {
    if(form.email.options[form.email.selectedIndex].value=='-1') {
        alert('Please select Email field');
        return false;
    }
    return true;
    
}
", CClientScript::POS_END);
?>
