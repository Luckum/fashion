<?php

$prev_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
$next_date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
$next_class = 'btn btn-success';
$prev_class = 'btn btn-success';
$next_link = array($controller.$this->action->id, 'id' => $model->recordid, 'date' => $next_date);
$prev_link = array($controller.$this->action->id, 'id' => $model->recordid, 'date' => $prev_date);

if($next_date > date('Y-m-d')) {
    $next_class .= ' disabled';
    $next_link = '';
}
if($prev_date < date('Y-m-d', strtotime($model->createddate))) {
    $prev_class .= ' disabled';
    $prev_link = '';
}
?>
<div id="calendar" class="text-center">
    
    <div class="span3 text-left">
        <?php echo CHtml::link('<< Prev day', $prev_link, array('class' => $prev_class)) ?>
    </div>
    
    <div class="span5 text-center">
        <input type="text" name="datePicker" id="datePicker" value="<?=date('l, j F, Y', strtotime($date));?>" class="datePicker" readonly="readonly">
        <input type="hidden" name="date" id="date" value="<?=date('Y-m-d', strtotime($date));?>" />
    </div>
    
    <div class="span3 text-right">
        <?php echo CHtml::link('Next day >>', $next_link, array('class' => $next_class)) ?>
    </div>
    
</div>

<br />
<br />
<br />
<?php
Yii::app()->clientScript->registerScript('datepicker', "
$('#datePicker').datepicker({
        dateFormat: 'DD, d MM, yy',
        altField: '#date',
        altFormat: 'yy-mm-dd'
    });
    
    $('#datePicker').change(function(){
        location.href='".$controller.$this->action->id."/id/".$model->recordid."/date/'+$('#date').val();
    });
");
?>
