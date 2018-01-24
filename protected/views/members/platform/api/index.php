<?php
/* @var $this ApiController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Optimus API Settings' => '',
);
?>
<h1>Optimus API for "<?=$model->domainname;?>"</h1>
<?php
$this->renderPartial('_subnav', array('model' => $model));
?>
<div>
<?php
if($saved) {
?>
<div class="alert alert-success"><a href="#" data-dismiss="alert" class="close">&times;</a>
Changes has been successfully saved.
</div>
<?php  
}
?>

<form method="post">

    <div class="row">
        <?php echo CHtml::label('API Status: ', ''); ?>
        <div class="btn-group" data-toggle="buttons-radio">
            <button id="btnon" class="btn<?=($model->apikey!='')?' active':'';?>" type="button" onclick="location.href='/members/platform/api/index/id/<?=$model->recordid;?>/toggle/on'">ON</button>
            <button id="btnoff" class="btn btn-danger<?=($model->apikey=='')?' active':'';?>" type="button" onclick="location.href='/members/platform/api/index/id/<?=$model->recordid;?>/toggle/off'">OFF</button>
        </div>
    </div>
    
<?php
if($model->apikey != '') {
    $settings = unserialize($model->apisettings);
?>

    <div class="row">
        <?php echo CHtml::label('API Key: ', ''); ?>
        <div><strong><?=$model->apikey;?></strong></div>
    </div>
    <div class="row">
        <?php echo CHtml::label('API URL: ', ''); ?>
        <div><strong>http://<?php echo $_SERVER['SERVER_NAME'] . Yii::app()->getHomeUrl();?>api/</strong></div>
    </div>
    <h4>Verify Data on Upload</h4>
    <div class="row">
        <?php echo CHtml::label('With SiftLogic: ', ''); ?>
            <input type="radio" name="Settings[verifysl]" value="yes"<?=($settings['verifysl']=='yes')?' checked':'';?> onclick="$('#sl_level').show()" /> Yes
            <input type="radio" name="Settings[verifysl]" value="no"<?=($settings['verifysl']!='yes')?' checked':'';?> onclick="$('#sl_level').hide()" /> No
    </div>
    <div class="row" id="sl_level"<?=($settings['verifysl']!='yes')?' style="display: none"':'';?>>
        <?php echo CHtml::label('Only add emails with: ', ''); ?>
        <?php echo CHtml::dropDownList('Settings[levelsl]', $settings['levelsl'], array('low' => 'All', 'middle' => 'Middle, High', 'high' => 'High')); ?>
        Score(s)
        
    </div>
    <div class="row">
        <?php echo CHtml::label('With ImpressionWise: ', ''); ?>
            <input type="radio" name="Settings[verifyiw]" value="yes"<?=($settings['verifyiw']=='yes')?' checked':'';?> /> Yes
            <input type="radio" name="Settings[verifyiw]" value="no"<?=($settings['verifyiw']!='yes')?' checked':'';?> /> No
    </div>
    
    

    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary'));?>
            <?php echo CHtml::link('Download API Instructions', $this->createAbsoluteUrl('/members/platform/api/apidoc', array('id' => $model->recordid)), array('class' => 'btn btn-info', 'target' => '_blank')); ?>
        </div>
    </div>
<?php
}
?>        
        
</form>    
</div>
