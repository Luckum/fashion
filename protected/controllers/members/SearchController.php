<?php

class SearchController extends Controller
{
    public $title;
    public $meta_description;
    public $meta_keywords;
    
    public function actionResults($q)
    {
        $columnsCount = 3;
        if ($value = (string)Yii::app()->request->cookies['width']) {
            if ($value <= 768) {
                $columnsCount = 2;
            }
        }
        
        $limit = 129;
        $offset = 0;
        //$products = $brands = $categories = [];
        $products = [];
        $message = '';
        $count = $products_cnt = 0;
        
        if (isset($_POST['currency'])) {
            Currency::setCurrency($_POST['currency']);
        }
        
        if (!empty($q) && strlen($q) > 2) {
            $query = trim(strtolower(str_replace('+', ' ', strip_tags($q))));
            $data = $this->getResults($query, $limit, $offset);
            
            //if (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
            if (!count($data['product'])) {
                $query_parts = explode(' ', $query);
                $query_res = substr($query_parts[0], 0, -1);
                $data = $this->getResults($query_res, $limit, $offset);
                //while (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
                while (!count($data['product'])) {
                    $query_res = substr($query_res, 0, -1);
                    $data = $this->getResults($query_res, $limit, $offset);
                }
            }
            
            $products = $data['product'];
            //$brands = $data['brand'];
            //$categories = $data['category'];
            $products_cnt = $data['products_cnt'];
            
            foreach ($products as $rec) {
                $count += count($rec);
            }
        } else {
            $message = 'Wrong search criteria';
        }
        
        $currency = Currency::getCurrency();
        if (isset($_POST['currency'])) {
            die (CJSON:: encode([
                'html' => $this->renderPartial('_results_currency', [
                    'products' => $products,
                    'q' => $q,
                    'count' => $count,
                    'currency' => $currency,
                    'limit' => $limit,
                    'offset' => $offset,
                    'products_cnt' => $products_cnt,
                    'columnsCount' => $columnsCount,
                ], true),
                'selector_html' => $this->renderPartial('application.views.members.shop._currency', [], true),
                'selector_html_mbl' => $this->renderPartial('application.views.members.shop._currency_mbl', [], true),
            ]));
        }
        
        $brands_all = UtilsHelper::byAlphabetCat(Brand::getAllBrands());
        
        return $this->render('results', [
            'products' => $products,
            //'brands' => $brands,
            //'categories' => $categories,
            'q' => $q,
            'message' => $message,
            'limit' => $limit,
            'offset' => $offset,
            'products_cnt' => $products_cnt,
            'count' => $count,
            'brands_all' => $brands_all,
            'alphabet' => UtilsHelper:: getAlphabet(array('#')),
            'currency' => $currency,
            'columnsCount' => $columnsCount,
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
        
        //if (!count($data['product']) && !count($data['category']) && !count($data['brand'])) {
        if (!count($data['product'])) {
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
        $currency = Currency::getCurrency();
        
        foreach ($products as $rec) {
            $count += count($rec);
        }
        
        die (CJSON:: encode([
            'html' => $this->renderPartial('_results', [
                'products' => $products,
                'q' => $q,
                'count' => $count,
                'currency' => $currency,
            ], true),
            'limit' => $limit,
            'offset' => $offset,
            'products_cnt' => $products_cnt,
        ]));
    }
    
    protected function getResults($query, $limit, $offset)
    {
        //$data['brand'] = $data['product'] = $data['category'] = [];
        $data['product'] = [];
        $data['products_cnt'] = 0;
        
        $query_parts = explode(' ', $query);
        $query_all = '';
        
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = 'LOWER(name) = "' . $query . '"';
        $brand = Brand::model()->find($criteria);
        if ($brand) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'brand_id = ' . $brand->id;
            $data['products_cnt'] += Product::model()->count($criteria);
        
            $criteria = new CDbCriteria;
            $criteria->select = 'id, title, external_sale, direct_url, category_id, image1, init_price, price, status';
            $criteria->with = ['category' => ['select' => 'alias, parent_id'], 'brand' => ['select' => 'name'], 'size_chart' => ['select' => 'size']];
            $criteria->condition = 'brand_id = ' . $brand->id;
            $criteria->order = 'title ASC';
            $criteria->limit = $limit;
            $criteria->offset = $offset;
            $products = Product::model()->findAll($criteria);
            if ($products) {
                $data['product'][] = $products;
                $limit -= count($products);
            }
        }
        
        foreach ($query_parts as $query_part) {
            $query_all .= ' ' . $query_part;
            $query_all = trim($query_all);
            
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = 'LOWER(name) = "' . $query_all . '"';
            $brand = Brand::model()->find($criteria);
            if ($brand) {
                $criteria = new CDbCriteria;
                $criteria->condition = 'brand_id = ' . $brand->id;
                $data['products_cnt'] += Product::model()->count($criteria);
            
                $criteria = new CDbCriteria;
                $criteria->select = 'id, title, external_sale, direct_url, category_id, image1, init_price, price, status';
                $criteria->with = ['category' => ['select' => 'alias, parent_id'], 'brand' => ['select' => 'name'], 'size_chart' => ['select' => 'size']];
                $criteria->condition = 'brand_id = ' . $brand->id;
                $criteria->order = 'title ASC';
                $criteria->limit = $limit;
                $criteria->offset = $offset;
                $products = Product::model()->findAll($criteria);
                if ($products) {
                    $data['product'][] = $products;
                    $limit -= count($products);
                }
            }
            
            
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
                $limit -= count($products);
            }
            
            
            
            /*$criteria = new CDbCriteria;
            $criteria->select = 'parent_id, alias';
            $criteria->condition = 'LOWER(alias) LIKE "%' . $query_part . '%"';
            $categories = Category::model()->findAll($criteria);
            if ($categories) {
                $data['category'][] = $categories;
            }*/
        }
        
        if (count($query_parts) > 1) {
            /*$query_all = '';
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
            
            $query_parts = explode(' ', $query);*/
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
    
    public function actionGetProduct()
    {
        $query = trim(strtolower(str_replace('+', ' ', strip_tags(Yii::app()->request->getPost('query')))));
        
        $criteria = new CDbCriteria;
        $criteria->select = 'id, title';
        $criteria->with = ['category' => ['select' => 'alias, parent_id']];
        $criteria->condition = "LOWER(title) = '$query'";
        
        $product = Product::model()->find($criteria);
        if ($product) {
            $parent = Category::model()->findByPk($product->category->parent_id);
            $cat_name = $parent ? $parent->alias . '/' . $product->category->alias : $product->category->alias;
            $p_title = str_replace(['"', ",", "'"], "", $product->title);
            $res_link = strtolower(str_replace(' ', '-', '/' . $cat_name . '/' . trim($p_title) . '-' . $product->id));
            die (CJSON::encode([
                'link' => $res_link
            ]));
        } else {
            $query_parts = explode(' ', $query);
            if (count($query_parts) > 1) {
                $query_all = '';
                foreach ($query_parts as $k => $query_part) {
                    $query_all .= ' ' . $query_part;
                    $query_all = trim($query_all);
                    
                    $criteria = new CDbCriteria;
                    $criteria->select = '*';
                    $criteria->condition = "LOWER(name) = '$query_all'";
                    $brand_ad = Brand::model()->find($criteria);
                    if ($brand_ad) {
                        break;
                    }
                }
                if ($brand_ad) {
                    for ($i = 0; $i <= $k; $i ++) {
                        array_shift($query_parts);
                    }
                    $query = implode(' ', $query_parts);
                    
                    $criteria = new CDbCriteria;
                    $criteria->select = 'id, title';
                    $criteria->with = ['category' => ['select' => 'alias, parent_id']];
                    $criteria->condition = "LOWER(title) = '$query'";
                    
                    $product = Product::model()->find($criteria);
                    if ($product) {
                        $parent = Category::model()->findByPk($product->category->parent_id);
                        $cat_name = $parent ? $parent->alias . '/' . $product->category->alias : $product->category->alias;
                        $p_title = str_replace(['"', ",", "'"], "", $product->title);
                        $res_link = strtolower(str_replace(' ', '-', '/' . $cat_name . '/' . trim($p_title) . '-' . $product->id));
                        die (CJSON::encode([
                            'link' => $res_link
                        ]));
                    }
                    
                    $criteria = new CDbCriteria;
                    $criteria->select = 'id, alias, parent_id';
                    $criteria->condition = "LOWER(alias) = '$query'";
                    
                    $category = Category::model()->find($criteria);
                    if ($category) {
                        $parent = Category::model()->findByPk($category->parent_id);
                        $res_link = ($parent ? strtolower(str_replace(' ', '-', '/' . $parent->alias . '/' . $category->alias)) : strtolower(str_replace(' ', '-', '/' . $category->alias))) . '/designers/' . $brand_ad->url;
                        die (CJSON::encode([
                            'link' => $res_link
                        ]));
                    }
                }
            }
        }
        
        die (CJSON::encode([
            'link' => '/search/results?q=' . urlencode(Yii::app()->request->getPost('query'))
        ]));
    }
}