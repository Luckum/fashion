<?php
/* @var $this HygieneController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Data Hygiene' =>array('/members/platform/hygiene/index', 'id' => $model->recordid),
    'SiftLogic' => '',
);
?>
<h1>Data Hygiene :: SiftLogic</h1>
<?php $this->renderPartial('_subnav', array('model' => $model)); ?>

<?php
if($message != '') {
?>
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert" href="#">&times;</a>
    <?=$message;?>
</div>
<?php
}
?>
<div class="text-left span3">Credits available: <?=$api->credits;?></div> 
<div class="text-right btn-toolbar">
<?php 

    if($api->credits > 0) {
        $link_bulk = "showFrame('upload')";
        $link_single = "showFrame('single')";
    }
    else {
        $link_bulk = 'alert("No Credits Available")';
        $link_single = 'alert("No Credits Available")';
    }
    echo CHtml::link('API Settings', $this->createAbsoluteUrl('/members/platform/hygiene/slsettings', array('id' => $model->recordid)), array('class' => 'btn btn-primary'));
    echo CHtml::link('Check Single Email', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => $link_single));
    echo CHtml::link('Upload New File', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => $link_bulk));
?>
</div>
<?php
if($api->error != '') {
?>
<div class="alert alert-error text-center"><strong>API ERROR: </strong><?=$api->error;?></div>
<?php    
}
else {
    if($api->credits > 0) {
?>
<div>
    <div style="display: none" id="upload" class="alert alert-success">
        <a class="close" href="javascript:void(0)" onclick="$('#upload').hide();">&times;</a>
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'file-upload',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'action'=>CHtml::normalizeUrl(array('/members/platform/hygiene/siftupload', 'id' => $model->recordid)),
//        'htmlOptions' => array('class' => 'form-inline'),
    )); ?>        
        <div>
        <p>The file being uploaded must be a correctly formatted Comma Separated Value file (CSV). At a minimum Email is required. We suggest including CAN-SPAM required fields. 
        <?php echo CHtml::link('File format rules', '#rules', array('data-toggle' => 'modal', 'role' => 'button', 'data-target' => '#rules')); ?>
        </p>
        <?php echo CHtml::label('File: ', 'upload_file');?> 
        <?php echo CHtml::fileField('upload_file', '', array('accept' => '.csv,applicaton/csv')); ?>
        <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-success')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div id="rules" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="rulesHeader" aria-hidden="true" data-remote="<?=Yii::app()->createUrl('/members/platform/hygiene/siftrules/');?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="rulesHeader">File Format Rules</h3>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<div>
    <div id="single" style="display: none;" class="alert alert-success">
        <a class="close" href="javascript:void(0)" onclick="$('#single').hide();">&times;</a>
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'single-email',
        'enableAjaxValidation'=>false,
        'action'=>CHtml::normalizeUrl(array('/members/platform/hygiene/siftverify', 'id' => $model->recordid)),
        'htmlOptions' => array('class' => 'form-inline'),
    )); ?>
        <div class="content">
            <div class="row">
                <div class="span1"></div>
                <div class="span7">
            <?php echo CHtml::label('Email: ', 'email'); ?>
            <?php echo CHtml::textField('email', ''); ?>
            <?php echo CHtml::link('Verify', '', array('onclick' => 'verify("sift")', 'class' => 'btn btn-success')); ?>
                
                </div>
                <div class="span3"></div>
                <div class="span4" id="result"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php 
    }
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'htmlOptions' => array('class' => 'table table-striped'),
        'summaryText' => '',
        'emptyText' => '',
        'showTableOnEmpty' => false,
        'itemsCssClass' => 'table table-striped',
        'pagerCssClass' => 'pagination text-center',
        'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),    
        'columns' => array(
            'filename',
            array('name' => 'createddate', 'value' => 'date(\'d F Y H:i:s\', strtotime($data->createddate))'),
            array('name' => 'status', 'value' => 'ucfirst($data->status)'),
            array(
                'class' => 'CButtonColumn',
                'header' => 'Actions',
                'template' => '{download} {delete}',
                'buttons' => array( 
                    'download' => array(
                        'label' => 'Download',
                        'url' => 'Yii::app()->createUrl("/members/platform/hygiene/siftdownload", array("id" => $this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid))',
                        'visible' => '$data->status=="complete"',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'url' => 'Yii::app()->createUrl("/members/platform/hygiene/siftdelete", array("id" => $this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid))',
                        'visible' => '$data->status=="complete"',
                        'imageUrl' => false,
                    ),
                ),
            ),
        )
    ));

    Yii::app()->clientScript->registerScriptFile('/js/hygiene.js', CClientScript::POS_END); 
}
?>
