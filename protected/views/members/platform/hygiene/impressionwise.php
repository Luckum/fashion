<?php
/* @var $this HygieneController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Data Hygiene' =>array('/members/platform/hygiene/index', 'id' => $model->recordid),
    'ImpressionWise' => '',
);

?>
<h1>Data Hygiene :: ImpressionWise</h1>
<?php $this->renderPartial('_subnav', array('model' => $model)); ?>

<?php
if($error === 'true') {
?>
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert" href="#">&times;</a>
    File Upload Error
</div>
<?php
}
?>

<div class="text-right btn-toolbar">
<?php
echo CHtml::link('API Settings', $this->createAbsoluteUrl('/members/platform/hygiene/iwsettings', array('id' => $model->recordid)), array('class' => 'btn btn-primary'));
echo CHtml::link('Check Single Email', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => ($api->error == '') ? "showFrame('single')" : 'alert("API Configuration Error")'));
echo CHtml::link('Upload New File', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => ($api->error == '') ? "showFrame('upload')" : 'alert("API Configuration Error")'));
?>
</div>
<?php
if($api->error != '') {
?>
<div class="alert alert-error text-center"><strong>API ERROR: </strong><?=$api->error;?></div>
<?php
}
else {
?>    
<div>
    <div style="display: none" id="upload" class="alert alert-success">
        <a class="close" href="javascript:void(0)" onclick="$('#upload').hide();">&times;</a>
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'file-upload',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'action'=>CHtml::normalizeUrl(array('/members/platform/hygiene/impressionupload', 'id' => $model->recordid)),
//        'htmlOptions' => array('class' => 'form-inline'),
    )); ?>        
        <div>
        <?php echo CHtml::label('File: ', 'upload_file');?> 
        <?php echo CHtml::fileField('upload_file', '', array('accept' => '.csv,applicaton/csv')); ?>
        <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-success')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div>
    <div id="single" style="display: none;" class="alert alert-success">
        <a class="close" href="javascript:void(0)" onclick="$('#single').hide();">&times;</a>
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'single-email',
        'enableAjaxValidation'=>false,
        'action'=>CHtml::normalizeUrl(array('/members/platform/hygiene/impressionverify', 'id' => $model->recordid)),
        'htmlOptions' => array('class' => 'form-inline'),
    )); ?>
        <div class="content">
            <div class="row">
                <div class="span1"></div>
                <div class="span7">
            <?php echo CHtml::label('Email: ', 'email'); ?>
            <?php echo CHtml::textField('email', ''); ?>
            <?php echo CHtml::link('Verify', '', array('onclick' => 'verify("impression")', 'class' => 'btn btn-success')); ?>
                
                </div>
                <div class="span3"></div>
                <div class="span4" id="result"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php 
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
                'class' => 'CBootstrapButtonColumn',
                'header' => 'Actions',
                'template' => '{download} {delete}',
                'buttons' => array( 
                    'download' => array(
                        'label' => 'Download <span class="caret"></span>',
                        'options' => array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                            'title' => 'Download',
                        ),
                        'visible' => '$data->status=="complete"',
                        'preHTML' => 'CHtml::openTag("div", array("class" => "dropdown"))',
                        'postHTML' => 
                            'CHtml::openTag("ul", array("class" => "dropdown-menu", "role" => "menu")).
                                CHtml::openTag("li").
                                    CHtml::link("Bad Address", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "bad"))).
                                CHtml::closeTag("li").
                                CHtml::openTag("li").
                                    CHtml::link("Clean", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "clean"))).
                                CHtml::closeTag("li").
                                CHtml::openTag("li").
                                    CHtml::link("Full Row", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "fullrow"))).
                                CHtml::closeTag("li").
                                CHtml::openTag("li").
                                    CHtml::link("International", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "int"))).
                                CHtml::closeTag("li").
                                CHtml::openTag("li").
                                    CHtml::link("NetProtect", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "netprot"))).
                                CHtml::closeTag("li").
                                CHtml::openTag("li").
                                    CHtml::link("Reports", Yii::app()->createUrl("/members/platform/hygiene/iwdownload", array("id"=>$this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid, "type" => "reports"))).
                                CHtml::closeTag("li").
                            CHtml::closeTag("ul").
                        CHtml::closeTag("div")',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'url' => 'Yii::app()->createUrl("/members/platform/hygiene/impressiondelete", array("id" => $this->grid->controller->loadModel($_GET["id"])->recordid, "file" => $data->recordid))',
                        'visible' => '$data->status=="complete" || $data->status=="failed"',
                        'imageUrl' => false,
                    ),
                ),
            ),
        )
    ));

    Yii::app()->clientScript->registerScriptFile('/js/hygiene.js', CClientScript::POS_END); 
}
