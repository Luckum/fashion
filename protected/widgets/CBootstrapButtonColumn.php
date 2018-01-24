<?php
class CBootstrapButtonColumn extends CButtonColumn {
    protected function renderButton($id,$button,$row,$data)
    {
        if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
              return;
        $label=isset($button['label']) ? $button['label'] : $id;
        $url=isset($button['url']) ? $this->evaluateExpression($button['url'],array('data'=>$data,'row'=>$row)) : '#';
        $options=isset($button['options']) ? $button['options'] : array();
        if(!isset($options['title']))
            $options['title']=$label;
            
        if(isset($button['preHTML'])) echo $this->evaluateExpression($button['preHTML'], array('data'=>$data,'row'=>$row));
        if(isset($button['imageUrl']) && is_string($button['imageUrl']))
            echo CHtml::link(CHtml::image($button['imageUrl'],$label),$url,$options);
        else
            echo CHtml::link($label,$url,$options);
        if(isset($button['postHTML'])) echo $this->evaluateExpression($button['postHTML'], array('data'=>$data,'row'=>$row));
    }
}
