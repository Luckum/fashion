<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'platforms-create-form',
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', null, array('class'=>'alert alert-error')); ?>
    <div class="row">
        <div class="span6">
            <div class="row">
                <?php echo $form->labelEx($model,'domainname'); ?>
                <?php echo $form->textField($model,'domainname'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'phonenumber'); ?>
                <?php echo $form->textField($model,'phonenumber'); ?>
                <!-- span class="text-info"><small>+1(111) 111-1111</small></span -->
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'notes'); ?>
                <?php echo $form->textArea($model,'notes', array('rows' => 3)); ?>
            </div>
<?php
if($model->isNewRecord) {
?>
            <div class="row">
                <?php echo $form->labelEx($model, 'iptype'); ?>
                <?php echo $form->checkBox($model, 'iptype', array('onclick' => '$("#range").toggle()', 'checked' => 'checked', 'value' => 'own', 'uncheckValue' => 'paid')); ?>
            </div>
<?php
}
if(!Yii::app()->client->isGuest && Yii::app()->client->recordid == $model->clientid && ($model->isNewRecord || $model->iptype == 'own')) {
?>
            <div class="row" id="range">
                <?php echo $form->labelEx($model,'iprange'); ?>
                <?php echo $form->textField($model,'iprange'); ?>
            </div>
<?php
}
if(!Yii::app()->staff->isGuest && Yii::app()->staff->level=='admin') {
?>
            <div class="row">
                <?php echo $form->labelEx($model,'parentid'); ?>
                <select name="Platforms[parentid]" id="Platforms_parentid">
                <?php 
                $options = array('prompt' =>'Choose One');
                echo CHtml::listOptions($model->parentid, CHtml::listData(Platforms::model()->findAllByAttributes(array('clientid' => $model->clientid, 'parentid' => null)), 'recordid', 'domainname'), $options); ?>
                </select>                
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'ipid'); ?>
                <select name="Platforms[ipid]" id="Platforms_ipid">
                <?php 
                $options = array('prompt' =>'Choose One');
                echo CHtml::listOptions($model->ipid, CHtml::listData(IPs::model()->findAll(), 'recordid', function($ip) { return $ip->value.' '.$ip->displayPlatformList(); }, function($ip) {return $ip->server->ip . ' - ' . $ip->server->name; }), $options); ?>                
                </select>
            </div>

            <div class="row">
                <?php echo CHtml::label('IP Ranges', ''); ?>
                <select name="ranges_select" id="ranges_select">
                <?php 
                $options = array('prompt' =>'Choose One');
                echo CHtml::listOptions('', CHtml::listData(IpRanges::model()->findAll("status = 'up' AND deleted = false"), 'recordid', function($range) {return $range->iface->name. ' - ' . $range->displayRange() . $range->displayPlatforms(); }, function($range) {return $range->iface->tunnel->name; }), $options); ?>
                </select> &nbsp;
                <?php echo CHtml::link('Add', 'javascript:void()', array('onclick' => 'addRange()')); ?>
                <div id="ranges" style="margin-left: 180px; margin-bottom: 10px">
            <?php
            $js_text = '';
            for($i = 0; $i < count($model->ranges); $i++) {
                echo '<div><input type="hidden" name="ranges[]" value="'.$model->ranges[$i]->recordid.'" /><strong>'.$model->ranges[$i]->displayRange().'</strong> &nbsp; <a href="javascript:void()" onclick="removeRange(this, '.$model->ranges[$i]->recordid.')">x</a></div>';
                $js_text .= 'ranges['.$i.'] = ' . $model->ranges[$i]->recordid . ";\r\n";
            }
            ?>
                </div>
            </div>
            
<?php
/*
?>            
            <div class="row">
                <?php echo $form->labelEx($model,'rangeid'); ?>
                <select name="Platforms[rangeid]" id="Platforms_rangeid">
                <?php 
                $options = array('prompt' =>'Choose One');
                echo CHtml::listOptions($model->rangeid, CHtml::listData(IpRanges::model()->findAll(), 'recordid', function($range) {return $range->displayRange();}, function($range) {return $range->iface->tunnel->ip; }), $options); ?>
                </select>
            </div>
<?php
*/
    if(!$model->isNewRecord) {
?>            
            <div class="row">
                <?php echo $form->labelEx($model,'price'); ?>
                <?php echo $form->textField($model,'price', array('class' => 'input-small')); ?> USD
            </div>
<?php
    }
?>
            <div class="row">
                <?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status', array('active' => 'active', 'suspended' => 'suspended', 'deleted' => 'deleted')); ?> 
            </div>
            
            <div class="row">
                <?php echo $form->labelEx($model,'version'); ?>
                <?php echo $form->textField($model,'version'); ?>
            </div>
<?php
}
?>
        </div>
        <div class="span5">
            <h5>Can-Spam Address</h5>
            <hr />
            <div class="row">
                <?php echo $form->labelEx($model,'canspamaddress1'); ?>
                <?php echo $form->textField($model,'canspamaddress1'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'canspamaddress2'); ?>
                <?php echo $form->textField($model,'canspamaddress2'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'canspamcity'); ?>
                <?php echo $form->textField($model,'canspamcity'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'canspamstate'); ?>
                <?php echo CHtml::textField('state', $model->canspamstate); //$form->textField($model,'canspamstate'); ?>
            </div>
            
            <div class="row">
                <?php echo $form->labelEx($model,'canspampostcode'); ?>
                <?php echo $form->textField($model,'canspampostcode'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'canspamcountry'); ?>
                <?php echo CHtml::dropDownList('country', $model->canspamcountry, Yii::app()->params['countries']); //$form->dropDownList($model,'canspamcountry', Yii::app()->params['countries']); ?>
            </div>
        </div>
        
    </div>
    
<?php
if(!Yii::app()->staff->isGuest && Yii::app()->staff->level == 'admin') {
    if(!$model->isNewRecord) 
    {
        $this->renderPartial('/shared/history', array('model' => $model));
    }
    else 
    {
        echo CHtml::label('Create Invoice <span class="required">*</span>', 'createinvoice', array('class' => 'required')) . CHtml::checkBox('createinvoice', true);    
    }
}
?>    
    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/statesdropdown.js', CClientScript::POS_END);  ?>

<?php
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
