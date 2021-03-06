<?php
    /**
     * Управление параметрами конфигурации 'misc'.
     */
    class MiscController extends AdminController
    {
        public function actionIndex()
        {
            // Параметры раздела 'misc'.
            $data = Yii :: app() -> params -> misc;

            if (isset($_POST['save'])) {
                $params = array(
                    'blog_url'          => $_POST['blog_url'],
                    'adminEmail'        => $_POST['adminEmail'],
                    'pinterest_url'      => $_POST['pinterest_url'],
                    'twitter_url'       => $_POST['twitter_url'],
                    'instagram_url'     => $_POST['instagram_url'],
                    'quickBooks_IsDemo' => (bool)$_POST['quickBooks_IsDemo'],
                    'business_deactive' => (bool)$_POST['business_deactive']
                );

                UtilsHelper :: addParams('misc', $params, null);
                foreach ($params as $k => $v) {
                    $data[$k] = $v;
                }
            }

            $this -> render('index', array(
                'data' => $data,
            ));
        }
    }