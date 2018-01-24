<?php
/* @var $this PlatformsController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
	'Manage Platforms' => '',
);
?>
<div>
    <h1>Manage Platforms</h1>
    <div class="row">
        
        <div class="span2 offset9"><?=CHtml::link('Add New Platform', $this->createAbsoluteUrl('/members/platforms/create'), array('class' => 'btn btn-primary'));?></div>
    </div>
    <h4>Manage Existing Platforms</h4>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id' => 'data-patforms',
    'enableSorting' => true,
    'summaryText' => '',
    'emptyText'=> 'You have no platforms setup yet. Please <a href="/members/platforms/create">click here</a> to add a new platform',
    'showTableOnEmpty' => false,    
    'itemsCssClass' => 'table table-striped',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
    'columns' => array(
        'recordid',
        'domainname',
        array(
            'value' => 'strtoupper($data->status)',
            'name' => 'status',
        ),
        array(
            'header' => 'Ready',
            'value' => '$data->rdns!=""?"Yes":"No"',
            'name' =>'rdns',
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn', 
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'label' => 'Manage',
                    'imageUrl' => false,
                    'visible' => '$data->status=="active"',
                ),
            ),
        ),
    ),
    'htmlOptions' => array('class' => 'table table-stripped')
));
?>
</div>
