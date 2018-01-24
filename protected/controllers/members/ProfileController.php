<?php

class ProfileController extends MemberController
{
    const UNREAD_COMMENTS_COUNT = 'unrComCount';
    const UNREAD_OFFERS_COUNT = 'unrOffCount';
    const UNREAD_RESPONSES_COUNT = 'unrRespCount';
    const UNREAD_INFO = 'unreadInfo';

    public $publicActions = array('showProfile');

    public function beforeAction($action)
    {
        if ($action->id == 'getSubcategory' || $action->id == 'fileUpload') return true;
        if ($action->id == 'sell') {
            $return = new CHttpCookie('return', Yii::app()->createAbsoluteUrl(Yii::app()->controller->id . '/' . $action->id, $_REQUEST));
            $return->expire = time() + 60 * 5;
            Yii::app()->request->cookies['return'] = $return;
            return true;
        }
        if (Yii::app()->member->isGuest && (!in_array($action->id, $this->publicActions) || !isset($_GET['id']))) {
            $return = new CHttpCookie('return', Yii::app()->createAbsoluteUrl(Yii::app()->controller->id . '/' . $action->id, $_REQUEST));
            $return->expire = time() + 60 * 5;
            Yii::app()->request->cookies['return'] = $return;

            $this->redirect(Yii::app()->member->loginUrl);
        }

        return true;
    }

    public function actionIndex()
    {
        $model = Product:: model()
            ->active()
            ->with('size_chart')
            ->findAllByAttributes(array('user_id' => Yii::app()->member->id));
        $user = User:: model()->findByPk(Yii:: app()->member->id);

        $this->title = 'User ' . $user->username . ' Profile';

        self:: setUnreadInfo();

        $this->render('index', array(
            'model' => $model,
            'user' => $user,
        ));
    }

    public function actionShowProfile($id)
    {
        $model = Product::model()->active()->findAllByAttributes(array('user_id' => $id));
        $user = User::model()->findByPk($id);

        $this->title = 'User ' . $user->username . ' Profile';

        if (!$user) {
            throw new CHttpException(404, 'User profile cannot be found.');
        }

        $this->render('index', array(
            'model' => $model,
            'user' => $user,
            'showProfile' => true,
        ));
    }

    public function actionHistory()
    {
        $user = User::model()->findByPk(Yii::app()->member->id);

        $this->title = 'User ' . $user->username . ' History';

        $this->render('history', array(
            'user' => $user,
            'items_sold' => Order::getSoldOrders(),
        ));
    }

    public function actionInbox()
    {
        $model = Product::model()->active()->findAllByAttributes(array('user_id' => Yii::app()->member->id));
        $user = User::model()->findByPk(Yii::app()->member->id);
        $offers = Offers::getOffersForSeller();
        $responses = Offers::getOffersForBuyer();
        $myOffers = Offers::getOffersFromBuyer();

        $allComments = array();
        $productIds = CHtml::listData($model, 'id', 'id');
        $allComments = Comments::getComments($productIds);
        list($commentsForVisibleBlock, $commentsForHiddenBlock) = Comments::splitCommentsArray($allComments);

        self::setUnreadInfo();
        $unreadInfo = ProfileController::getUnreadInfo();

        $offers_responses = $this->offer_mix($offers, $responses);

        $this->title = 'User ' . $user->username . ' Inbox';
        $this->render('inbox', array(
            'model' => $model,
            'offers_responses' => $offers_responses,
            'my_offers_responses' => $myOffers,
            'user' => $user,
            'unreadInfo' => $unreadInfo,
            'commentsForVisibleBlock' => $commentsForVisibleBlock,
            'commentsForHiddenBlock' => $commentsForHiddenBlock,
        ));
    }

