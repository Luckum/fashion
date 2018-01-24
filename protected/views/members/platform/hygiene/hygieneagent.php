<?php
/* @var $this HygieneController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Manage Platforms'=>array('/members/platforms'),
    $model->domainname=>array('/members/platforms/view', 'id' => $model->recordid),
    'Data Hygiene' =>array('/members/platform/hygiene/index', 'id' => $model->recordid),
    'HygieneAgent' => '',
);
?>
<h1>Data Hygiene :: HygieneAgent</h1>
<?php $this->renderPartial('_subnav', array('model' => $model)); ?>