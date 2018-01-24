<?php
/* @var $this AttributesController */
/* @var $model Attribute */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Attributes') => array('control/attributes'),
    Yii::t('base', 'Attribute defined values')
);

?>

<h1><?=Yii::t('base', 'Setting values for dropdown lists and checkbox list');?></h1>

<div class="text-right">
    <?php
    echo CHtml::link(Yii::t('base', 'Groups'), array('control/attributeValueGroup/index'), array('class' => 'btn btn-primary'));
    echo '&nbsp;';
    echo CHtml::link(Yii::t('base', 'Add group for defined values'), array('control/attributeValueGroup/create'), array('class' => 'btn btn-primary'));
    echo '&nbsp;';
    echo CHtml::link(Yii::t('base', 'Add defined attribute value(s)'), array('control/attributeValue/create'), array('class' => 'btn btn-primary'));     
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'attribute-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true, 
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){return false;}",
    'columns'=>array(
        'language',
        'value',
        'group.value',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'deleteConfirmation' => Yii::t('base', 'Are you sure you want to delete this item? Attributes having this defined value as selected item for dropdown or checkbox list, may not work correctly!'),
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
)); ?>
