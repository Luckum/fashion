<?php
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Support' => '',
);
?>

    <h1>Support Request</h1>

<div>

<br />
    
    <div class="row">
        <div class="span6" align="center">
            <?php echo CHtml::link('Submit a Ticket', $this->createAbsoluteUrl('/members/platform/support/create/', array('id' => $model->recordid)), array('class' => 'btn-large btn-warning')); ?>
        </div>
        <div class="span5" align="center">
            <?php echo CHtml::link('View Tickets', $this->createAbsoluteUrl('/members/platform/support/list/', array('id' => $model->recordid)), array('class' => 'btn-large btn-success')); ?>
        </div>
        

    </div>
</div>
