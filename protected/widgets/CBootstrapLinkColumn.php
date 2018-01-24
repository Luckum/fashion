<?php
class CBootstrapLinkColumn extends CLinkColumn {
    
    protected function renderDataCellContent($row,$data)
    {
        if($this->urlExpression!==null)
            $url=$this->evaluateExpression($this->urlExpression,array('data'=>$data,'row'=>$row));
        else
            $url=$this->url;
        if($this->labelExpression!==null)
            $label=$this->evaluateExpression($this->labelExpression,array('data'=>$data,'row'=>$row));
        else
            $label=$this->label;
        $options=$this->linkHtmlOptions;
        
        while(list($key, $value) = each($options)) {
            if(substr($key, 0, 5)=='data-') {
                $options[$key] = $this->evaluateExpression($value, array('data'=>$data, 'row'=>$row));
            }
        }
        if(is_string($this->imageUrl))
            echo CHtml::link(CHtml::image($this->imageUrl,$label),$url,$options);
        else
            echo CHtml::link($label,$url,$options);
    }    
}