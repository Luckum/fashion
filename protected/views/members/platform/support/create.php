<?php
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Support'=>array('/members/platform/support/index', 'id' => $model->recordid),
	'Submit Ticket' => '',
);
?>
<div>
    <h1>Create New Ticket</h1>
    <p>Enter your ticket details below. If you are reporting a problem, please remember to provide as much information that is relevant to the issue as possible.</p>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'ticket-create-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
//        ''
    )); ?>

<?php echo $form->errorSummary($this->api, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', null, array('class'=>'alert alert-error')); ?>
    
    <div class="row">
        <div class="row">
            <?php echo CHtml::label('Priority', 'ticketpriorityid'); ?>
            <?php echo CHtml::dropDownList('ticketpriorityid', $data['ticketpriorityid'], $this->priorities); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Type', 'tickettypeid'); ?>
            <?php echo CHtml::dropDownList('tickettypeid', $data['tickettypeid'], $this->types); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Subject', 'subject'); ?>
            <?php echo CHtml::textField('subject', $data['subject'], array('class' => 'input-xxlarge')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('Message', 'contents'); ?>
            <?php echo CHtml::textArea('contents', $data['contents'], array('class'=>'input-xxlarge', 'rows' => 5)); ?>
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
    </div>
        
    <div class="form-actions buttons">
        <div class="offset2">
            <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('Cancel', $this->createAbsoluteUrl('/members/platform/support/index', array('id' => $model->recordid)), array('class' => 'btn')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
