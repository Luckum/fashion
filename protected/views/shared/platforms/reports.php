<?php
$bar_chart_id = 'bar_chart' . $model->recordid;
$pie_chart_id = 'pie_chart' . $model->recordid;
$plot_script_id = 'plot' . $model->recordid;
$toggle_id = 'toggle' . $model->recordid;
$details_id = 'details' . $model->recordid;
?>
<div class="row">
<div id="chart_wrapper" align="center">
    <div id="<?php echo $bar_chart_id;?>" class="bar_chart"></div>
    <div id="<?php echo $pie_chart_id;?>" class="pie_chart"></div>

</div>
</div>
<?php
if(count($total) > 0) {
    Yii::app()->clientScript->registerScript($plot_script_id, "
var plot1 = jQuery.jqplot('" . $pie_chart_id . "', [[['Delivered (" . $total['delivered'] . ")', " . str_replace(',', '', $total['delivered']) . "],['Undeliverables (" . $total['undeliverables'] . ")', " . str_replace(',', '', $total['undeliverables']) . "], ['Blocks (" . $total['blocks'] . ")', " . str_replace(',', '', $total['blocks'])."]]], {
    gridPadding: {top:0, bottom:38, left:0, right:0},
    seriesDefaults:{
        renderer: jQuery.jqplot.PieRenderer ,
        rendererOptions:{
            sliceMargin: 3,
            showDataLabels: true,
        }
    },
    legend:{ show:true }
});

var d1 = [" . str_replace(',', '', $total['size']) . "];
var d2 = [" . str_replace(',', '', $total['scheduled']). "];
var d3 = [" . str_replace(',', '', $total['queued']) . "];
var d4 = [" . str_replace(',', '', $total['sent']) . "];

var plot2 = jQuery.jqplot('" . $bar_chart_id . "', [d1, d2, d3, d4], {
    gridPadding: {top:0, bottom:0, left:0, right:10},
    seriesDefaults:{
        renderer:$.jqplot.BarRenderer,
        rendererOptions: { fillToZero: true },
        pointLabels: { show: true, location: 's', edgeTolerance: -15 },
    },
    series:[
        {label:'Total Size'},
        {label:'Scheduled'},
        {label:'Queued'},
        {label:'Sent'}
    ],
    legend: {
        show: true,
        location: 'ne',
        placement: 'inside'
    },
    axes: {
        xaxis: {
            renderer: $.jqplot.CategoryAxisRenderer,
            ticks: ['']
        },
        yaxis: {
        }
    }
});
    ");
}
else {
    Yii::app()->clientScript->registerScript($plot_script_id, "
$('#" . $pie_chart_id . "').hide();
$('#" . $bar_chart_id . "').hide();
    ");
}
?>
<div>
    <div class="text-right">
<?php
if ($model->childrens) {
?>
    <span class="toggle_slaves">
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
    </span>
<?php
}
?>
        <a href="javascript:void(0)" data-toggle="<?php echo $details_id;?>" class="toggle btn btn-info">Show Details</a>
    </div>
</div>
<br />

<div id="<?php echo $details_id;?>" style="display: none;">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'htmlOptions' => array('class' => 'table table-striped'),
    'summaryText' => '',
    'emptyText' => 'No data found',
    'showTableOnEmpty' => false,
    'enableSorting' => true,
    'itemsCssClass' => 'table table-striped smaller',
    'pagerCssClass' => 'pagination text-center',
    'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
    'columns' => array(
        array('name' => "list", 'header' => 'List'),
        array('name' => "size", 'header' => 'Size', 'value' => 'UtilsHelper::formatNumber($data["size"])'),
        array('name' => "scheduled", 'header' => 'Sched', 'value' => 'UtilsHelper::formatNumber($data["scheduled"])'),
        array('name' => "queued", 'header' => 'Queued', 'value' => 'UtilsHelper::formatNumber($data["queued"])'),
        array('name' => "sent", 'header' => 'Sent', 'value' => 'UtilsHelper::formatNumber($data["sent"])'),
        array('name' => "undeliverables", 'header' => 'Undeliv', 'value' => 'UtilsHelper::formatNumber($data["undeliverables"])'),
        array('name' => "blocks", 'header' => 'Blocks', 'value' => 'UtilsHelper::formatNumber($data["blocks"])'),
        array('name' => "delivered", 'header' => 'Delivered', 'value' => 'UtilsHelper::formatNumber($data["delivered"])'),
        array('name' => "unique_opens", 'header' => 'Opens', 'value' => 'UtilsHelper::formatNumber($data["unique_opens"])'),
        array('name' => "unique_clicks", 'header' => 'Clicks', 'value' => 'UtilsHelper::formatNumber($data["unique_clicks"])'),
        array('name' => "unsubs", 'header' => 'Unsubs', 'value' => 'UtilsHelper::formatNumber($data["unsubs"])'),
    ),
));
?>
</div>
<?php
Yii::app()->clientScript->registerScript('toggle', "
$('.toggle').click(function(){
    var id=$(this).attr('data-toggle');
    $('#'+id).toggle();
    var val = $(this).html();
    if(val=='Show Details') $(this).html('Hide Details');
    else $(this).html('Show Details');
});
");

Yii::app()->clientScript->registerScriptFile('/js/jquery/jqplot/jquery.jqplot.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/jquery/jqplot/plugins/jqplot.pieRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/jquery/jqplot/plugins/jqplot.barRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/jquery/jqplot/plugins/jqplot.categoryAxisRenderer.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/jquery/jqplot/plugins/jqplot.pointLabels.min.js', CClientScript::POS_END);
