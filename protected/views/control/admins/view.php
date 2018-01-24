<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('/control/index'),
     $model->username => ''
);
?>

<h1><?=Yii::t('base', 'View User');?> "<?php echo CHtml::encode($model->username); ?>"</h1>
<form>
<br />
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'tagName' => 'div',
    'itemTemplate' => '<div class="row"><label>{label}:</label> <strong>{value}</strong></div>',
	'attributes'=>array(
		'username',
		'email:email',
        'last_login:datetime'
	),
)); ?>
</form>
<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Change Password'), array('/control/admins/changePassword', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Change Email'), array('/control/admins/changeEmail', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
    </div>
</div>