    public function actionReplyComment()
    {
        $user = User::model()->findByPk(Yii::app()->member->id);

        if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_POST['id'])) {
            $reply = new Comments;
            if ($comment = $reply->addComment(true)) {
                $this->renderPartial('_comments', array('comment' => $comment, 'user' => $user), false, true);
            } else {
                echo 0;
            }
        } elseif (isset($_GET['id'])) {
            $this->renderPartial('_reply', array('id' => $_GET['id']), false, true);
        }

        Yii::app()->end();
    }

    public function actionSettings()
    {
        $model = User::model()->findByPk(Yii::app()->member->id);

        $message = null;

        $this->title = 'User ' . $model->username . ' Settings';

        if ($model->sellerProfile) {
            $modelSellerProfile = $model->sellerProfile;
        } else {
            $modelSellerProfile = new SellerProfile;
        }

        $modelShippingAddresses = ShippingAddress::model()->getLastUsedShippingAddress();

        if (isset($_POST['User'])) {
            if (!empty($_POST['User']['password'])) {
                $model->setScenario('changePassWithoutCurrent');
                $model->attributes = $_POST['User'];
                if ($model->save()) {
                    $message = Yii::t('base', 'Your changes have been successfully saved');
                }
            } else {
                $model->username = $_POST['User']['username'];
                $model->email = $_POST['User']['email'];
                $model->country_id = $_POST['User']['country_id'];
                if ($model->save()) {
                    Yii :: app() -> member -> username = $model -> username;
                    $message = Yii::t('base', 'Your changes have been successfully saved');
                }
            }
        }

        $modelShippingAddresses->scenario = 'saving_profile_settings';
        $modelSellerProfile->scenario = 'saving_profile_settings';

        if (isset($_POST['ShippingAddress'])) {
            $modelShippingAddresses->attributes = $_POST['ShippingAddress'];
            $modelShippingAddresses->user_id = $model->id;
            $modelShippingAddresses->last_used = 1;

            if ($modelShippingAddresses->save()) {
                //$message .= Yii::t('base', 'Shipping information has been successfully saved.') . '<br />';
                $message = Yii::t('base', 'Your changes have been successfully saved');
            }

            if (isset($_POST['SellerProfile'])) {
                $modelSellerProfile->attributes = $_POST['SellerProfile'];

                $modelSellerProfile->user_id = $model->id;
                if (empty($modelSellerProfile->seller_type)) {
                    $modelSellerProfile->seller_type = 'private';
                }
                $modelSellerProfile->comission_rate = Yii::app()->params['payment']['default_comission_rate'];

                if ($modelSellerProfile->save()) {
                    //$message .= Yii::t('base', 'Billing and bank details has been successfully saved.') . '<br />';
                    $message = Yii::t('base', 'Your changes have been successfully saved');
                }
            }
        }

        $this->render('settings', array(
            'model' => $model,
            'sellerProfile' => $modelSellerProfile,
            'shippingAddresses' => $modelShippingAddresses,
            'message' => $message
        ));
    }

    public function actionAlerts()
    {
        // Пользователь.
        $uid = isset($_GET['id']) ? $_GET['id'] : Yii:: app()->member->id;
        $user = User:: model()->findByPk($uid);

        // Заголовок страницы.
        $this->title = 'User ' . $user->username . ' Alerts';

        $model = new Alerts;
        $model->unsetAttributes();

        if (isset($_POST['Alerts'])) {

            $model->attributes = $_POST['Alerts'];
            $model->user_id = $uid;

            if ($model->save()) {
                Yii:: app()->member->setFlash('add_alert', Yii:: t('base', 'New alert has been successfully added'));
            }
        }

        $this->render('alerts', array(
            'model' => $model,
            'alerts' => Alerts:: model()
                ->with(array('size_chart', 'subcategory'))
                ->findAll('user_id = ' . $uid),
            'user' => $user
        ));
    }

    public function actionAlertsUpdate($alert_id)
    {
        $model = Alerts::model()->findByPk($alert_id);

        $user = User::model()->findByPk(Yii::app()->member->id);
        $this->title = 'User ' . $user->username . ' Alerts Update';

        if (isset($_POST['Alerts'])) {
            $model->attributes = $_POST['Alerts'];
            if ($model->save()) {
                //Yii::app()->user->setFlash('edit_alert', Yii::t('base', 'Alert has been successfully edit.'));
                $this->redirect(array('/my-account/alerts'));
            }
        }

        $this->render('edit_alerts', array(
            'model' => $model,
            'user' => $user
        ));
    }

    public function actionDeleteAlert($alert_id)
    {
        Alerts::model()->findByPk($alert_id)->delete();

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('alerts'));
    }

    public function actionGetSubcategory()
    {
        if (!count($_POST)) {
            throw new CHttpException(404, 'Not found');
        }
        if (isset($_POST['Alerts'])) {
            $sql = 'SELECT * FROM `category` WHERE parent_id='.intval($_POST['Alerts']['category_id']).' ORDER BY `category`.`menu_order` ASC ';
            $list = Category::model()->findAllBySql($sql);
        } elseif (isset($_POST['Product']['parentCategory'])) {
            if (empty($_POST['Product']['parentCategory'])) {
                return;
            }
            $sql = 'SELECT * FROM `category` WHERE parent_id='.intval($_POST['Product']['parentCategory']).' ORDER BY `category`.`menu_order` ASC ';
            $list = Category::model()->findAllBySql($sql);
        }

        echo CHtml::tag('option',
            array('value' => ''), CHtml::encode(Yii::t('base', 'select subcategory')), true);
        foreach ($list as $category) {
            echo CHtml::tag('option',
                array('value' => $category->id), CHtml::encode($category->getNameByLanguage()->name), true);
        }
    }

    public function actionSell()
    {
        $model = new Product;
        $model->unsetAttributes();
        $model->setScenario('sell');

        $this->title = 'Sell designer clothing, shoes, accessories | 23-15';
        $this->meta_description = 'Sell designer clothing, shoes, bags and accessories for women, men, unisex. ';

        if (!$seller = SellerProfile::model()->findByAttributes(array('user_id' => Yii::app()->member->id))) {
            $seller = new SellerProfile;
            $seller->user_id = Yii::app()->member->id;
            $seller->comission_rate = Yii::app()->params['payment']['default_comission_rate'];
        }

        $isValidBrand = true;
        if (isset($_POST['Product'])) {
            if (Yii::app()->member->isGuest) {
                $this->redirect(array('/members/profile/sell'));
            }

            $model->attributes = $_POST['Product'];       
            $seller->attributes = $_POST['SellerProfile'];

            $model->user_id = Yii::app()->member->id;
            $model->status = Product::PRODUCT_STATUS_DEACTIVE;

            $brandInfo = isset($_POST['Product']['brand_id']) ? $_POST['Product']['brand_id'] : '';
            if (!is_numeric($brandInfo) || !Brand::model()->findByPk($brandInfo)) {
                $brandInfo = Brand::getFormatedTitle($brandInfo);
                if (!($brand = Brand::model()->find('name = :name', array(':name' => $brandInfo)))) {
                    $brand = new Brand();
                    $brand->name = $brandInfo;

                    if (!$brand->save()) {
                        $isValidBrand = false;
                    } else {
                        $model->brand_id = $brand->id;
                    }
                } else {
                    $model->brand_id = $brand->id;
                }
            }

            $seller->validate();
            $model->validate();

            /* START convert images from PNG TO JPEG */
            $image_array = array('image1' => $model->image1,'image2' => $model->image2, 'image3' => $model->image3, 'image4' => $model->image4, 'image5' => $model->image5);

            foreach ($image_array as $key=>$image) {
                $info = pathinfo($image);               
                if(!empty($image) && ($info['extension'] == 'png' OR $info['extension'] == 'PNG')) {                              
                    $im = Product::model()->convertImage($image);
                    $model->$key = $im;
                }               
            }            
            /* END convert images from PNG TO JPEG */
            if ($isValidBrand && $seller->save() && $model->save()) {             
                $tmpl = Template :: model()->find("alias = 'product_require_confirm' AND language = :lang", array(':lang' => $seller->user->language));
                if (count($tmpl)) {
                    $mail = new Mail;
                    $parameters = EmailHelper::setValues($tmpl->content, array(
                        $model, $seller, $seller->user
                    ));
                    $message = Yii::t('base', $tmpl->content, $parameters);
                    $mail->send(
                        Yii::app()->params['misc']['adminEmail'],
                        $tmpl->subject,
                        $message,
                        $tmpl->priority
                    );
                }

                $tmpl = Template:: model()->find("alias = 'submit_item' AND language = :lang", array(':lang' => $seller->user->language));
                if (count($tmpl)) {
                    $mail = new Mail;
                    $parameters = EmailHelper::setValues($tmpl->content, array(
                        $model, $seller, $seller->user
                    ));
                    $message = Yii::t('base', $tmpl->content, $parameters);
                    $mail->send(
                        $seller->user->email,
                        $tmpl->subject,
                        $message,
                        $tmpl->priority
                    );
                }

                Yii::app()->member->setFlash('product_add', Yii::t('base', 'Thank you for selling with us!'));

                $this->redirect(array('members/profile/sell'));

            }
        }

        $this->render('sell_product', array(
            'model' => $model,
            'seller' => $seller
        ));
    }    

    public function actionSellUpdate($id)
    {
        // Модель продукта с указанным ID.
        $model = Product :: model() -> findByPk($id);

        if (!$model->isVisible) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // Проверяем права пользователя на редактирование данного продукта.
        if ((int)Yii :: app() -> member -> id !== (int)$model -> user_id) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Подсвечиваем указанные админом поля,
        // требующие исправления + отображаем лейблы всех некорректных полей в заголовке страницы.
        if (isset($_GET['wrong_fields']) && strlen($_GET['wrong_fields'])) {
            $labels = [];
            $fields = explode(',', $_GET['wrong_fields']);
            foreach ($fields as $item) {
                $model -> addError($item, Yii :: t('base', '*required'));
                $labels[] = $model -> getAttributeLabel($item);
            }
            $wfDesc = Yii :: t('base', 'The following fields need to be corrected: ' . implode(', ', $labels));
        }

        $model->setScenario('sellUpdate');

        $this->title = 'Sell Update';
        $this->meta_description = 'Sell designer clothing, shoes, bags and accessories for women, men, unisex. ';

        $seller = SellerProfile::model()->findByAttributes(array('user_id' => Yii::app()->member->id));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Product'])) {

            $model->attributes = $_POST['Product'];
            $seller->attributes = $_POST['SellerProfile'];

            $isValidBrand = true;
            $brandInfo = isset($_POST['Product']['brand_id']) ? $_POST['Product']['brand_id'] : '';
            if (!is_numeric($brandInfo) || !Brand::model()->findByPk($brandInfo)) {
                $brandInfo = Brand::getFormatedTitle($brandInfo);
                if (!($brand = Brand::model()->find('name = :name', array(':name' => $brandInfo)))) {
                    $brand = new Brand();
                    $brand->name = $brandInfo;

                    if (!$brand->save()) {
                        $isValidBrand = false;
                    } else {
                        $model->brand_id = $brand->id;
                    }
                } else {
                    $model->brand_id = $brand->id;
                }
            }

            // После обновления продукта, его статус становится 'new'.
            $model -> status = Product :: PRODUCT_STATUS_DEACTIVE;

            $seller->validate();
            $model->validate();
            /* START convert images from PNG TO JPEG */
            $image_array = array('image1' => $model->image1,'image2' => $model->image2, 'image3' => $model->image3, 'image4' => $model->image4, 'image5' => $model->image5);

            foreach ($image_array as $key=>$image) {
                $info = pathinfo($image);                
                if(!empty($image) && ($info['extension'] == 'png' OR $info['extension'] == 'PNG')) {                    
                    $im = Product::model()->convertImage($image);
                    $model->$key = $im;
                }               
            }
            /* END convert images from PNG TO JPEG */
            if ($isValidBrand && $seller->save() && $model->save()) { 
                Yii::app()->user->setFlash('product_update', Yii::t('base', 'Your changes are submitted for our review.'));
                $this->redirect(array('members/profile/items'));
            }
        }

        $this->render('sell_product', array(
            'model' => $model,
            'seller' => $seller,
            'wfDesc' => isset($wfDesc) ? $wfDesc : null,
        ));
    }

    /**
     * Загрузка файлов на сервер.
     */
    public function actionFileUpload()
    {
        // Инициализируем класс загрузчика.
        $upload_handler = new UploadHandler();
    }

    /**
     * Удаление изображения товара.
     */
    public function actionRemProdImage()
    {
        // Только Ajax-запрос.
        if (!Yii :: app() -> request -> isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Проверяем входные данные.
        if (empty($_POST['fname']) ||
            strpos($_POST['fname'], '-') === false) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Проверяем права пользователя на удаление изображения.
        if ((int)Yii :: app() -> member -> id !==
            (int)explode('-', $_POST['fname'])[1]) {
            throw new CHttpException(401, 'Unauthorized');
        }

        // Удаляем файл изображения и его превьюшку.
        $uploadFld = Yii :: getPathOfAlias('webroot.images.upload');
        if (file_exists(($f1 = $uploadFld . DIRECTORY_SEPARATOR . $_POST['fname']))) {
            unlink($f1);
        }
        if (file_exists(($f2 = $uploadFld . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $_POST['fname']))) {
            unlink($f2);
        }
    }

    public function actionConfirmRemove()
    {
        if (isset($_GET['id'])) {
            $product = Product::model()->findByPk($_GET['id']);

            $this->renderPartial('_confirm_delete', array('product' => $product), false, true);
        }
        Yii::app()->end();
    }

    public function actionRemoveItem()
    {
        if (isset($_POST['id'])) {
            Product::model()->deleteByPk($_POST['id']);
            $model = Product::model()->active()->findAllByAttributes(array('user_id' => Yii::app()->member->id));
            $this->renderPartial(
                '_sale_items',
                array(
                    'model' => $model,
                    'userId' => Yii::app()->member->id
                ),
                false,
                true);
        }
        Yii::app()->end();
    }

    public function actionChangePrice()
    {
        if (isset($_POST['id']) && isset($_POST['price'])) {
            $product = Product::model()->findByPk($_POST['id']);
            $product->setScenario('changePrice');
            $product->price = $_POST['price'];
            $product->save();

            $model = Product::model()->active()->findAllByAttributes(array('user_id' => Yii::app()->member->id));

            $this->renderPartial(
                '_sale_items',
                array(
                    'model' => $model,
                    'userId' => Yii::app()->member->id),
                false,
                true);
        }
        Yii::app()->end();
    }

    public function actionItems()
    {
        $uid = isset($_GET['id']) ? $_GET['id'] : Yii::app()->member->id;
        if (strpos(Yii::app()->request->requestUri, 'my-account') !== false && !empty(Yii::app()->member->id)) {
            $userId = Yii::app()->member->id;
        } else {
            $userId = '';
        }
        $model = Product:: model()
            ->active()
            ->with('size_chart')
            ->findAllByAttributes(array('user_id' => $uid));

        $user = User::model()->findByPk($uid);

        self::setUnreadInfo();

        $this->title = 'User ' . CHtml::encode($user->username) . ' Items';

        $this->render('items', array(
            'model' => $model,
            'user' => $user,
            'userId' => $userId
        ));
    }

    public function actionReview()
    {
        if (isset($_POST['product_id']) && isset($_POST['communication']) && isset($_POST['description'])
            && isset($_POST['shipment'])
        ) {
            $rating = new Rating;
            echo $rating->addRating();
        } elseif (isset($_POST['id'])) {
            $this->renderPartial('_review', array('id' => $_POST['id']), false, true);
        } else {
            echo 0;
        }

        Yii::app()->end();
    }

    /**
     * Устанавливает у продукта заказа статус 'received'
     * (товар успешно получен покупателем).
     */
    public function actionSetStatusForProduct()
    {
        // Только Ajax-запрос.
        if (!Yii:: app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Проверяем входные данные.
        if (!isset($_POST['oid'], $_POST['pid'], $_POST['status']) ||
            !is_numeric($_POST['oid']) ||
            !is_numeric($_POST['pid']) ||
            !ctype_alpha($_POST['status'])
        ) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Ассоциировнный с продуктом заказ.
        $order = Order:: model()->with('orderItems')->findAllByAttributes(array(
            'id' => $_POST['oid'],
            'user_id' => Yii:: app()->member->id
        ));

        // Меняем статус продукта заказа на 'received'.
        if (count($order)) {
            foreach ($order[0]->orderItems as $item) {
                if ((int)$item->product_id !== (int)$_POST['pid']) {
                    continue;
                }
                if ($_POST['status'] == OrderItem :: OI_STATUS_RECEIVED) {
                    $item->status = OrderItem :: OI_STATUS_RECEIVED;
                    $item->shipping_status = OrderItem :: OI_SHIP_STATUS_RECEIVED;
                } else {
                    $item->shipping_status = OrderItem :: OI_SHIP_STATUS_RETURNED;
                }
                if ($item->save()) {
                    // Статус успешно сохранен.
                    die(CJSON::encode(array(
                        'result' => 'ok'
                    )));
                } else {
                    // Не удалось сохранить статус.
                    die(CJSON::encode(array(
                        'result' => 'error'
                    )));
                }
                break;
            }
        }
    }

    public function actionResolveOffer()
    {
        $response = array(
            'status' => 'error'
        );
        if (!isset($_POST['offer_id']) ||
            !isset($_POST['product_id']) ||
            !isset($_POST['confirm'])
        )
            die(CJSON::encode($response));

        $offer_id = (int)$_POST['offer_id'];
        $product_id = (int)$_POST['product_id'];
        $confirm = null;

        if ($_POST['confirm'] == 'confirm') $confirm = 1;
        if ($_POST['confirm'] == 'cancel') $confirm = 0;

        if ($confirm === null) die(CJSON::encode($response));

        $criteria = new CDbCriteria();
        $criteria->condition = "id = $offer_id AND product_id = $product_id";

        $offer = Offers::model()->find($criteria);

        if (!$offer) die(CJSON::encode($response));
        if ($offer->seller_id != Yii::app()->member->id) die ('error');

        $offer->confirm = $confirm;
        $offer->added_date = new CDbExpression('NOW()'); // renew date of offer

        self::setUnreadInfo();

        if ($offer->update()) {
            $response['status'] = 'success';
            $response['newText'] = ($confirm == 1) ? Yii::t('base', 'accepted') : Yii::t('base', 'rejected');
            $product = Product::model()->findByPk($offer->product_id);
            $user = User::model()->findByPk($offer->user_id);
            if($confirm == 1) {
                $template = Template:: model()->find("alias = 'offer_accepted' AND language = :lang",
                    array(':lang' => Yii::app()->getLanguage()));
            } else {
                $template = Template:: model()->find("alias = 'offer_rejected' AND language = :lang",
                    array(':lang' => Yii::app()->getLanguage()));
            }
            try {
                if (count($template)) {
                    $mail = new Mail;
                    $parameters = EmailHelper::setValues($template->content, array(
                        $product, $user
                    ));
                    $message = Yii::t('base', $template->content, $parameters);
                    $mail->send(
                        $user->email,
                        $template->subject,
                        $message,
                        $tmpl->priority
                    );
                }
            } catch (Exception $e) {

            }
        }

        die(CJSON::encode($response));
    }

    // WISHLIST.
    //**************************************************************************

    /**
     * Отображение wishlist-а пользователя.
     */
    public function actionWishlist()
    {
        $uid = isset($_GET['id']) ? $_GET['id'] : Yii::app()->member->id;
        $user = User::model()->findByPk($uid);
        // Получаем wishlist.
        $wishlist = Wishlist::model()
            ->with(array('product', 'brand', 'size'))
            ->findAll('t.user_id = :user_id', array(':user_id' => $uid));
        $this->title = 'User ' . $user->username . ' Wishlist';
        // Рендерим вьюху.
        $this->render('wishlist', array(
            'wishlist' => $wishlist,
            'user' => $user
        ));
    }

    /**
     * Добавляет товар в wishlist пользователя.
     * @param integer $pid ID добавляемого в wishlist продукта.
     * @throws CHttpException.
     */
    public function actionAjaxAddItemToWishlist()
    {
        // Только Ajax-запрос.
        if (!Yii::app()->request->isAjaxRequest || !isset($_POST['pid']) || empty($_POST['pid'])) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Текущий пользователь.
        $pid = $_POST['pid'];
        $uid = Yii::app()->member->id;

        // Проверяем не находится ли товар уже в wishlist-е.
        if (!Wishlist::model()->exists(
            'user_id = :user_id AND product_id = :product_id',
            array(':user_id' => $uid, ':product_id' => $pid)
        )
        ) {
            // Сохраняем товар в wishlist.
            $model = new Wishlist;
            $model->user_id = $uid;
            $model->product_id = $pid;

            if ($model->save()) {
                // Товар успешно добавлен в wishlist.
                die(CJSON::encode(array(
                    'result' => 'ok'
                )));
            } else {
                // Не удалось сохранить в wishlist.
                die(CJSON::encode(array(
                    'result' => 'error'
                )));
            }
        } else {
            // Уже в wishlist-е.
            die(CJSON::encode(array(
                'result' => 'exists'
            )));
        }
    }

    /**
     * Удаляет товар с указанным ID из wishlist-а пользователя.
     * @param integer $wid ID удаляемого пункта.
     * @throws CHttpException.
     */
    public function actionAjaxRemoveItemFromWishlist()
    {

        // Только Ajax-запрос.
        if (!Yii::app()->request->isAjaxRequest || !isset($_POST['wid']) || empty($_POST['wid'])) {
            throw new CHttpException(403, 'Forbidden');
        }

        $wid = $_POST['wid'];
        // Текущий пользователь.
        $uid = Yii::app()->member->id;

        // Удаляем указанный пункт из базы.
        if (Wishlist::model()
            ->findByAttributes(array('user_id' => $uid, 'product_id' => $wid))
            ->delete()
        ) {
            // Пункт успешно удален.
            die(CJSON::encode(array(
                'result' => 'ok'
            )));
        } else {
            // Не удалось удалить пункт.
            die(CJSON::encode(array(
                'result' => 'error'
            )));
        }
    }

    public function actionSetOffersAsRead()
    {
        // Текущий пользователь.
        $uid = Yii::app()->member->id;

        Offers::model()->setAsRead($uid);

        self::setUnreadInfo();

        die(self::getUnreadInfoText());
    }

    public function actionSetConfirmedOffersAsRead()
    {
        // Текущий пользователь.
        $uid = Yii::app()->member->id;

        Offers::model()->setConfirmedAsRead($uid);

        self::setUnreadInfo();

        echo self::getUnreadInfoText();
        die();
    }

    //**************************************************************************

    public static function setCommentsAsRead($model)
    {
        $productIds = CHtml::listData($model, 'id', 'id');
        $criteria = new CDbCriteria();
        $criteria->addInCondition('product_id', $productIds);
        Comments::model()->updateAll(
            array('read' => 1),
            $criteria
        );

        $unreadInfo = unserialize(Yii::app()->getUser()->getState(ProfileController::UNREAD_INFO));
        $unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT] = 0;
        Yii::app()->getUser()->setState(ProfileController::UNREAD_INFO, serialize($unreadInfo));
    }

    public static function setUnreadInfo()
    {
        $unrComCount = count(Comments::getUnreadComments());
        $unrOffCount = count(Offers::getUnreadOffers());
        $unrRespCount = count(Offers::getUnusedOffers());

        Yii::app()->getUser()->setState(ProfileController::UNREAD_INFO, serialize(array(
            ProfileController::UNREAD_COMMENTS_COUNT => $unrComCount,
            ProfileController::UNREAD_OFFERS_COUNT => $unrOffCount,
            ProfileController::UNREAD_RESPONSES_COUNT => $unrRespCount
        )));
    }

    public static function getUnreadInfoText()
    {
        $unreadInfo = self::getUnreadInfo();
        $totalCnt = $unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT] +
            $unreadInfo[ProfileController::UNREAD_OFFERS_COUNT] +
            $unreadInfo[ProfileController::UNREAD_RESPONSES_COUNT];
        return ($totalCnt > 0) ? (Yii::t('base', 'new') . ' - ' . $totalCnt) : '';
    }

    public static function getUnreadInfo()
    {
        $unreadInfo = unserialize(Yii::app()->getUser()->getState(ProfileController::UNREAD_INFO));

        if (!$unreadInfo) {
            return array(
                ProfileController::UNREAD_COMMENTS_COUNT => 0,
                ProfileController::UNREAD_OFFERS_COUNT => 0,
                ProfileController::UNREAD_RESPONSES_COUNT => 0
            );
        }

        if (!isset($unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT])) {
            $unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT] = 0;
        }
        if (!isset($unreadInfo[ProfileController::UNREAD_OFFERS_COUNT])) {
            $unreadInfo[ProfileController::UNREAD_OFFERS_COUNT] = 0;
        }
        if (!isset($unreadInfo[ProfileController::UNREAD_RESPONSES_COUNT])) {
            $unreadInfo[ProfileController::UNREAD_RESPONSES_COUNT] = 0;
        }

        return $unreadInfo;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function offer_mix($offers, $responses)
    {
        $offers_count = count($offers);
        $responses_count = count($responses);

        $result = array();

        if ($offers_count == 0 && $responses_count == 0) return $result;

        if ($offers_count == 0) {
            foreach ($responses as $response) {
                array_push($result, array(
                    'name' => 'response',
                    'value' => $response
                ));
            }

            return $result;
        }

        if ($responses_count == 0) {
            foreach ($offers as $offer) {
                array_push($result, array(
                    'name' => 'offer',
                    'value' => $offer
                ));
            }

            return $result;
        }

        $counter = $offers_count > $responses_count ? $offers_count : $responses_count;

        for ($i = 0; $i < $counter; $i++) {
            if (isset($offers[$i])) {
                array_push($result, array(
                    'name' => 'offer',
                    'value' => $offers[$i]
                ));
            }

            if (isset($responses[$i])) {
                array_push($result, array(
                    'name' => 'response',
                    'value' => $responses[$i]
                ));
            }
        }

        // sort by added date
        //
        uasort($result, function ($item1, $item2) {
            $obj1 = $item1['value'];
            $obj2 = $item2['value'];

            if ($obj1->added_date == $obj2->added_date) return 0;

            return $obj1->added_date < $obj2->added_date ? 1 : -1;
        });

        return $result;
    }
}


































