<?php
/* @var $this ApiController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Platform API Settings' => '',
);
?>
<h1>Platform API for "<?=$model->domainname;?>"</h1>
<?php
$this->renderPartial('_subnav', array('model' => $model));
?>
<div>
<form>

    <div class="row">
        <label class="required">API Key: </label>
        <div style="float: left"><strong><?=$key;?></strong></div>
    </div>
    <div class="row">
        <label class="required">API URL: </label>
        <div style="float: left"><strong>http://www.<?=$model->domainname;?>/api/index.php</strong></div>
    </div>
    
    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::link('Download API Instructions', $this->createAbsoluteUrl('/members/platform/api/platformdoc', array('id' => $model->recordid)), array('class' => 'btn btn-info', 'target' => '_blank')); ?>
        </div>
    </div>
        
</form>    
</div>
