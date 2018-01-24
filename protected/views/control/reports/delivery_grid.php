<canvas id="myChart"></canvas>

<?php 
    $this->widget('zii.widgets.grid.CGridView', array(  
        'id' => 'saleGrid',  
        'dataProvider' => $reports->searchDelivery(),  
        'filter' => $reports,
        'enablePagination' => true, 
        'enableHistory' => true, 
        'ajaxUrl' => array('control/reports/delivery'),
        'columns' => array(  
            array(  
                'name' => Yii::t('base', 'Added date'),  
                'value' => '$data->added_date',  
                'filter' => false,  
            ),
            array(  
                'name' => Yii::t('base', 'Order status'),  
                'value' => '$data->status',  
                'filter' => false,  
            ),
            array(  
                'name' => Yii::t('base', 'User email'),  
                'value' => '$data->user->email',  
                'filter' => false,  
            ),
            array(  
                'name' => Yii::t('base', 'Shipping country'),  
                'value' => '$data->shippingAddress->country->name',  
                'filter' => false,  
            ),
            array(  
                'name' => Yii::t('base', 'Shipping cost'),  
                'value' => '$data->shipping_cost',  
                'filter' => false   
        )  
    )));  
?>