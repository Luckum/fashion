<?php
/* @var $this PlatformsController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Upload Data' => array('/client s/platforms/upload/index', 'id' => $model->recordid),
    'History' => ''
);
?>

<h1>Upload Data to "<?=$model->domainname;?>"</h1>
<?php $this->renderPartial('_subnav', array('model' => $model, 'active' => false)); ?>
<div>
    <div class="text-right">
    <?php echo CHtml::link('Clear Completed', $this->createAbsoluteUrl('/members/platform/upload/history', array('id' => $model->recordid, 'act' => 'clearAll')), array('class' => 'btn btn-info')); ?>
    </div>
</div>
<br />
<div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id' => 'data-uploads',
    'enableSorting' => true,
    'summaryText' => '',
    'emptyText'=> 'No Uploads',
    'showTableOnEmpty' => false,    
    'itemsCssClass' => 'table table-striped smaller',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
    'columns' => array(
        'filename',
        'respondername',
        'status',
        'processed',
        'failed',
        'uploadeddate:datetime',
        array(
            'name' => 'completeddate',
            'type' => 'datetime',
            'value' => '$data["completeddate"]=="0000-00-00"?"N/A":$data["completeddate"]',
        ),
//        'completeddate:datetime',
        array(
            'header' => 'Actions',
            'headerHtmlOptions' => array('style' =>'width: 40px;'),
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'label' => '',
                    'options' => array(
                        'class' => 'icon icon-remove',
                        'title' => 'remove from list',
                        'alt' => 'remove from list',
                    ),
                    'imageUrl' => false,
                    'visible' => '$data->status=="completed"',
                    'url' => 'array("", "id" => '.$model->recordid.', "act" => "delete", "uid" => $data->recordid)',
                ),
            ),
            
        ),
    ),
    'htmlOptions' => array('class' => 'table table-stripped')
));
?>
</div>
