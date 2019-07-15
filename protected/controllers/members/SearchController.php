<?php

class SearchController extends Controller
{
    public $title;
    public $meta_description;
    public $meta_keywords;
    
    public function actionResults($q)
    {
        $limit = 15;
        $offset = 0;
        $products = $brands = $categories = [];
        $message = '';
        $count = $products_cnt = 0;
        
        if (!empty($q) && strlen($q) > 2) {
            $query = trim(strtolower(str_replace('+', ' ', strip_tags($q))));
            $data = $this->getResults($query, $limit, $offset);
            
            if (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
                $query_parts = explode(' ', $query);
                $query_res = substr($query_parts[0], 0, -1);
                $data = $this->getResults($query_res, $limit, $offset);
                while (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
                    $query_res = substr($query_res, 0, -1);
                    $data = $this->getResults($query_res, $limit, $offset);
                }
            }
            
            $products = $data['product'];
            $brands = $data['brand'];
            $categories = $data['category'];
            $products_cnt = $data['products_cnt'];
            
            foreach ($products as $rec) {
                $count += count($rec);
            }
        } else {
            $message = 'Wrong search criteria';
        }
        
        return $this->render('results', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'q' => $q,
            'message' => $message,
            'limit' => $limit,
            'offset' => $offset,
            'products_cnt' => $products_cnt,
            'count' => $count,
        ]);
    }
    
    public function actionMoreResults()
    {
        $limit = Yii::app()->request->getPost('limit');
        $offset = Yii::app()->request->getPost('offset');
        $q = Yii::app()->request->getPost('query');
        
        $products = $brands = $categories = [];
        $count = $products_cnt = 0;
        
        $query = trim(strtolower(str_replace('+', ' ', strip_tags($q))));
        $data = $this->getResults($query, $limit, $offset);
        
        if (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
            $query_parts = explode(' ', $query);
            $query_res = substr($query_parts[0], 0, -1);
            $data = $this->getResults($query_res, $limit, $offset);
            while (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
                $query_res = substr($query_res, 0, -1);
                $data = $this->getResults($query_res, $limit, $offset);
            }
        }
        
        $products = $data['product'];
        $products_cnt = $data['products_cnt'];
        
        foreach ($products as $rec) {
            $count += count($rec);
        }
        
        die (CJSON:: encode([
            'html' => $this->renderPartial('_results', [
                'products' => $products,
                'q' => $q,
                'count' => $count,
            ], true),
            'limit' => $limit,
            'offset' => $offset,
            'products_cnt' => $products_cnt,
        ]));
    }
    
    protected function getResults($query, $limit, $offset)
    {
        $data['brand'] = $data['product'] = $data['category'] = [];
        $data['products_cnt'] = 0;
        
        $query_parts = explode(' ', $query);
        foreach ($query_parts as $query_part) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'LOWER(title) LIKE "%' . $query_part . '%"';
            $data['products_cnt'] += Product::model()->count($criteria);
            
            $criteria = new CDbCriteria;
            $criteria->select = 'id, title, external_sale, direct_url, category_id, image1, init_price, price, status';
            $criteria->with = ['category' => ['select' => 'alias, parent_id'], 'brand' => ['select' => 'name'], 'size_chart' => ['select' => 'size']];
            $criteria->condition = 'LOWER(title) LIKE "%' . $query_part . '%"';
            $criteria->order = 'title ASC';
            $criteria->limit = $limit;
            $criteria->offset = $offset;
            $products = Product::model()->findAll($criteria);
            if ($products) {
                $data['product'][] = $products;
            }
            
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = 'LOWER(name) LIKE "%' . $query_part . '%"';
            $brands = Brand::model()->findAll($criteria);
            if ($brands) {
                $data['brand'][] = $brands;
            }
            
            $criteria = new CDbCriteria;
            $criteria->select = 'parent_id, alias';
            $criteria->condition = 'LOWER(alias) LIKE "%' . $query_part . '%"';
            $categories = Category::model()->findAll($criteria);
            if ($categories) {
                $data['category'][] = $categories;
            }
        }
        
        if (count($query_parts) > 1) {
            $query_all = '';
            $brands_for = [];
            foreach ($query_parts as $k => $query_part) {
                $query_all .= ' ' . $query_part;
                $query_all = trim($query_all);
                
                $criteria = new CDbCriteria;
                $criteria->select = '*';
                $criteria->condition = "LOWER(name) LIKE '%$query_all%'";
                $brands_ad = Brand::model()->findAll($criteria);
                if (!$brands_ad) {
                    break;
                } else {
                    $brands_for = $brands_ad;
                }
            }
            for ($i = 0; $i < $k; $i ++) {
                array_shift($query_parts);
            }
            $query_all = '';
            foreach ($query_parts as $query_part) {
                $query_all .= ' ' . $query_part;
                $query_all = trim($query_all);
                
                $criteria = new CDbCriteria;
                $criteria->select = 'id, parent_id, alias';
                $criteria->condition = "LOWER(alias) LIKE '%$query_all%'";
                $categories_ad = Category::model()->findAll($criteria);
                
                if ($categories_ad) {
                    foreach ($categories_ad as $category) {
                        foreach ($brands_for as $brand) {
                            if (Product::model()->exists("category_id = " . $category->id . " AND brand_id = " . $brand->id)) {
                                $parent = Category::model()->findByPk($category->parent_id);
                            
                                array_unshift($data['category'], [
                                    'title' => $brand->name . ' ' . $category->alias . ($parent ? ' (' . $parent->alias . ')' : ''),
                                    'link' => ($parent ? strtolower(str_replace(' ', '-', '/' . $parent->alias . '/' . $category->alias)) : strtolower(str_replace(' ', '-', '/' . $category->alias))) . '/designers/' . $brand->url
                                ]);
                            }
                        }
                    }
                }
            }
            
            $query_parts = explode(' ', $query);
            $query_all = '';
            $brands_for = [];
            foreach ($query_parts as $k => $query_part) {
                $query_all .= ' ' . $query_part;
                $query_all = trim($query_all);
                
                $criteria = new CDbCriteria;
                $criteria->select = '*';
                $criteria->condition = "LOWER(name) LIKE '%$query_all%'";
                $brands_ad = Brand::model()->findAll($criteria);
                if (!$brands_ad) {
                    break;
                } else {
                    $brands_for = $brands_ad;
                }
            }
            for ($i = 0; $i < $k; $i ++) {
                array_shift($query_parts);
            }
            $query_all = '';
            foreach ($query_parts as $query_part) {
                $query_all .= ' ' . $query_part;
                $query_all = trim($query_all);
                
                $criteria = new CDbCriteria;
                $criteria->select = 'id, title, external_sale, direct_url, category_id, image1, init_price, price, status, brand_id';
                $criteria->with = ['category' => ['select' => 'alias, parent_id'], 'brand' => ['select' => 'name'], 'size_chart' => ['select' => 'size']];
                $criteria->condition = "LOWER(title) LIKE '%$query_all%'";
                $products_ad = Product::model()->findAll($criteria);
                
                if ($products_ad) {
                    foreach ($products_ad as $product) {
                        foreach ($brands_for as $brand) {
                            if ($product->brand_id == $brand->id) {
                                foreach ($data['product'] as $i => $rec) {
                                    foreach ($rec as $k => $product_rec) {
                                        if ($product_rec->id == $product->id) {
                                            unset($data['product'][$i][$k]);
                                            array_unshift($data['product'][$i], $product);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $data;
    }
}