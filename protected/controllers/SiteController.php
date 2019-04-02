<?php

class SiteController extends Controller
{
    public $title;
    public $meta_description;
    public $meta_keywords;
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
//          'page'=>array(
//              'class'=>'CViewAction',
//          ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            /**
             * Редирект на главную, если страница не найдена или внутренняя ошибка сервера.
             */
            /*if ($error['code'] == 404 ||
                $error['code'] == 500) {
                $this->redirect(Yii::app()->homeUrl);
            }*/

            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        throw new CHttpException(410, 'Gone');
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Поиск по сайту.
     * @throws CHttpException.
     */
    public function actionAjaxSearch()
    {
        // Только POST Ajax-запрос.
        if (!Yii::app()->request->isAjaxRequest ||
            !Yii::app()->request->isPostRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Проверяем строку поиска на корректность.
        if (empty($query = Yii::app()->request->getPost('query')) ||
            preg_match('/["\'%]/', $query)) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Ищем похожий запрос в кэше (memcached).
        if (extension_loaded('memcached') && class_exists('Memcached')) {

            // ID поискового запроса.
            $key = sha1($query);

            $mc = new Memcached();
            $mc -> addServer('localhost', 11211);

            if (!empty($data = $mc -> get($key))) {
                // Возвращаем результат из кэша.
                die(CJSON::encode(
                    $data
                ));
            } elseif (strlen($query) > 2) {
                // Ищем пересечение результатов (предотвращение повторной выборки).
                $copy = $query;
                $keys = $mc -> getAllKeys();
                while (strlen($copy) > 2) {
                    $copy = substr($copy, 0, -1);
                    if (in_array(($hash = sha1($copy)), $keys)) {
                        $data = array();
                        foreach ($mc -> get($hash)['data'] as $k => $v) {
                            $data[$k] = array();
                            foreach ($v as $item) {
                                if (stripos($item['name'], $query) !== false) {
                                    $data[$k][] = $item;
                                }
                            }
                        }
                        die(CJSON::encode(array(
                            'data' => $data
                        )));
                    }
                }
            }
        }

        // Переводим текст запроса в нижний регистр.
        $query = strtolower(trim($query));
        // Меняем условие поиска, если строка поиска меньше двух символов.
        $query = strlen($query) < 2 ? $query . '%' : $query;
        // Экранируем строку запроса.
        $query = Yii::app()->db->quoteValue($query);

        // Включить в поисковую выдачу только результаты,
        // которые соответствуют языковым настройкам сайта.
        $lang = Yii::app()->getLanguage();

        // Получаем данные.
        $data = Yii::app()
                ->db
                ->createCommand("CALL `search`({$query}, '{$lang}')")
                ->queryAll();

        /**
         * Группируем результат по категориям:
         * p - продукт
         * b - брэнд
         * c - категория
         * u - пользователь
         */
        $p = $b = $c = $u = array();
        foreach ($data as $item) {
            switch ($item['type']) {
                case 'p' :
                    $p[] = $item;
                    break;
                case 'b' :
                    $b[] = $item;
                    break;
                case 'c' :
                    $c[] = $item;
                    break;
                case 'u' :
                    $u[] = $item;
                    break;
            }
        }

        // Подготавливаем данные к отправке пользователю.
        $data = array(
            'data' => array(
                'p' => $p,
                'b' => $b,
                'c' => $c,
                'u' => $u
            )
        );

        // Заносим в кэш на 120 минут.
        if (isset($mc, $key)) {
            $mc -> set($key, $data, time() + 7200);
        }

        // Возвращаем результат поиска пользователю.
        die(CJSON::encode(
            $data
        ));
    }

    /**
     * SOCIAL SHARE REDIRECT_URL.
     */
    public function actionShare()
    {
        $content = '
        <script>
            var slf = window.self;
            slf.opener = window.self;
            slf.close();
        </script>
        ';
        die($content);
    }

    /**
     * Отображение статической страницы.
     * @param string $page Имя страницы.
     * @throws CHttpException.
     */
    public function actionStatic($page)
    {
        // Получаем данные для статической страницы.
        $data = Page :: model() -> getStaticPageData($page,  Yii :: app() -> getLanguage());
        if (!count($data)) {
            throw new CHttpException(404, 'Not Found');
        }

        $this->title = $data['title'];

        // Мета тэги.
        $this -> meta_description = $data['seo_description'];
        //$this -> meta_keywords    = $data['seo_keywords'];

        // Отображаем вьюху.

        if($page == 'about')
        {
            Yii::app()->clientScript->registerMetaTag('index, follow', 'robots');
        }else{
            Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        }
        

        $this -> render('static', array(
            'title'   => $data['title'],
            'content' => $data['content']
        ));
    }

    /**
     * Поиск по сайту (мобильная версия).
     */
    public function actionMobileSearch()
    {
        $this -> render('mobile-search');
    }

    /**
     * Тестовое действие.
     */
    public function actionTest()
    {
        // $criteria = new CDbCriteria();
        // $criteria->condition = 'alerts_sent = 0';
        // $criteria->with = array('brand', 'category');
        // $products = Product::model()->findAll($criteria);
        // $productIds = CHtml::listData($products, 'id', 'id');
        // $template = Template::model()->find("alias = 'price_alert_notification' AND language = :lang", array(':lang' => 'en'));
        // if (!count($template)) die();
        // foreach ($products as $product) {
        //     $alerts = Alerts::model()
        //         ->with('user')
        //         ->findAll(
        //             array(
        //                 'condition' => 'subcategory_id=:subcategory_id AND size_type=:size_type',
        //                 'params' => array(
        //                     ':subcategory_id' => $product->category_id,
        //                     ':size_type' => $product->size_type
        //                 ),
        //             )
        //         );

        //     if ($alerts && $product->status == Product::PRODUCT_STATUS_ACTIVE) {
        //         foreach ($alerts as $alert) {
        //             $user = $alert->user;
        //             $url = Product::getProductUrl($product->id, $product);
        //             $parameters = EmailHelper::setValues($template->content, array(
        //                     $user,
        //                     $product,
        //                     array(
        //                         'Option' => array(
        //                             'link' => 'http://23-15.com' . $url,
        //                         )
        //                     )
        //                 )
        //             );
        //             $mail = new Mail();
        //             $mail->send(
        //                 $user->email,
        //                 $template->subject,
        //                 Yii::t('base', $template->content, $parameters),
        //                 $template->priority
        //             );
        //         }
        //     }
        // }
        // Product::model()->updateByPk($productIds, array(
        //     'alerts_sent' => 1
        // ));
        // $mail = new Mail();
        // $mail->send(
        //     'mails@23-15.com',
        //     'test test test!',
        //     '<html><b>1Это просто текст</b>. А вот это уже не просто текст. Что писать не знаю, но что-то надо писать! (<a href="http://www.23-15.com/shop">новые продукты</a>).</html>',
        //     'normal'
        // );


        //$order = Order::model()->findByPk(109);
        // $user = User::model()->findByPk(66);
        // $template = Template:: model()->find("alias = 'order_complete' AND language = :lang",
        //     array(':lang' => Yii::app()->getLanguage()));

        // if (count($template)) {
        //     $mail = new Mail;
        //     $itemsString = '';
        //     $baseUrl = Yii:: app()->request->getBaseUrl(true);
        //     $medium_dir = $baseUrl . ShopConst::IMAGE_THUMBNAIL_DIR;
        //     $itemsString.= '<table style="width:100%;"><tr><th style="padding-right:20px;width: 180px;">Item</th><th style="padding-right:20px;width: 400px;">Details</th><th style="padding-right:20px;width: 150px;">Price</th><th></th></tr>';
        //     foreach($order->orderItems as $item)
        //     {
        //         $itemsString.="<tr><td style='padding-right:20px'><img src='".$medium_dir.$item->product->image1."'></td><td style='padding-right:20px'>".
        //             $item->product->brand->name.' '.
        //             $item->product->title.
        //             " [#". $item->product->id."]</td><td style='padding-right:20px;text-align:center;'> &euro;".
        //             $item->product->price."&nbsp;</td><td></td></tr>";
        //     }
        //     $itemsString.= '<tr><td colspan="4" style="padding-top: 40px;"><hr /></td></tr>';
        //     $itemsString.= "<tr><td style='padding-right:20px;padding-top: 20px;'>Shipping from:</td><td style='padding-right:20px;padding-top: 20px;'>Shipping to:<br />{Order/shipping_to}</td><td style='padding-right:20px;padding-top: 20px;'>Shipping: &euro;{Order/shipping_cost}<br />Total: &nbsp;&nbsp;&nbsp;&euro;{Order/total}</td><td></td></tr>";
        //     $itemsString.='</table>';
        //     $parameters = EmailHelper::setValues($template->content . $itemsString, array(
        //         $order, $user
        //     ));
        //     $message = Yii::t('base', $template->content, $parameters);
        //     $itemsString = Yii::t('base', $itemsString, $parameters);
        //     $message = str_replace('{items}',$itemsString,$message);
        //     //echo '<pre>';print_r($message);die();
        //     $mail->send(
        //         "redencill@gmail.com",
        //         $template->subject,
        //         $message,
        //         $template->priority
        //     );
        // }
        die('ok!');
    }
    
    public function actionSubscribe()
    {
        $email = $_POST['email'];
        
        $mailChimp = new MailChimp(Yii::app()->params['mailchimp']['api_key']);
        $list_id = Yii::app()->params['mailchimp']['list_id'];
        $result = $mailChimp->post("lists/$list_id/members", [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
        
        $res = [
            'success' => false
        ];
        
        if ($result['status'] == 'subscribed') {
            $res = [
                'success' => true,
            ];
        } else {
            if (isset($result['detail']) && !empty($result['detail'])) {
                $res = [
                    'error' => $result['detail']
                ];
            }
        }
        
        die(CJSON::encode(
            $res
        ));
    }
}