<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Users') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#brand-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Users');?></h1>

<p>
    <?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New User'), array('/control/users/create'), array('class' => 'btn btn-primary')); ?>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
echo '<h4>Customer\'s table</h4>';
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/users/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        'username',
        'email',
        'registration_date',
        array('name' => 'status', 'value' => '$data->getStatusName()'),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
));
?>

<?php
echo '<h4>Vendor\'s table</h4>';
//$model->type = 'Vendor';
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'vendor-grid',
    'dataProvider'=>$sellerModel->search(),
    //'filter'=>$sellerModel,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'rowHtmlOptionsExpression'=>'array("data-id"=>$data->user_id)',
    'columns'=>array(
        'user_id',
        'username',
        'userEmail',
        'registrationDate',
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url'=>'Yii::app()->createUrl("control/users/update", array("id"=>$data->user_id))',
                    'label'=>Yii::t("base", "Update"),
                ),
                'delete' => array(
                    'url'=>'Yii::app()->createUrl("control/users/delete", array("id"=>$data->user_id))',
                    'label'=>Yii::t("base", "Delete"),
                ),
            ),
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
));
?>

<script>
    $('#vendor-grid').on('click', 'table tbody tr', function()
    {
        var vendorID = $(this).attr("data-id");
        window.location ="<?=Yii::app()->createUrl('control/users/view')?>/"+vendorID;
    });
</script>
