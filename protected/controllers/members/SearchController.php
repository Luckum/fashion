<?php

class SearchController extends Controller
{
    public $title;
    public $meta_description;
    public $meta_keywords;
    
    public function actionResults($q)
    {
        $products = $brands = $categories = [];
        $message = '';
        
        if (!empty($q) && strlen($q) > 2) {
            $query = trim(strtolower(str_replace('+', ' ', strip_tags($q))));
            
            $criteria = new CDbCriteria;
            $criteria->select = 'id, title';
            $criteria->with = ['category' => ['select' => 'alias, parent_id']];
            $criteria->condition = 'LOWER(title) LIKE "%' . $query . '%"';
            $products = Product::model()->findAll($criteria);
            
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = 'LOWER(name) LIKE "%' . $query . '%"';
            $brands = Brand::model()->findAll($criteria);
            
            $criteria = new CDbCriteria;
            $criteria->select = 'parent_id, alias';
            $criteria->condition = 'LOWER(alias) LIKE "%' . $query . '%"';
            $categories = Category::model()->findAll($criteria);
        } else {
            $message = 'Wrong search criteria';
        }
        
        return $this->render('results', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'q' => $q,
            'message' => $message
        ]);
    }
}