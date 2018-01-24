<div class="row">
<div class="span6 offset6">
<form id="filterAll" onsubmit="return false;">
    <?php echo CHtml::activeLabelEx($remediation, 'search'); ?>
    <?php echo CHtml::activeTextField($remediation, 'search'); ?>
</form>
</div>

</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $remediation->search(),
    'htmlOptions' => array('class' => 'table table-striped'),
    'summaryText' => '',
    'filterSelector' => '#filterAll',
    'emptyText' => 'No data found',
    'showTableOnEmpty' => false,
    'enableSorting' => true,
    'itemsCssClass' => 'table table-striped',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),    
    'columns' => array(
        'ip',
        'isp',
        'blockeddate:datetime:Date Blocked',
        'date:datetime',
        'user.fullname::Remediated By',
    ),
));
