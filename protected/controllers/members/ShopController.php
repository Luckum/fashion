<?php

class ShopController extends MemberController
{
    public $pageSize = 129;

    public $publicActions = array(
        'showCategory',
        'productDetails',
        'addToBag',
        'addToMobileBag',
        'addToMobileBagWithDiscount',
        'removeFromBag',
        'removeFromMobileBag',
        'sizeChart',
        'getSizeListForSubCat',
        'shipInfo',
        'ipn',
        'ipnVendorPay',
        'filter'
    );

    public function beforeAction($action)
    {
        if (Yii::app()->member->isGuest && !in_array($action->id, $this->publicActions)) {
            $return = new CHttpCookie('return', Yii::app()->createAbsoluteUrl(Yii::app()->controller->id . '/' . $action->id, $_POST));
            $return->expire = time() + 60 * 5;
            Yii::app()->request->cookies['return'] = $return;
            $this->redirect(Yii::app()->member->loginUrl);
        }
        if($action->id == 'cart') {
           $args = explode('/', Yii::app()->request->urlReferrer);
           $link = '';
           for($i=0; $i<5; $i++) {
               $link.= $args[$i].'/';
           }
           // $link = Yii::app()->request->urlReferrer;
            $cookie = new CHttpCookie('return_url', $link);
            $cookie->expire = time()+60*60;
            Yii::app()->request->cookies['return_url'] = $cookie;
        }
        return true;
    }

    public function actionIndex()
    {
        $this->render('index', array());
    }

    public function actionCart()
    {
        $user = User::model()->findByPk(Yii::app()->member->id);
        $this->title = 'Cart';

        $total = 0;
        foreach (Yii::app()->shoppingCart->getPositions() as $product) {
            $total += $product->getPrice();
        }
        $returnUrl = isset(Yii::app()->request->cookies['return_url']) ? Yii::app()->request->cookies['return_url']->value : '';
        $shipping_address = ShippingAddress::model()->getLastUsedShippingAddress();
        Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        $this->render(
            'cart',
            array(
                'user' => $user,
                'total' => $total,
                'shipping_address' => $shipping_address,
                'returnUrl' => $returnUrl,
            )
        );
    }

