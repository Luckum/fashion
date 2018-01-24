<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $registration_date
 * @property string $last_login
 * @property string $country_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Bid[] $bs
 * @property Cart[] $carts
 * @property Order[] $orders
 * @property Product[] $products
 * @property Rating[] $ratings
 * @property SellerProfile[] $sellerProfiles
 * @property ShippingAddress[] $shippingAddresses
 * @property Wishlist[] $wishlists
 */
class User extends CActiveRecord
{
    public $type;
    public $from_date;
    public $to_date;
    public $count_ord;
    public $agreeCookies;
    public $access_hash;
    public $time_send;
    public $current_password;
    public $password2;

    const ACTIVE = 'active';
    const BLOCKED = 'blocked';
    const BUYER = 1;
    const SELLER = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, country_id', 'required', 'message' => '*required'),
            array('password', 'required', 'except' => 'adminUpdateUser', 'message' => '*required'),
            array('access_hash', 'required', 'on' => 'forgotPass', 'message' => '*required'),
            array('qb_user_id', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 7),
            array('username, email, access_hash', 'length', 'max' => 255),
            array('current_password', 'verifyPassword', 'on' => 'changePass'),
            array('password', 'length', 'max' => 40),
            array('password', 'compare', 'compareAttribute' => 'password2', 'on' => 'changePass,changePassWithoutCurrent'),
            array('password2', 'required', 'on' => 'changePass,changePassWithoutCurrent', 'message' => '*required'),
            array('email', 'email', 'allowName' => false),
            array('email', 'unique'),
            array('type', 'length', 'max' => 255),
            array('type, time_send, access_hash, qb_user_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, email, registration_date, last_login, country_id, status, type,  qb_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bs' => array(self::HAS_MANY, 'Bid', 'user_id'),
            'carts' => array(self::HAS_MANY, 'Cart', 'user_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'user_id'),
            'products' => array(self::HAS_MANY, 'Product', 'user_id'),
            'ratings' => array(self::HAS_MANY, 'Rating', 'user_id'),
            'sellerProfile' => array(self::HAS_ONE, 'SellerProfile', 'user_id'),
            'shippingAddresses' => array(self::HAS_MANY, 'ShippingAddress', 'user_id'),
            'wishlists' => array(self::HAS_MANY, 'Wishlist', 'user_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('base', 'ID'),
            'username' => Yii::t('base', 'Name'),
            'email' => Yii::t('base', 'Email'),
            'password' => Yii::t('base', 'New password'),
            'password2' => Yii::t('base', 'Confirm new password'),
            'registration_date' => Yii::t('base', 'Registration Date'),
            'last_login' => Yii::t('base', 'Last Login'),
            'country_id' => Yii::t('base', 'Country'),
            'status' => Yii::t('base', 'Status'),
            'type' => Yii::t('base', 'User Type'),
            'agreeCookies' => Yii::t('base', 'Agree Cookies'),
            'current_password' => Yii::t('base', 'Current Password'),
            'qb_user_id' => Yii::t('base', 'QuickBook User ID'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('sellerProfile');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.registration_date', $this->registration_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->order = 't.registration_date DESC';
        if (strtolower($this->type) == 'vendor') {
            $criteria->addCondition('sellerProfile.id is not null');
        }
        if (strtolower($this->type) == 'customer') {
            $criteria->addCondition('sellerProfile.id is null');
        }

        if (isset($this->to_date, $this->from_date)) {
            $criteria->condition = "t.registration_date BETWEEN '{$this->from_date}' AND '{$this->to_date}'";
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getStatuses()
    {
        return array(self::ACTIVE => Yii::t('base', 'Active'),
            self::BLOCKED => Yii::t('base', 'Blocked')
        );
    }

    public function getTypes()
    {
        return array(self::BUYER => Yii::t('base', 'Customer'),
            self::SELLER => Yii::t('base', 'Vendor'),
        );
    }

    public function getStatusName()
    {
        $statuses = $this->getStatuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : null;
    }

    public function getTypeName()
    {
        $types = $this->getTypes();
        if ($this->sellerProfile !== null) {
            return $types[self::SELLER];
        } else {
            return $types[self::BUYER];
        }
    }

    public function getStatusNameByStatus()
    {
        $statuses = $this->getStatuses();
        return $statuses[$this->status];
    }

    public static function getAllUsers()
    {
        $users = self::model()->findAll();

        $array = array();

        foreach ($users as $one) {
            $array[$one->id] = $one->username;

        }

        return $array;
    }

    public function getUsersFromChart()
    {
        $from = new DateTime(date('Y-m-d', strtotime($this->from_date)));
        $to = new DateTime(date('Y-m-d', strtotime($this->to_date)));
        $to = $to->modify('+1 day');
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function ($item) {
                return $item->format('Y-m-d H:i:s');
            },
            iterator_to_array($period)
        );

        $result = array();
        $result['count_sellers'] = 0;
        $result['count_buyers'] = 0;

        $dataProvider = $this->search();
        $dataProvider->pagination = false;

        foreach ($arrayOfDates as $key => $value) {
            $value = date('Y-m-d', strtotime($value));
            $result['labels'][$key] = $value;
            $result['data'][0][$key] = 0;
            $result['data'][1][$key] = 0;

            foreach ($dataProvider->getData() as $user) {
                $reg_date = date('Y-m-d', strtotime($user->registration_date));
                // echo "<pre>";print_r($key);echo "</pre>";die();
                if ($user->sellerProfile && $reg_date == $value) {
                    $result['data'][0][$key]++;
                    $result['count_sellers']++;
                } else if ($reg_date == $value) {
                    $result['data'][1][$key]++;
                    $result['count_buyers']++;
                }
            }
        }
        // echo "<pre>";print_r($result);echo "</pre>";

        return $result;
    }

    public function getProductsFromChart()
    {
        $from = new DateTime(date('Y-m-d', strtotime($this->from_date)));
        $to = new DateTime(date('Y-m-d', strtotime($this->to_date)));
        $to = $to->modify('+1 day');
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function ($item) {
                return $item->format('Y-m-d H:i:s');
            },
            iterator_to_array($period)
        );

        $result = array();
        $categoryList = Category::getParrentCategoryList();

        $dataProvider = $this->search();
        $dataProvider->pagination = false;
        foreach ($categoryList as $id => $name) {
            $result['category'][$id]['count'] = 0;
            $result['totalCount'] = 0;
            $result['category'][$id]['name'] = $name;
        }
        foreach ($arrayOfDates as $key => $value) {
            $value = date('Y-m-d', strtotime($value));
            $result['labels'][$key] = $value;

            foreach ($categoryList as $id => $name) {
                $result['data'][$id][$key] = 0;
            }

            foreach ($dataProvider->getData() as $product) {
                $add_date = date('Y-m-d', strtotime($product->added_date));

                if ($add_date == $value) {
                    $result['data'][$product->category->parent->id][$key]++;
                    $result['category'][$product->category->parent->id]['count']++;
                    $result['totalCount']++;
                }
            }
        }
        // echo "<pre>";print_r($result);echo "</pre>";die();
        return $result;
    }

    public function cookiesAgree($attribute,$params)
    {
        if ($this->$attribute == 0)
            $this->addError($attribute, 'You must agree with Terms and Conditions');
    }

    public function afterValidate()
    {
        $oldUser = null;

        if($this->id){
            $oldUser = $this->model()->findByPk($this->id);
        }

        if(!$oldUser){
            $this->password = sha1($this->password); // password from form
        }else{
            if($oldUser->password != $this->password){ // password from form
                $this->password = sha1($this->password);
            } // else - old user - old password (hash from db)
        }

        if ($this->getScenario() == 'forgotPass') {
            $this->time_send = new CDbExpression('NOW()');
        }
        parent::afterValidate();
    }

    public function verifyPassword($attribute, $params)
    {
        $model = self::model()->findByPk(Yii::app()->member->id);

        if (empty($this->current_password)) {
            $this->current_password = 'blank';
        }

        if (sha1($this->current_password) != $model->password) {
            $this->addError(
                'current_password',
                Yii::t('base', 'Please, enter your current password correctly')
            );
        }
    }

    public function getSoldCount()
    {
        $sql = "SELECT count(*) as count
                    FROM `product` `p`
                    WHERE `p`.`status`='".Product::PRODUCT_STATUS_SOLD."' AND `p`.`user_id`=" . $this->id;
        $command = Yii::app()->db->createCommand($sql);
        $count = $command->queryRow();

        return $count['count'];
    }

    public function getRating($type = 'total')
    {
        //$kof = ($type == 'total') ? 2 : 1;
        $kof = 1;
        $ratings = Rating::model()->findAllByAttributes(array('seller_id' => $this->id));
        $rating = 0;
        foreach ($ratings as $key => $value) {
            $rating += $value->{$type};
        }
        if ($rating) {
            $rating = round(($rating * $kof / count($ratings)) / 0.5 * 0.5, 2);
        }

        return $rating;
    }

}
