<canvas id="myChart"></canvas>

<?php 
    $this->widget('zii.widgets.grid.CGridView', array(  
        'id' => 'ordersGrid',  
        'dataProvider' => $reports->searchOrders(),  
        'filter' => $reports,
        'enableHistory' => true,
        'enablePagination' => true,  
        'columns' => array(  
            array(  
                'name' => 'status',  
                'value' => '$data->status',  
                'filter' => false,
            ),  
            array(  
                'name' => 'count_ord',  
                'value' => '$data->count_ord',  
                'filter' => false,
            ),  
        )  
    ));  
?>

