<?php
/* @var $this HealthController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Reputation' => '',
);
?>
<h1>Reputation for "<?=$model->domainname;?>"</h1>

<?php
$this->renderPartial('_subnav', array('model' => $model));
?>

<?php $this->renderPartial('/shared/platforms/reputation', array('model' => $model,
            'rblProvider' => $rblProvider,
            'scoreProvider' => $scoreProvider,
            'aolProvider' => $aolProvider,
            'rrProvider' => $rrProvider,
            'date' => $date));