<?php

class ApisController extends AdminController
{
    public function actionIndex()
    {
        $settings = array();
        $apis = ApiSetting::getApisName();

        foreach ($apis as $value) {
            $settings[$value] = new ApiSetting($value);
        }

        if (isset($_POST['ApiSetting'])) {
            foreach ($apis as $value) {
                $settings[$value]->setSettings($_POST['ApiSetting'][$value]);
                $settings[$value]->save();
            }
        }

        $this->render('index', array(
            'settings' => $settings,
        ));
    }

    public function actionGetTokenQb()
    {
        if (!Yii::app()->session) {
            session_start();
        }

        $authKey = Yii::app()->params['quickBooks']['auth_key'];
        $authSecret = Yii::app()->params['quickBooks']['auth_secret'];
        $authRequestUrl = 'https://oauth.intuit.com/oauth/v1/get_request_token';
        $authAccessUrl = 'https://oauth.intuit.com/oauth/v1/get_access_token';
        $authAuthorizeUrl = 'https://appcenter.intuit.com/Connect/Begin';
        $callbackUrl = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);

        try {
            $oauth = new OAuth($authKey, $authSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            $oauth->enableDebug();
            $oauth->disableSSLChecks(); //To avoid the error: (Peer certificate cannot be authenticated with given CA certificates)

            unset($_SESSION['token']);
            if (!isset($_GET['oauth_token']) && !isset($_SESSION['token'])) {
                // step 1: get request token from Intuit
                $request_token = $oauth->getRequestToken($authRequestUrl, $callbackUrl);
                $_SESSION['secret'] = $request_token['oauth_token_secret'];
                // step 2: send user to intuit to authorize 
                header('Location: ' . $authAuthorizeUrl . '?oauth_token=' . $request_token['oauth_token']);
            }

            if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
                // step 3: request a access token from Intuit
                $oauth->setToken($_GET['oauth_token'], $_SESSION['secret']);
                $access_token = $oauth->getAccessToken($authAccessUrl);

                $realmId = $_REQUEST['realmId'];
                $dataSource = $_REQUEST['dataSource'];

                $qbAuth = new QuickbooksAuth;
                $qbAuth->model()->deleteAll(); // clear table
                $qbAuth->setToken($access_token['oauth_token'], $access_token['oauth_token_secret'], $realmId, $dataSource);

                $this->redirect('index');
            }

        } catch (OAuthException $e) {
            echo "Got auth exception";
            echo '<pre>';
            print_r($e);
        }
    }
}
