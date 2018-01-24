<?php
$rbls = 'rbls' . $model->recordid;
$rscore = 'rscore' . $model->recordid;
$aol = 'aol' . $model->recordid;
$rrrs = 'rrrs' . $model->recordid;
?>
<h3 class="toggle" data-toggle="<?php echo $rbls;?>">Real Time Blacklists</h3>
<div id="<?php echo $rbls;?>">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $rblProvider,
        'htmlOptions' => array('class' => 'table'),
        'summaryText' => '',
        'emptyText' => 'No data found',
        'showTableOnEmpty' => false,
        'enableSorting' => true,
        'itemsCssClass' => 'table',
        'pagerCssClass' => 'pagination text-center',
        'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
        'columns' => array(
            array('header' => 'Object', 'name' => 'object'),
            'name' => array(
                'class'=> 'CLinkColumn',
                'header' => 'RBL',
                'labelExpression' => '$data["name"]',
                'urlExpression' => '$data["url"]',
                'id' => 'name',
            ),
            array('header' => 'Outcome', 'value' => 'ucfirst($data["outcome"])', 'cssClassExpression' => '$data["outcss"]', 'name' => 'outcome'),
            array('header' => 'Result', 'name' => 'a'),
            array('header' => 'Description', 'name' => 'txt'),
        ),
    ));
    ?>
</div>

<div class="line"></div>

<h3 class="toggle" data-toggle="<?php echo $rscore;?>">Reputation Scores</h3>
<div id="<?php echo $rscore;?>">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $scoreProvider,
        'htmlOptions' => array('class' => 'table'),
        'summaryText' => '',
        'emptyText' => 'No data found',
        'showTableOnEmpty' => false,
        'enableSorting' => true,
        'itemsCssClass' => 'table',
        'pagerCssClass' => 'pagination text-center',
        'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
        'columns' => array(
            array('header' => 'Object', 'name' => 'object'),
            array('header' => 'ReputationAuthority', 'name' => 'repauth', 'value' => '($data["repauth"]==-1)?"N/A":$data["repauth"]', 'cssClassExpression' => '$data["authcss"]'),
            array('header' => 'SenderScore', 'name' => 'senderscore', 'value' => '($data["senderscore"]==-1)?"N/A":$data["senderscore"]', 'cssClassExpression' => '$data["scorecss"]'),
            array('header' => 'SenderBase', 'name' => 'senderbase', 'value' => 'ucfirst($data["senderbase"])', 'cssClassExpression' => '$data["basecss"]'),
            array('header' => 'Threat Intelligence', 'name' => 'threatintl', 'cssClassExpression' => '$data["threatcss"]'),
        ),
    ));
    ?>
</div>
<div class="line"></div>

<h3 class="toggle" data-toggle="<?php echo $aol;?>">AOL Reputation</h3>
<div id="<?php echo $aol;?>">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $aolProvider,
        'htmlOptions' => array('class' => 'table table-striped'),
        'summaryText' => '',
        'emptyText' => 'No data found',
        'showTableOnEmpty' => false,
        'enableSorting' => true,
        'itemsCssClass' => 'table table-striped',
        'pagerCssClass' => 'pagination text-center',
        'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
        'columns' => array(
            array('header' => 'IP Address', 'name' => 'ip'),
            array('header' => 'Reputation', 'name' => 'reputation'),
        ),
    ));
    ?>
</div>
<div class="line"></div>
<h3 class="toggle" data-toggle="<?php echo $rrrs;?>">RoadRunner Reputation</h3>
<div id="<?php echo $rrrs;?>">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $rrProvider,
        'htmlOptions' => array('class' => 'table table-striped'),
        'summaryText' => '',
        'emptyText' => 'No data found',
        'showTableOnEmpty' => false,
        'enableSorting' => true,
        'itemsCssClass' => 'table table-striped',
        'pagerCssClass' => 'pagination text-center',
        'pager' => array('class' => 'CLinkPager', 'header' => '', 'maxButtonCount' => 15, 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'prevPageLabel' => '<', 'nextPageLabel' => '>', 'selectedPageCssClass' => 'active', 'htmlOptions' => array('class' => 'pagination')),
        'columns' => array(
            array('header' => 'IP Address', 'name' => 'ip'),
            array('header' => 'ReturnPath Reputation Network Blacklist', 'name' => 'return'),
            array('header' => 'Spamhaus ZEN Blacklist', 'name' => 'zen'),
            array('header' => 'RoarRunner Blocklist', 'name' => 'block'),
            array('header' => 'RoadRunner Internal Name-Based Block', 'name' => 'international'),
            array('header' => 'FBL Enrollment', 'name' => 'fbl'),
            array('header' => 'SenderScore', 'name' => 'score'),
        ),
    ));
    ?>
</div>
<?php
if ($model->slaves) {
?>
<div>
    <div class="text-right">
        <a href="javascript:void(0)" id="toggle_slaves" class="btn btn-block btn-danger">View With Slaves</a>
    </div>
</div>
<div id="slaves">
<?php
    foreach ($model->slaves as $slave) {
        $this->renderPartial('/shared/platforms/reputation', $slave);
    }

    Yii::app()->clientScript->registerScript('toggle_slaves', "
    $('#toggle_slaves').click(function(){
        var slaves = $('#slaves');
        slaves.toggle();
        var val = $(this).html();
        if(val=='View With Slaves') $(this).html('View W/O Slaves');
        else $(this).html('View With Slaves');
    });
    $('#slaves').hide();
    ");
?>
</div>
<?php
}
?>
<?php
Yii::app()->clientScript->registerScript('toggle', "
$('.toggle').click(function(){
    id=$(this).attr('data-toggle');
    $('#'+id).toggle();
    if($(this).hasClass('toggle_expand')) {
        $(this).addClass('toggle_collapse');
        $(this).removeClass('toggle_expand');
    }
    else {
        $(this).addClass('toggle_expand');
        $(this).removeClass('toggle_collapse');
    }
});
");
?>
