<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', '', array('class' => 'alert alert-error mid')); ?>
<?php 
if($saved) {
?>
<div class="alert alert-success">Changes Saved Successfully!<a class="close" data-dismiss="alert" href="#">&times;</a></div>
<?php
}
?>
<div class="row">
    <div class="span6 offset1">
<?php if($self==true) {
  ?>
        <div class="row">
            <?php echo $form->labelEx($model,'Existing Password'); ?>
            <?php echo CHtml::passwordField('existing_password'); ?>
        </div>
  <?php  
}
?>
        <div class="row">
            <?php echo $form->labelEx($model,'New Password'); ?>
            <?php echo CHtml::passwordField('new_password'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'Confirm New Password'); ?>
            <?php echo CHtml::passwordField('new_password2'); ?>
        </div>
        
        <div class="row">    
            <div id="pass_progress" class="progress progress-danger" style="width:400px;">
                <div class="bar" style="width: 0"></div>
            </div>
        </div>

    </div>

</div>

<?php
Yii::app()->clientScript->registerScript('passwordChange', "
$('#new_password').complexify({
        minimumChars: '8',
        strengthScaleFactor: '0.4'
    }, function (valid, complexity) {
    if (!valid) {
        $('#pass_progress .bar').css({'width':complexity + '%'}).parent().removeClass('progress-success progress-warning').addClass('progress-danger');
    } else {
        if(complexity <= 70) {
            $('#pass_progress .bar').css({'width':complexity + '%'}).parent().removeClass('progress-danger progress-success').addClass('progress-warning');    
        }
        else {
            $('#pass_progress .bar').css({'width':complexity + '%'}).parent().removeClass('progress-danger progress-warning').addClass('progress-success');    
        }
    }
});
", CClientScript::POS_READY);
?>
