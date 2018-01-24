<?php
/* @var $this SupportController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Support'=>array('/members/platform/support/index', 'id' => $model->recordid),
    'View Tickets' => '',
);
?>
<h1>View Tickets</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id' => 'data-tickets',
    'enableSorting' => false,
    'enablePagination' => true,
    'summaryText' => '',
    'emptyText'=> 'There\'s no tickets for this platform',
    'showTableOnEmpty' => false,
    'itemsCssClass' => 'table table-striped',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),    
    'columns' => array(
        'displayid',
        'subject',
        array('name' => 'priorityid', 'value' => '$this->grid->controller->priorities[$data->priorityid]'),
        array('name' => 'statusid', 'value' => '$this->grid->controller->statuses[$data->statusid]'),
        'lastreplier',
        array('name' => 'lastactivity', 'value' => 'date("d F Y h:i A", $data->lastactivity)'),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn', 
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'label' => 'View',
                    'imageUrl' => false,
                    'url' => 'array("/members/platform/support/view/id/$data->platformid/ticketid/$data->kayakoid")',
                ),
            ), 
        ), 
    ),
   'htmlOptions' => array('class' => 'table table-stripped')
));
