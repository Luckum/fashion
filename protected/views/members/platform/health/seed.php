<?php
/* @var $this HealthController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Seed Delivery Monitoring' => '',
);
?>
<h1>Seed Delivery Monitoring for "<?=$model->domainname;?>"</h1>

<?php
$this->renderPartial('_subnav', array('model' => $model));
?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'htmlOptions' => array('class' => 'table'),
    'summaryText' => '',
    'emptyText' => 'No data found',
    'showTableOnEmpty' => false,
    'enableSorting' => true,
    'itemsCssClass' => 'table',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),    
    'columns' => array(
        array('name' => 'provider', 'value' => 'ucfirst($data->provider)') ,
        array('name' => 'status', 'cssClassExpression' => '$data->status=="failed"?"alert-error":($data->status=="spam"?"alert warning":"alert-success")') ,
//        array('header' => 'Date', 'name' => 'datechecked'),        
        array(
            'class' => 'CBootstrapLinkColumn',
            'header' => 'Details',
            'labelExpression' => '$data->status!="failed"?"Details":""',
            'linkHtmlOptions' => array(
                'class' => 'details',
                'data-toggle' => '"popover"',
                'data-title' => '"From: ".$data->from',
                'data-content' => '"Subject: ".$data->subject',
                'data-trigger' => '"hover"',
                'data-placement' => '"top"', 
            ),
        ),

        
    ),
));


Yii::app()->clientScript->registerScript('popover', "
$('.details').popover();
");
