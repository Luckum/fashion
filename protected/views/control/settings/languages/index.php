<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Languages Settings') => '',
);

?>

<h1><?=Yii::t('base', 'Languages Settings');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Add Language'), array('/control/settings/languages/create'), array('class' => 'btn btn-primary'));?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'importLang',
        'options'=>array(
            'title'=>Yii::t('base', 'Import Language File'),
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=>'false',
        ),
    ));
$this->endWidget();

$importLangFileDialog =<<<EOT
function() {
    var url = $(this).attr('href');
    $.get(url, function(r){
        $("#importLang").html(r).dialog("open");
    });
    return false;
}
EOT;

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'language-grid',
    'dataProvider' => $dataProvider,
    'enableHistory' => true, 
    'columns'=>array(
        array(
            'name' => Yii::t('base', 'Flag'),
            'type' => 'html',
            'value' => 'CHtml::tag("i", array("class" => "flag-" . $data["prefix"]), "", true)'
        ),
        array(
            'name' => Yii::t('base', 'Prefix'),
            'value' => '$data["prefix"]'
        ),
        array(
            'name'  => Yii::t('base', 'Language'),
            'value' => '$data["name"]' 
        ),
        array(
            'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '15%'),
            'header' => Yii::t('base', 'Actions'),
            'template' => '{update} {export} {import} {delete}',
            'buttons' => array(
                'update' => array(
                    'url'=>'Yii::app()->createUrl("/control/settings/languages/update?prefix=" . $data["prefix"])'
                ),
                'export' => array(
                    'url'=>'Yii::app()->createUrl("/control/settings/languages/export?prefix=" . $data["prefix"])',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/file_export.png',
                    'options' => array('title' => Yii::t('base', 'Export'))
                ),
                'import' => array(
                    'url'=>'Yii::app()->createUrl("/control/settings/languages/import?prefix=" . $data["prefix"])',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/file_import.png',
                    'options' => array('title' => Yii::t('base', 'Import')),
                    'click' => $importLangFileDialog,
                ),
                'delete' => array(
                    'url'=>'Yii::app()->createUrl("/control/settings/languages/delete?prefix=" . $data["prefix"])'
                )
            )
        )
    ),
)); 
?>
