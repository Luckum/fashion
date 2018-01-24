<?php
/* @var $this SupportController */
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Support'=>array('/members/platform/support/index', 'id' => $model->recordid),
    'View Tickets'=>array('/members/platform/support/list', 'id' => $model->recordid),
	'View Ticket # '.$ticket['displayid'] => '',
);
?>
<h1>View Ticket #<?=$ticket['displayid'];?></h1>
<?php
if(Yii::app()->request->getQuery('success', 1) != 1) {
?>
    <div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a>Successfully updated the ticket properties</div>
<?php
}
?>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'ticket-update',
        'enableAjaxValidation'=>false,
        'action'=>CHtml::normalizeUrl(array('/members/platform/support/update', 'id' => $model->recordid, 'ticketid' => $ticket['_attributes']['id'])),
        'htmlOptions' => array('class' => 'form-inline'),
    )); ?>

<div>
    
    <div class="row offset1">
        <div class="span2">
            <?=CHtml::label('Type', 'tickettypeid', array('class' => 'inline'));?>
            <?=CHtml::dropDownList('tickettypeid', $ticket['typeid'], $this->types, array('disabled' => 'disabled', 'class' => 'input-medium'));?>
        </div>
        <div class="span2">
            <?=CHtml::label('Status', 'ticketstatusid', array('class' => 'inline'));?>
            <?=CHtml::dropDownList('ticketstatusid', $ticket['statusid'], $this->statuses, array('class' => 'input-medium'));?>
        </div>
        <div class="span2">
            <?=CHtml::label('Priority', 'ticketpriorityid', array('class' => 'inline'));?>
            <?=CHtml::dropDownList('ticketpriorityid', $ticket['priorityid'], $this->priorities, array('class' => 'input-medium'));?>
        </div>
        <div class="span3" style="padding-top: 8px;"><br>
            <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-info')); ?>
            <?php echo CHtml::button('Post Reply', array('onclick' => "$('#reply').show();", 'class' => 'btn btn-success')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <div>
        <h3><?=$ticket['subject'];?></h3>
    </div>
    <div class="row">
        <div class="span6"><label>Created:</label> <strong><?=date('d F Y h:i A', $ticket['creationtime']);?></strong></div>
        <div class="span5"><label>Updated:</label> <strong><?=date('d F Y h:i A', $ticket['lastactivity']);?></strong></div>
    </div>
    
    <div id="reply" style="display: none;" class="alert alert-warning">
        <a class="close" href="javascript:void(0)" onclick="$('#reply').hide();">&times;</a>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'ticket-post',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'action'=>CHtml::normalizeUrl(array('/members/platform/support/view', 'id' => $model->recordid, 'ticketid' => $ticket['_attributes']['id'])),
    )); ?>    
        <div class="row">
            <?php echo CHtml::label('Message', 'contents'); ?>
            <?php echo CHtml::textArea('contents', '', array('class'=>'input-xxlarge', 'rows' => 7)); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Upload File(s)', 'Platforms[files][]'); ?>
<?php
  $this->widget('CMultiFileUpload', array(
     'model'=>$model,
     'attribute'=>'files',
  ));
?>        
        </div>        
        <div class="row offset2">
            <br />
            <?php echo CHtml::submitButton('Send', array('class' => 'btn btn-primary')); ?>
        </div>
<?php $this->endWidget(); ?>    
    </div>
    <?php
    $posts = $ticket['posts'][0]['post'];
    for($i = 0; $i < count($posts); $i++) {
?>
        <div class="ticket-post alert <?=($posts[$i]['userid']==0?'alert-success':'alert-info');?>">
            <div class="span2">
            <strong><?=$posts[$i]['fullname'] . '<br/> ('.($posts[$i]['userid']!=0?'user':'staff').')';?></strong>
            </div>
            <div class="span8">
                <h4 class="text-right">Posted on <?=date('d F Y h:i A', $posts[$i]['dateline']);?></h4>
                <div class="span8 MultiFile-list">
                <?php 
            for($j = 0; $j < count($files); $j++) {
                if($files[$j]['ticketpostid'] == $posts[$i]['id']) {
                ?>
                    <div class="MultiFile-label"><a href="<?=CHtml::normalizeUrl(array('/members/platform/support/download', 'id' => $model->recordid, 't' => $ticket['_attributes']['id'], 'a' => $files[$j]['id']));?>"><?=$files[$j]['filename'];?> (<?=UtilsHelper::bytesToSize($files[$j]['filesize']);?>)</a></div>
                <?php                
                }
            }
                ?>
                </div>
                <div class="span8 ticket-post">
                <?=nl2br($posts[$i]['contents']);?>
                </div>
            </div>
        </div>
    <?php
    } 
    ?>
</div>