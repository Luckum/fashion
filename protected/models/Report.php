<?php

class Report extends CFormModel
{   
    public $product_id;
    public $product_title;
    public $category_id;
    public $user_id;
    public $username;
    public $user_country;
    public $added_date;
    public $from_date;
    public $to_date;
    
    public function getSalesProducts()
    {
        $condition = "`p1`.`price` != `p2`.`init_price` AND `p1`.`id` = `p2`.`id` AND `p1`.`status` = 'active'";
        
        if(!empty($this->category_id)) {
            $condition .= " AND `p1`.`category_id` = '$this->category_id'";
        }
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $condition .= " AND `p1`.`added_date` >= '$this->from_date' and `p1`.`added_date` <= '$this->to_date'";
        }

        $sql = "SELECT p2.*,
                       c.alias category_name,
                       b.name brand_name, CONCAT(s.size, ' (', s.type, ')') size
                FROM `product` p1, `product` p2
                LEFT JOIN `category` c
                ON p2.category_id = c.id
                LEFT JOIN `brand` b
                ON p2.brand_id = b.id
                LEFT JOIN `size_chart` s
                ON p2.size_type = s.id
                WHERE {$condition}";
        $command = Yii::app()->db->createCommand($sql);

        return $command->queryAll();  
    }

    public function getSalesChart()
    {
        $sales = $this->getSalesProducts();
        $products = array();

        foreach ($sales as $key => $product) {
            $products['labels'][] = $product['title'];
            $products['data']['price'][] = $product['price'];
            $products['data']['init_price'][] = $product['init_price'];
        }
      
        return $products;
    }

    public function getUsersChart()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('sellerProfile','orders');
        $criteria->together = true;
        $criteria->select = '`t`.*, `sellerProfile`.*, `orders`.*, count(`orders`.`user_id`) AS count_ord';
        $criteria->group = '`t`.`id`';
        $criteria->order = 'count_ord DESC';
        $criteria->limit = '5';
        $criteria->condition = '`sellerProfile`.`id` is null AND `t`.`status` = "active"';

        if(!empty($this->user_country))
        {
            $criteria->addCondition("`t`.`country` = '$this->user_country'");
        }

        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`orders`.`added_date` >= '$this->from_date' and `orders`.`added_date` <= '$this->to_date'");
        }
        $users = User::model()->findAll($criteria);
        
        $result = array();
        
        foreach ($users as $key => $user) {
            $result['labels'][] = $user->username;
            $result['data'][0][] = $user->count_ord;
        }
      
        return $result;
    }

    public function getOrdersChart()
    {
        $criteria=new CDbCriteria;

        $criteria->select = '`t`.*, count(`t`.`id`) AS count_ord';
        $criteria->group = '`t`.`status`';
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        $orders = Order::model()->findAll($criteria);
        
        $result = array();
        foreach ($orders as $key => $order) {
            $result['labels'][] = $order->status;
            $result['data'][0][] = $order->count_ord;
        }
        // echo "<pre>";print_r($result);echo "</pre>";die();
        return $result;
    }

    public function getDeliveryChart()
    {
        $criteria=new CDbCriteria;

        $criteria->select = '`t`.*';
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        $orders = Order::model()->findAll($criteria);
        
        $result = array();
        foreach ($orders as $key => $order) {
            $result['labels'][] = $order->id;
            $result['data'][0][] = $order->shipping_cost;
        }
        // echo "<pre>";print_r($result);echo "</pre>";die();
        return $result;
    }
    
    public function searchSales()
    {
        $sales = $this->getSalesProducts();
        $products = array();

        foreach ($sales as $key => $product) {
            $products[$key]['id'] = $product['id'];
            $products[$key]['title'] = $product['title'];
            $category = Category::model()->findByPk($product['category_id']);
            $categoryAlias = $category->alias;
            $categoryParent = $category->parent;
            if (isset($categoryParent) && !is_null($categoryParent)) {
                $categoryAlias = $categoryParent->alias . ' - ' . $category->alias;
            }
            $products[$key]['category_id'] = $categoryAlias;
        }
      
        return new CArrayDataProvider($products, array(  
            'pagination' => array(  
                'pageSize' => 10,  
            ),  
        ));  
    }

    public function searchUsers()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('sellerProfile','orders');
        $criteria->together = true;
        $criteria->select = '`t`.*, `sellerProfile`.*, `orders`.*, count(`orders`.`user_id`) AS count';
        $criteria->group = '`t`.`id`';
        $criteria->order = 'count DESC';
        $criteria->limit = '5';
        $criteria->condition = '`sellerProfile`.`id` is null AND `t`.`status` = "active"';

        if(!empty($this->user_country))
        {
            $criteria->addCondition("`t`.`country` = '$this->user_country'");
        }

        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`orders`.`added_date` >= '$this->from_date' and `orders`.`added_date` <= '$this->to_date'");
        }

        return new CActiveDataProvider('User', array(
            'criteria'=>$criteria,
            'pagination' => false,
            'sort' => array(
                'defaultOrder' => 't.id',
                'attributes' => array(
                    'type' => array(
                        'asc' => 'sellerProfile.id',
                        'desc' => 'sellerProfile.id DESC'
                    ), 
                    '*'
                )
            ),
            
        ));
    }

    public function searchOrders()
    {
        $criteria=new CDbCriteria;

        $criteria->select = '`t`.*, count(`t`.`id`) AS count_ord';
        $criteria->group = '`t`.`status`';
        $criteria->order = 't.added_date DESC';
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        return new CActiveDataProvider('Order', array(
            'criteria'=>$criteria,
        ));
    }

    public function searchDelivery()
    {
        $criteria=new CDbCriteria;

        $criteria->select = '`t`.*';
        $criteria->with = array('user', 'shippingAddress');
        $criteria->order = 't.added_date DESC';
        
        if(!empty($this->to_date) && !empty($this->from_date))
        {
            $criteria->addCondition("`t`.`added_date` >= '$this->from_date' and `t`.`added_date` <= '$this->to_date'");
        }

        return new CActiveDataProvider('Order', array(
            'criteria'=>$criteria,
        ));  
    }

    public function attributeLabels()
    {
        return array(
            'product_id'  => Yii::t('base', 'Product ID'),
            'product_title'  => Yii::t('base', 'Product Title'),
            'category'  => Yii::t('base', 'Product Ctegory'),
            'user_id'  => Yii::t('base', 'User ID'),
            'username'  => Yii::t('base', 'User Name'),
            'user_country'  => Yii::t('base', 'Country'),
            'added_date'  => Yii::t('base', 'Date Added'),
        );
    }
}