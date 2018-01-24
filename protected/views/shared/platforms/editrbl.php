<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'platforms-create-form',
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', null, array('class'=>'alert alert-error')); ?>
    <div class="row">
        <div class="span6">
            <h4>RBL Info</h4>
            <hr />
            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanyname'); ?>
                <?php echo $form->textField($model,'rblcompanyname'); ?>
                <!-- span class="text-info"><small>+1(111) 111-1111</small></span -->
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanyrole'); ?>
                <?php echo $form->textField($model,'rblcompanyrole'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanyphone'); ?>
                <?php echo $form->textField($model,'rblcompanyphone'); ?>
            </div>
        </div>
        <div class="span5">
            <h4>RBL Address</h4>
            <hr />
            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanyaddress1'); ?>
                <?php echo $form->textField($model,'rblcompanyaddress1'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanyaddress2'); ?>
                <?php echo $form->textField($model,'rblcompanyaddress2'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanycity'); ?>
                <?php echo $form->textField($model,'rblcompanycity'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanystate'); ?>
                <?php echo CHtml::textField('state', $model->rblcompanystate); //$form->textField($model,'canspamstate'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanypostcode'); ?>
                <?php echo $form->textField($model,'rblcompanypostcode'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'rblcompanycountry'); ?>
                <?php echo CHtml::dropDownList('country', $model->rblcompanycountry, Yii::app()->params['countries']); //$form->dropDownList($model,'canspamcountry', Yii::app()->params['countries']); ?>
            </div>
        </div>

        <div class="span11">
            <h4>RBL URLs</h4>
            <div class="row">
                <?php echo $form->labelEx($model,'rblwebsite'); ?>
                <?php echo $form->textField($model,'rblwebsite', array('class' => 'input-xxlarge')); ?>
                <br /><span class="smaller text-success"> e.g. http://www.mysite.com</span><br /><br />
            </div>
            <div class="row">
               <?php echo $form->labelEx($model,'rblprivacypolicyurl'); ?>
               <?php echo $form->textField($model,'rblprivacypolicyurl', array('class' => 'input-xxlarge')); ?>
               <br /><span class="smaller text-success"> e.g. http://www.mysite.com/privacy-policy.html</span><br /><br />
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'rblantispampolicyurl'); ?>
                <?php echo $form->textField($model,'rblantispampolicyurl', array('class' => 'input-xxlarge')); ?>
                <br /><span class="smaller text-success"> e.g. http://www.mysite.com/antispam.html</span><br /><br />
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'rblunsubscribeurl'); ?>
                <?php echo $form->textField($model,'rblunsubscribeurl', array('class' => 'input-xxlarge')); ?>
                <br /><span class="smaller text-success"> e.g. http://www.mysite.com/unsubscribe-now.php</span><br /><br />
            </div>

        </div>

    </div>


    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/statesdropdown.js', CClientScript::POS_END);  ?>

<?php
if (!isset($js_text)) $js_text = '';
Yii::app()->clientScript->registerScript('', "
var ranges=[];
$js_text

function addRange() {
    value = parseInt($('#ranges_select').val());
    if(value!='' && ranges.indexOf(value) == -1) {
        $('#ranges').append('<div><input type=\"hidden\" name=\"ranges[]\" value=\"'+$('#ranges_select').val()+'\" /><strong>'+$('#ranges_select option:selected').text()+'</strong> &nbsp; <a href=\"javascript:void()\" onclick=\"removeRange(this, '+value+')\">x</a></div>');
        ranges[ranges.length] = value;
    }
}

function removeRange(link, value) {
    link.parentNode.remove();
    ranges[ranges.indexOf(value)] = null;
}


", CClientScript::POS_BEGIN);
