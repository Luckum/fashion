<?php
/* @var $this HealthController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Blocks' => '',
);
?>
<h1>Blocks for "<?=$model->domainname;?>"</h1>

<?php $this->renderPartial('_subnav', array('model' => $model)); ?>

<?php 
$this->renderPartial('/shared/platforms/blocks', array('model' => $model, 'blocks' => $blocks, 'date' => $date)); ?>