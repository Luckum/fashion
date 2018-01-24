<?php
class FilterLinkPager extends LinkPager{
    protected function createPageUrl($page){
        $query = Yii::app()->request->getUrl();

        $main = preg_split('/\?/', $query);

        if(count($main) == 1) {
            return $main[0] . '?page=' . ++$page;
        }

        $pageUrl = '';

        if(isset($main[1])){
            $pageUrl = $main[0] . '?';

            $params = preg_split('/&/', $main[1]);
            $uniqueParams = array();

            foreach($params as $param){
                $parameter = preg_split('/=/', $param);

                $uniqueParams[$parameter[0]] = $parameter[1];
            }

            $counter = 0;
            $pageFound = false;

            foreach($uniqueParams as $key => $value){
                if($key == 'page'){
                    $parameter = 'page=' . ++$page;
                    $pageFound = true;
                }else{
                    $parameter = $key . '=' . $value;
                }

                if($counter == 0){
                    $pageUrl .= $parameter;
                }else{
                    $pageUrl .= '&' . $parameter;
                }

                $counter++;
            }

            if(!$pageFound){
                $pageUrl = ($counter == 0) ?
                    ($pageUrl . '?page=' . ++$page) :
                    ($pageUrl . '&page=' . ++$page);
            }
        }

        return $pageUrl;
    }
}




















