<canvas id="myChart"></canvas>

<?php 
    echo CHtml::label(Yii::t('base', 'Filter By Category'), 'category_filter');
    echo CHtml::dropDownList('category_filter', '', Category::getSubCategoryList());

    $this->widget('zii.widgets.grid.CGridView', array(  
        'id' => 'saleGrid',  
        'dataProvider' => $reports->searchSales(),  
        'filter' => $reports,
        'enableHistory' => true,
        'enablePagination' => true,  
        'ajaxUrl' => array('control/reports/saleGrid'),
        'columns' => array(  
            array(  
                'name' => Yii::t('base', 'id'),  
                'value' => '$data["id"]',  
                'sortable' => true,  
                'filter' => false,  
            ),  
            array(  
                'name' => Yii::t('base', 'Title'),  
                'value' => '$data["title"]',  
                'sortable' => true,  
                'filter' => false,  
            ),  
            array(  
                'name' => 'category_id',  
                'header' => Yii::t('base', 'Category'),  
                'value' => '$data["category_id"]',  
                'sortable' => true,  
                'filter' => false, 
            ),    
        )  
    ));  
?>
