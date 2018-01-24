<canvas id="myChart"></canvas>

<?php 
    echo CHtml::label(Yii::t('base', 'Filter By Country'), 'country_filter');
    echo CHtml::dropDownList('country_filter', '', array_merge (array("" => ""), Country::getListCountry()));

    $this->widget('zii.widgets.grid.CGridView', array(  
        'id' => 'usersGrid',  
        'dataProvider' => $reports->searchUsers(),  
        'filter' => $reports,
        'enableHistory' => true,
        'enablePagination' => true,  
        'ajaxUrl' => array('control/reports/usersGrid'),
        'columns' => array(  
            array(  
                'name' => 'user_id',  
                'value' => '$data->id',  
                'filter' => false,
            ),  
            array(  
                'name' => 'username',  
                'value' => '$data->username',  
                'filter' => false,
            ),  
            array(  
                'name' => 'user_country',  
                'value' => '$data->country->name',  
                'filter' => false,
            ),
            array(
                'header' => Yii::t('base', 'Order last added date'), 
                'value' => '$data->orders[0]->getLastOrderDateByUser()->added_date',
                'filter' => false,
            ),
        )  
    ));  
?>