    public function actionShowCategory($category = "", $subcategory = "", $brand ="")
    {
        /*echo $category;
        echo '|';
        echo trim($subcategory);
        echo '|';
        echo $brand;*/
        //die();
        /*if (Yii::app()->request->getQuery('page')) {
            Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        }*/

        $isTopCategory = false;
        //only save filters
        if (isset($_POST['filter']) && isset($_POST['is_save_filters'])) {
            Filters::model()->setFilter($_POST['filter'], array());
            Yii::app()->end();
        }

        if ($subcategory == 'brands') {
            // Получаем список брэндов по категориям.
            $brands = UtilsHelper:: byAlphabetCat(Brand:: getAllBrands());
            // $this->title = 'Fashion brands';
            $this->render('all_brands', array(
                'alphabet' => UtilsHelper:: getAlphabet(array('#')),
                'brands' => $brands
            ));
            Yii::app()->end();
        }
        //$model = (empty($subcategory)) ? Category::model()->findByPath('brands/' . $category) : Category::model()->findByPath($category . '/' . $subcategory);
        if (empty($category) && empty($subcategory)) {
            $model = array();
        } elseif(empty($subcategory)) {
            $model = Category::model()->findByPath($category . '/' . $category);
            if ($model) {
                $isTopCategory = true;
            }
            if (!$model) {
                $model = Category::model()->findByPath('designers/' . $category);
                $brand = $category;
            }
            if (!$model) {
                $url = explode('/', trim($category, '/'));
                $model = Category::model()->findByPath($url[1] . '/' . $url[2]);
                $brand = $url[0];
            }
        } else {
            $model = Category::model()->findByPath($category . '/' . $subcategory);
        }
        if (!$model) {
            if (!empty($category) || !empty($subcategory)) {
                $this->redirect(array('members/shop/showCategory', 'category' => 'brands', 'subcategory' => 'brands'));
            }            
        }

        $categories = explode('/', trim($category, '/'));
        if ($categories[0] == 'parent') {
            $this->render('parent_category', array(
                'model' => $model,
            ));
            Yii::app()->end();
        }
        
        if (!isset($model->name) && !empty($category) && !empty($brand)) {
            $brand_db = Brand::model()->findByAttributes(['url' => $brand]);
            $this->title = $brand_db->name . ' ' . $model->getNameByLanguage()->header_text . ' for Women | N2315';
            $this->meta_description = $data['seo_description'];
        } elseif (isset($model->categoryNames) && count($model->categoryNames)) {
            $data = $model->categoryNames[0];
            $this->title = $data['seo_title'];
            $this->meta_description = $data['seo_description'];
            //$this->meta_keywords = $data['seo_keywords'];
        } elseif (isset($model->name)) {
            //$this->title = $model->name . " | " . Yii::t('base', 'shop designer fashion') . " | 23-15";
            $this->title = $model->name . " - Shop Designer Womenswear at N2315.COM";
            $this->meta_description = "Discover new arrivals from " . $model->name . ". Shop luxury brands and emerging designers from best online shopping sites across the web.";
        } else {
            $this->title = "Shop | " . Yii::t('base', 'shop designer fashion') . " | N2315";
        }
        
        $order = 't.added_date DESC';

        if (isset($_POST['filter'])) {
            $_GET['page'] = 1;
        } 

        $page = (isset($_GET['page']) ? $_GET['page'] : 1);

        $where = array('and');
        $limit = $this->pageSize;
        $offset = ($page - 1) * $this->pageSize;

        $sessionSortId = $category . $subcategory . 'sort';

        if (isset($_GET[ShopConst::SORT]) && Yii::app()->request->isAjaxRequest) {
            $sortValue = $_GET[ShopConst::SORT];
            Yii::app()->session[$sessionSortId] = $_GET[ShopConst::SORT];
        }

        if (!Yii::app()->request->isAjaxRequest && isset(Yii::app()->session[$sessionSortId])) {
            $sortValue = Yii::app()->session[$sessionSortId];
            $_GET[ShopConst::SORT] = Yii::app()->session[$sessionSortId];
        }

        if (isset($sortValue) && $sortValue == ShopConst::SORT_DATE) {
            $order = ShopConst::SORT_DATE_DESC;
        } elseif (isset($sortValue) && $sortValue == ShopConst::SORT_SALE) {
            array_push($where, ShopConst::SORT_SALE_CONDITION);
        } elseif (isset($sortValue) && $sortValue == ShopConst::SORT_PRICE_FROM_LOW) {
            $order = ShopConst::SORT_PRICE_ASC;
        } elseif (isset($sortValue) && $sortValue == ShopConst::SORT_PRICE_FROM_HIGH) {
            $order = ShopConst::SORT_PRICE_DESC;
        } elseif (isset($sortValue) && $sortValue == 'selection') {
            $order = ShopConst::SORT_OUR_SELECTION;
        }

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['filter']) && isset($_POST['model']) && isset($_POST['model_id'])) {
                $filters = $_POST['filter'];
                list($filter_model, $where) = Filters::model()->setFilter($filters, $where, false);
            } else {
                list($filter_model, $where) = Filters::model()->getFilter($where);
            }

            $brand_title = '';
            if (!empty($brand)) {
                $brand_db = Brand::model()->findByAttributes(['url' => $brand]);
                $brand_title = $brand_db->name;
                $where[] = 't.brand_id = ' . $brand_db->id;
            }
            $item_count = Product::model()->getCountShopProducts($model, $where, $isTopCategory, $isTopCategory);

            $pages = new Pagination($item_count);
            $pages->pageSize = $this->pageSize;

            if (isset($_GET['pageSize']) && $_GET['pageSize'] == 'all') {
                $pages->pageSize = $item_count;
                $limit = $item_count;
                $offset = 0;
            }

            $products = Product::model()->getShopProducts($model, $where, $limit, $offset, $order, $isTopCategory);

            $this->renderPartial('_products_form',
                array(
                    'model' => $model,
                    'products' => $products,
                    'pages' => $pages,
                    'filters' => $filter_model,
                    's_category' => $category,
                    's_subcategory' => trim($subcategory),
                    's_brand' => $brand,
                    's_brand_title' => $brand_title,
                )
            );

            Yii::app()->end();
        }

        list($filter_model, $where) = Filters::model()->getFilter($where);
        $brand_title = '';
        if (!empty($brand)) {
            $brand_db = Brand::model()->findByAttributes(['url' => $brand]);
            $brand_title = $brand_db->name;
            $where[] = 't.brand_id = ' . $brand_db->id;
        }
        $item_count = Product::model()->getCountShopProducts($model, $where, $isTopCategory);

        $pages = new Pagination($item_count);
        $pages->pageSize = $this->pageSize;

        if (isset($_GET['pageSize']) && $_GET['pageSize'] == 'all') {
            $pages->pageSize = $item_count;
            $limit = $item_count;
            $offset = 0;
        }

        $products = Product::model()->getShopProducts($model, $where, $limit, $offset, $order, $isTopCategory);
        $brands_all = UtilsHelper::byAlphabetCat(Brand::getAllBrands());

        $this->render('category', array(
            'model' => $model,
            'products' => $products,
            'pages' => $pages,
            'filters' => $filter_model,
            's_category' => $category,
            's_subcategory' => $subcategory,
            's_brand' => $brand,
            's_brand_title' => $brand_title,
            'brands_all' => $brands_all,
            'alphabet' => UtilsHelper:: getAlphabet(array('#')),
        ));
    }


    public function actionFilter()
    {
        $request = Yii::app()->request;
        $query = $request->getUrl();

        $sort = ShopConst::SORT_DATE_DESC;
        $where = "status = '".Product::PRODUCT_STATUS_ACTIVE."'";

        if (isset($_GET[ShopConst::SORT])) {
            $sort = $_GET[ShopConst::SORT];
        }

        switch ($sort) {
            case ShopConst::SORT_DATE:
                $sort = ShopConst::SORT_DATE_DESC;
                break;
            case ShopConst::SORT_PRICE_FROM_LOW:
                $sort = ShopConst::SORT_PRICE_ASC;
                break;
            case ShopConst::SORT_PRICE_FROM_HIGH:
                $sort = ShopConst::SORT_PRICE_DESC;
                break;
            case ShopConst::SORT_SALE:
                $where = ShopConst::SORT_SALE_CONDITION;
                $sort = '';
                break;
        }

        $totalCriteria = FilterHelper::getCriteria($query, $where);
        $totalCount = Product::model()->count($totalCriteria);

        $pageSize = $this->pageSize;

        if (isset($_GET[ShopConst::PAGE_SIZE])) {
            $pageSize = $_GET[ShopConst::PAGE_SIZE] == ShopConst::PAGE_SIZE_ALL ? $totalCount : $this->pageSize;
        }

        $page = isset($_GET[ShopConst::PAGE]) ? (int)$_GET[ShopConst::PAGE] : 1;

        $offset = ($pageSize == $totalCount) ? 0 : ($page - 1) * $this->pageSize;

        $criteria = FilterHelper::getCriteria($query, $where, $sort, $pageSize, $offset);
        $products = Product::model()->findAll($criteria);

        $pages = new Pagination($totalCount);
        $pages->pageSize = $pageSize;
        Yii::app()->clientScript->registerMetaTag('noindex','robots');
        if ($request->isAjaxRequest) {
            $this->renderPartial('_filter', array(
                'products' => $products,
                'pages' => $pages
            ));

            Yii::app()->end();
        }

        $this->render('filter', array(
            'products' => $products,
            'pages' => $pages
        ));
    }

    public function actionProductDetails($id)
    {
        $futureurl = strtolower(str_replace(" ", "-", $id));
        $futureAr = explode("-", $futureurl);
        $searchid = array_pop($futureAr);
        $model = Product::model()->findByPk($searchid);
        
        if ($model && ($model->isVisible || $model->isSold)) {
            $isCanAddCommentsAndMakeOffers = $model->canUserAddCommentsAndMakeOffers();
            // meta тэги.
            //$this->meta_description = $model->description;
            $this->meta_description = 'Shop ' . ucwords($model->title) . ' from top fashion designer ' . $model->brand->name . '. Explore new arrivals from best clothing stores online.';
            // Заголовок.
            $this->title = $model->brand->name . ' ' . ucwords($model->title) . ' | ' . Yii::app()->params['seo']['site_name'];
            $attributes = $model->getProductAttributes($model->id);
            $attributes = array_filter($attributes, function($el) {
                return $el['isActive'] && !empty($el['definedValue']);
            });

            $this->render('product_details', array(
                'model' => $model,
                'attributes' => $attributes,
                'isCanAddCommentsAndMakeOffers' => $isCanAddCommentsAndMakeOffers,
            ));
        } else {
            $this->redirect('/');
        }
    }

    public function actionShippingRate()
    {
        if (isset($_POST['id'])) {
            if (empty($_POST['id'])) {
                echo '';
                Yii::app()->end();
            }
            $_POST['shipping_country_id'] = $_POST['id'];

            echo ShippingRate::model()->getShippingRate();
        }
        Yii::app()->end();
    }

    public function actionShipInfo()
    {
        if (isset($_POST)) {
            $rates = ShippingRate::model()->getRatesByCountries();

            $this->renderPartial('ship_info', array('rates' => $rates), false, true);
        }
        Yii::app()->end();
    }

    public function actionSizeChart()
    {
        if (isset($_POST['cat_id'])) {

            // Категория товара.
            $category = Category:: model()->findAllByPk($_POST['cat_id']);
            // Получаем список размеров для указанной категории.
            $sizes = SizeChart:: model()->getSizes($category[0]['size_chart_cat_id']);

            $this->renderPartial('size_info', array(
                'cat_name' => $category[0]['alias'],
                'sizes' => $sizes
            ));

        }
        Yii::app()->end();
    }

    public function actionNewComment()
    {
        // Только Ajax-запрос.
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }
        // Проверяем входные параметры.
        if (!isset($_POST['id'], $_POST['comment']) ||
            !is_numeric($_POST['id']) ||
            !strlen($_POST['comment'])
        ) {
            throw new CHttpException(400, 'Bad Request');
        }
        // Добавляем новый комментарий.
        if (($comment = (new Comments())->addComment())) {
            // Комментарий успешно добавлен.
            die(CJSON:: encode(array(
                'result' => 'ok',
                'html' => $this->renderPartial('_comment', array('comment' => $comment), true)
            )));
        } else {
            // Не удалось сохранить комментарий.
            die(CJSON:: encode(array(
                'result' => 'error'
            )));
        }
    }

    public function actionMakeOffer()
    {
        if (isset($_POST['id'], $_POST['new_price']) &&
            is_numeric($_POST['id']) &&
            is_numeric($_POST['new_price'])
        ) {
            $offer = new Offers;
            $product = Product::model()->findByPk($_POST['id']);
            if (!$product->isVisible) Yii::app()->end();
            if (!$product->canUserAddCommentsAndMakeOffers()) Yii::app()->end();
            $offer->makeOffer($product);
            $seller = User::model()->findByPk($offer->product->user_id);

            $tmpl = Template::model()->find("alias = 'offer_made' AND language = :lang", array(':lang' => Yii::app()->getLanguage()));

            if (count($tmpl)) {
                $parameters = EmailHelper::setValues($tmpl->content, array(
                    $offer, $offer->user, $offer->product
                ));
                $message = Yii::t('base', $tmpl->content, $parameters);
                $mail = new Mail;
                $mail->send($seller->email, $tmpl->subject, $message, $tmpl->priority);
            }
        }
        Yii::app()->end();
    }

    public function actionAddToBag()
    {
        if (isset($_POST['id'])) {
            $product = Product::model()->findByPk($_POST['id']);
            if ($product->isVisible) {
                Yii::app()->shoppingCart->put($product);
            }

            $this->renderPartial('_cart', array('model' => $product), false, true);
        }
        Yii::app()->end();
    }

    public function actionAddToMobileBag()
    {
        $this->renderPartial('_cart_mobile', array(), false, true);

        Yii::app()->end();
    }

    public function actionAddToBagWithDiscount()
    {
        if (!isset($_POST['product']) || !isset($_POST['offer'])) Yii::app()->end();;

        $product_id = (int)$_POST['product'];
        $offer_id = (int)$_POST['offer'];

        $product = Product::model()->findByPk($product_id);
        $offer = Offers::model()->findByPk($offer_id);

        if (!$product || !$offer) Yii::app()->end();

        if (!$product->isVisible) Yii::app()->end();

        if ((int)$offer->confirm !== 1) Yii::app()->end(); // ------------- protect from hacker's offer
        if ($product->id !== $offer->product->id) Yii::app()->end(); // --  protect from hacker's offer

        $product->price_memory = $offer->offer; // memory after unserialize
        $product->price = $offer->offer;

        Yii::app()->shoppingCart->put($product);

        $this->renderPartial('_cart', array(
            'model' => $product
        ), false, true);

        Yii::app()->end();
    }

    public function actionAddToMobileBagWithDiscount(){
        $this->renderPartial('_cart_mobile', array(), false, true);

        Yii::app()->end();
    }

    public function actionRemoveFromBag()
    {
        if (isset($_POST['id']) && isset($_POST['checkout'])) {
            $user = User::model()->findByPk(Yii::app()->member->id);
            Yii::app()->shoppingCart->remove($_POST['id']);
            $this->renderPartial('_checkout_cart', array('user' => $user), false, true);
        } elseif (isset($_POST['id'])) {
            Yii::app()->shoppingCart->remove($_POST['id']);
            $this->renderPartial('_cart', array(), false, true);
        }
        Yii::app()->end();
    }

    public function actionRemoveFromMobileBag()
    {
        //debug
//        $this->renderPartial('_cart_mobile', array(), false, true);
//        Yii::app()->end();
        //end debug

        if (isset($_POST['id']) && isset($_POST['checkout'])) {
            $user = User::model()->findByPk(Yii::app()->member->id);
            Yii::app()->shoppingCart->remove($_POST['id']);
            $this->renderPartial('_checkout_cart', array('user' => $user), false, true);
        } elseif (isset($_POST['id'])) {
            Yii::app()->shoppingCart->remove($_POST['id']);
            $this->renderPartial('_cart_mobile', array(), false, true);
        }
        Yii::app()->end();
    }

    public function actionRemoveFromBagGetNewData()
    {
        if (isset($_POST['id'])) {
            Yii::app()->shoppingCart->remove($_POST['id']);
            $cart_bag_count = Yii::app()->shoppingCart->getItemsCntText();
            $cart = $this->renderPartial('_cart', array(), true, true);
            $cart_cost = 0;
            foreach (Yii::app()->shoppingCart->getPositions() as $product) {
                $cart_cost += $product->getPrice();
            }

            $shipping_cost = 0;
            if (isset($_POST['shipping_country_id']) && is_numeric($_POST['shipping_country_id'])) {
                $shipping_cost = ShippingRate::model()->getShippingRate();
            }
            $total_cost = $shipping_cost + $cart_cost;
            echo json_encode(
                array(
                    'cart' => $cart,
                    'cart_bag_count' => $cart_bag_count,
                    'cart_cost' => $cart_cost,
                    'shipping_cost' => $shipping_cost,
                    'total_cost' => $total_cost,
                )
            );
        }
        Yii::app()->end();
    }

    public function actionSaveShipAddr()
    {
        if (isset($_POST['country_id']) && isset($_POST['address']) && isset($_POST['address2']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip'])) {
            ShippingAddress::model()->actualAddress();
        }
        Yii::app()->end();
    }

    public function actionPay()
    {
        if (isset($_GET['paypal_return'])) {
//            Yii::app()->user->setFlash('payment_info',
//                Yii::t('base', 'Thank you for your payment! Your transaction has been completed.'));
//            $this->redirect(array('/my-account'));
            $order = array();
            $inYourCart = '';
            $shipping_cost = '';
            $total = '';
            if (isset($_GET['order_id'])) {
                $order = Order::model()->findByPk($_GET['order_id']);
                if ($order) {
                    $total = $order->total;
                    $shipping_cost = $order->shipping_cost;
                    $inYourCart = $total - $shipping_cost;
                }
            }
            $this->render(
                'cart',
                array(
                    'orderComplete' => true,
                    'inYourCart' => $inYourCart,
                    'shipping_cost' => $shipping_cost,
                    'total' => $total,
                )
            );
        }

        if (isset($_GET['paypal_cancel'])) {
            Yii::app()->user->setFlash('payment_info',
                Yii::t('base', 'Paypal payment was canceled'));
            $this->redirect(array('/my-account'));
        }

        if (isset($_POST['country_pay']) && !empty($_POST['country_pay'])
            && isset($_POST['address']) && !empty($_POST['address'])
            && isset($_POST['city']) && !empty($_POST['city'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['zip_code']) && !empty($_POST['zip_code'])
            && isset($_POST['firstname']) && !empty($_POST['firstname'])
            && isset($_POST['lastname']) && !empty($_POST['lastname'])
            && isset($_POST['phone']) && !empty($_POST['phone'])
        ) {
            $shipping_address = ShippingAddress::model()->actualAddress();

            $total = 0;
            foreach (Yii::app()->shoppingCart->getPositions() as $product) {

                if (!UtilsHelper::isValidProductPrice($product)) {
                    Yii::app()->user->setFlash('danger', Yii::t('base', 'Your cart is not valid'));
                    $this->redirect('/cart');
                }

                $total += $product->getPrice();
            }

            if ($total == 0) {
                Yii::app()->user->setFlash('danger', Yii::t('base', 'Your cart is empty.'));
                $this->redirect(array('/cart'));
            }

            $shipping_cost = 0;
            $shipping_ar = array();
            if (isset($_POST['shipping_country_id']) && is_numeric($_POST['shipping_country_id'])) {
                list($shipping_cost, $shipping_ar) = ShippingRate::model()->getShippingRate(null, null, true);
                $total += $shipping_cost;
            }

            $order = new Order;
            $order->createOrder($total, $shipping_address->id, Yii::app()->session['paymentId'], $shipping_cost);

            $order_id = Yii::app()->db->getLastInsertId();

            $storedProductIds = array();
            $direct_url = '';
            foreach (Yii::app()->shoppingCart->getPositions() as $product) {
                $order_item = new OrderItem;
                $shipping_cost = isset($shipping_ar[$product->id]) ? $shipping_ar[$product->id] : 0;
                $order_item->addOrderItem($order_id, $product, $shipping_cost);
                $storedProductIds[] = $product->getId();
                if($product->external_sale)
                    $direct_url = $product->direct_url;
            }
            if($direct_url) {
                $this->redirect($direct_url);
            } else {
                $errorMessage = $order->pay($storedProductIds);
                Yii::app()->user->setFlash('danger', Yii::t('base', 'Sorry, paypal payment error has occured') . '. ' . $errorMessage);
                $this->redirect(array('/cart'));
            }
            
        } else {
            Yii::app()->user->setFlash('danger', Yii::t('base', 'Sorry, some error has occured'));
            $this->redirect(array('/cart'));
        }
    }

    public function actionIpn($id = '')
    {
        PaypalLog::log(array($id, $_POST));
        if (empty($id)) {
            if (isset($_POST['invoice']) && is_numeric($_POST['invoice'])) {
                $id = $_POST['invoice'];
            } else {
                die();
            }
        }
        $model = Order:: model()->with('orderItems')->findByPk($id);
        if ($model) {
            $model->ipn($id);
        }
    }

    public function actionIpnVendorPay($id)
    {
        PaypalLog::log(array($id, $_POST));
        $model = OrderItem::model()->findByPk($id);

        $model->ipn($model);
    }

    public function actionToggleWishlist()
    {
        if (isset($_POST['id'])) {
            echo Wishlist::model()->changeWish($_POST['id']);
        }
        Yii::app()->end();
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admins-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Пожаловаться (Report Item).
     */
    public function actionReport()
    {
        // Только Ajax-запрос.
        if (!Yii:: app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Проверяем входные данные.
        if (!isset($_POST['pid'], $_POST['prf'], $_POST['pge'], $_POST['cmp']) ||
            !is_numeric($_POST['pid']) ||
            !strlen($_POST['prf']) ||
            !strlen($_POST['pge']) ||
            !strlen($_POST['cmp'])
        ) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Сохраняем жалобу.
        $report = new ProductReport;
        if ($report->addReport()) {
            // Жалоба успешно сохранена.
            die(CJSON:: encode(array(
                'result' => 'ok'
            )));
        } else {
            // Не удалось сохранить жалобу.
            die(CJSON:: encode(array(
                'result' => 'error'
            )));
        }
    }

    public function actionAjaxGetAttributes()
    {
        if (empty($_POST['categoryId']) || !is_numeric($_POST['categoryId'])) {
            throw new CHttpException(400, 'Bad Request');
        }

        $categoryId = intval($_POST['categoryId']);
        return AttributeHelper::renderAttributesByCategoryId($categoryId, true);
    }







    /*
      DON'T DELETE! UNCOMMENT FOR CLONING OF PRODUCT IMAGE!
     */
    // uncomment for clone original product photo to medium copy
    //
//    public function actionCloneMedium(){
//        $webroot = Yii::getPathOfAlias('webroot');
//        $parent_dir = $webroot . ShopConst::IMAGE_MAX_DIR;
//        $child_dir = $webroot . ShopConst::IMAGE_MEDIUM_DIR;
//        $quality = Yii::app()->params['image_settings']['quality'];
//        $width = Yii::app()->params['image_settings']['max_medium_width'];
//        $height = Yii::app()->params['image_settings']['max_medium_height'];
//
//        ImageHelper::cloneImages($parent_dir, $child_dir, $width, $height, $quality);
//    }


    // uncomment for clone original product photo to thumbnail copy
    //
//    public function actionCloneThumbnail(){
//        $webroot = Yii::getPathOfAlias('webroot');
//        $parent_dir = $webroot . ShopConst::IMAGE_MAX_DIR;
//        $child_dir = $webroot . ShopConst::IMAGE_THUMBNAIL_DIR;
//        $quality = Yii::app()->params['image_settings']['quality'];
//        $width = Yii::app()->params['image_settings']['max_thumbnail_width'];
//        $height = Yii::app()->params['image_settings']['max_thumbnail_height'];
//
//        ImageHelper::cloneImages($parent_dir, $child_dir, $width, $height, $quality);
//    }
}


















