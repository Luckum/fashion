<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
 
class DTreeActiveDataProvider extends CActiveDataProvider
{
    public $childRelation = 'child_items';
 
    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();
 
        if(($pagination=$this->getPagination())!==false)
        {
            $pagination->setItemCount($this->getTotalItemCount());
            $pagination->applyLimit($criteria);

        }
 
        $baseCriteria=$this->model->getDbCriteria(false);
 
        if(($sort=$this->getSort())!==false)
        {
            // set model criteria so that CSort can use its table alias setting
            if($baseCriteria!==null)
            {
                $c=clone $baseCriteria;
                $c->mergeWith($criteria);
                $this->model->setDbCriteria($c);
            }
            else
                $this->model->setDbCriteria($criteria);
            $sort->applyOrder($criteria);
        }
 
        $this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);
 
        $rootCriteria=clone $criteria;
        $isEmptyCondition=empty($rootCriteria->condition);
         
        if ($isEmptyCondition) {
            $rootCriteria->addCondition('t.parent_id iS NULL OR t.parent_id = 0');
            $rootCriteria->order = 't.menu_order ASC';
        }
         
        $items=$this->model->findAll($rootCriteria);
         
        if ($isEmptyCondition)
            $items=$this->buildRecursive($items);
         
        $this->model->setDbCriteria($baseCriteria);  // restore original criteria
        return $items;
    }
 
    protected function buildRecursive($items, $indent=0, $foolproof=20)
    {
        $data=array();
        foreach ($items as $item)
        {
            $item->indent=$indent;
            $data[]=$item;
            if ($foolproof && $item->{$this->childRelation})
                $data=array_merge($data, $this->buildRecursive($item->{$this->childRelation}, $indent+1, $foolproof-1));
        }
        return $data;
    }

    protected function calculateTotalItemCount()
    {
        $baseCriteria=$this->model->getDbCriteria(false);
        if($baseCriteria!==null)
            $baseCriteria=clone $baseCriteria;
        
        $criteria=clone $this->getCriteria();
        $isEmptyCondition=empty($criteria->condition);
         
        if ($isEmptyCondition) {
            $criteria->addCondition('t.parent_id iS NULL OR t.parent_id = 0');
        }

        $count=$this->model->count($criteria);
        $this->model->setDbCriteria($baseCriteria);
        return $count;
    }

    public function getTotal()
    {
        $baseCriteria=$this->model->getDbCriteria(false);
        if($baseCriteria!==null)
            $baseCriteria=clone $baseCriteria;
        
        $criteria=clone $this->getCriteria();
        $rootCriteria=clone $criteria;
        $isEmptyCondition=empty($criteria->condition);
         
        if ($isEmptyCondition) {
            $rootCriteria->addCondition('t.parent_id iS NULL OR t.parent_id = 0');
        }

        if ($isEmptyCondition) {
            $items=$this->model->findAll($rootCriteria);
            $items=$this->buildRecursive($items);

            return count($items);
        } else {
            return $this->model->count($criteria);
        }
    }

    public function getStartPagination()
    {
        $start = 1;

        $criteria=clone $this->getCriteria();
        $isEmptyCondition=empty($criteria->condition);

        if (($pagination=$this->getPagination())!==false) {
            if ($isEmptyCondition) {
                $oldCurrentPage = $pagination->currentPage;
                
                for ($i=0; $i < $oldCurrentPage; $i++) {
                    $pagination->setCurrentPage($i); 
                    $start += count($this->fetchData());
                }

                $pagination->setCurrentPage($oldCurrentPage); 
            } else {
                $start += $pagination->currentPage*$pagination->pageSize;
            }
        }

        return $start;
    }
}