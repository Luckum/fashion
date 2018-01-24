<?php
/* @var $this UploadController */
$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Upload Data' => array('/members/platform/upload/', 'id' => $model->recordid)
);
?>
<h1>Upload Data to "<?=$model->domainname;?>"</h1>
<?php $this->renderPartial('_subnav', array('model' => $model, 'active' => true)); ?>
<div>
    <h3>Processing Upload</h3>    
    <div class="alert alert-success center" align="center" id="wrapper">
        <div id="details">Your file successfully uploaded and scheduled for processing. You can check status of the file at <?php echo CHtml::link('"Upload History"', $this->createAbsoluteUrl('/members/platform/upload/history', array('id' => $model->recordid))); ?> tab.</div>
    </div>
</div>
