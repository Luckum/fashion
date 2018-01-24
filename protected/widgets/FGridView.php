<br>
<?php
Yii::import('zii.widgets.grid.CGridView');

class FGridView extends CGridView
{
    public $controller;
    
    public function renderStatus()
    {
        $options = '<option value=0>' . Yii::t('base', 'All') . '</option>';
        $statuses = Order::model()->getFilterStatus();
        foreach ($statuses as $key => $status) {        
            array_replace($_GET, array('status' => $key));
 
            $selected = Yii::app()->request->getQuery('status') == $key ? 'selected' : '';
            $options .= '<option value="' . $key . '" ' . $selected . '>' . $status . '</option>';
        }        
        
        echo '<div style=" float:left; margin-right:10px;">';
        echo Yii::t('base', 'Filter By Status') . ':&nbsp;';
        echo '<select onchange="getAjaxDataStatus(this, \'' . $this->controller . '\')" id="statusSel">';
        echo $options;
        echo '</select>';
        echo '</div>';
    }
}