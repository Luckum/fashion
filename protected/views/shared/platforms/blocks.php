<?php
$filterAll = 'filterAll' . $model->recordid;
?>
<?php
if ($model->childrens) {
?>
<div class="row">
    <div class="text-right">
    <div class="toggle_slaves">
<?php
    if ($slaves) {
        echo '<a href="' . CController::createUrl('',array(
            'id' => $model->recordid,
            'date' => $date
        )) . '" id="toggle_slaves" class="btn btn-success">View W/O Slaves</a>';
    } else {
        echo '<a href="' .  CController::createUrl('',array(
            'id' => $model->recordid,
            'date' => $date,
            'slaves' => 'slaves',
        )) . '" id="toggle_slaves" class="btn btn-success">View With Slaves</a>';
    }
?>
    </div>
    </div>
</div>
<?php
}
?>
<div class="row">
<form id="<?php echo $filterAll;?>" onsubmit="return false;">
<div class="span6 offset6">
    <?php echo CHtml::activeLabelEx($blocks, 'search'); ?>
    <?php echo CHtml::activeTextField($blocks, 'search'); ?>
</div>
</form>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $blocks->search(),
    'htmlOptions' => array('class' => 'table table-striped'),
    'summaryText' => '',
    'filterSelector' => '#' . $filterAll,
    'emptyText' => 'No data found',
    'showTableOnEmpty' => false,
    'enableSorting' => true,
    'itemsCssClass' => 'table table-striped',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
    'columns' => array(
        'blockeddate:datetime',
        'ip',
        'isp',
        array(
            'name' => 'recipients',
            'value' => 'nl2br($data->recipients)',
            'type' => 'html',
        ),
        'message:html'
    ),
));
?>

