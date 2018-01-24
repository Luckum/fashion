<?php

class AuthController extends MemberController
{
    public function actionAccessError()
    {
        $this->render('accessError');
    }

    public function actionLogout()
    {
        Yii::app()->shoppingCart->clearCart();
        Yii::app()->member->logout(false);
        $this->redirect(Yii::app()->member->returnUrl);
    }

    public function actionLogin($withoutRedirect = "", $commentsForm = "")
    {
        if ($withoutRedirect == 'check_if_user_is_guest') {
            $withoutRedirect = '1';
            if (!Yii::app()->member->isGuest) {
                echo '0';
                Yii::app()->end();
            }
        }
        if (Yii::app()->member->isGuest) {
            $this->title = 'Login';
            $user = new User('registration');
            $user->unsetAttributes();
            $user_login = new LoginForm('clientlogin');
            $user_login->unsetAttributes();

            $this->performAjaxValidation($user);
            $this->performAjaxValidation($user_login);

            if (isset($_POST['LoginForm'])) {
                $user_login->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if ($user_login->validate() && $user_login->clientLogin()) {
                    if (isset($_POST['return']) && !empty($_POST['return'])) {
                        $redirectUrl = $_POST['return'];
                    } else {
                        $redirectUrl = Yii::app()->homeUrl;
                    }
                    if (isset($_POST['without_ajax']) && $_POST['without_ajax'] == "1") {
                        $this->redirect($redirectUrl);
                    }
                    Offers::deleteExpireOffers(48);

                    if (Yii::app()->request->getPost('withoutRedirect') != "1") {
                        echo CJavaScript::jsonEncode(array('redirect' => $redirectUrl));
                    } else {
                        if (Yii::app()->request->getPost('commentsForm') == "1") {
                            echo CJavaScript::jsonEncode(array('commentsForm' => 1));
                        } else {
                            echo CJavaScript::jsonEncode(array('sendSellForm' => 1));
                        }
                    }

                    Yii::app()->end();
                }
                if (Yii::app()->request->isAjaxRequest) {
                    $this->renderPartial('registration', array('model' => $user, 'model_login' => $user_login, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm), false, true);
                } else {
                    $this->render('registration', array('model' => $user, 'model_login' => $user_login, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm));
                }
            } elseif (isset($_POST['User'])) {

                $user->attributes = $_POST['User'];

                if ($user->save()) {

                    try {
                        //set_error_handler('quickBooks_error_handler');
                        $qb = new Quickbooks(Yii::app()->params['misc']['quickBooks_IsDemo']);
                        $customer = $qb->addCustomer($_POST['User']['username']);
                        $user->qb_user_id = $customer->Id;
                    } catch (Exception $e) {
                        $mail = new Mail();
                        $mail->send(
                            Yii::app()->params['misc']['adminEmail'],
                            'QuickBooks Add Customer Error',
                            $e->getMessage()
                        );
                    }

                    // Подписываем юзера на рассылку MailChimp
                    $mailChimp = new MailChimp(Yii::app()->params['mailchimp']['api_key']);
                    $list_id = Yii::app()->params['mailchimp']['list_id'];
                    $result = $mailChimp->post("lists/$list_id/members", [
                        'email_address' => $user->email,
                        'merge_fields' => ['FNAME' => $user->username],
                        'status' => 'subscribed',
                    ]);
                    // Посылаем уведомление о регистрации на почту.
                    $tmpl = Template::model()->find("alias = 'registration' AND language = :lang", array(':lang' => 'en'));
                    if (count($tmpl)) {
                        $parameters = EmailHelper::setValues($tmpl->content, array($user));
                        $message = Yii::t('base', $tmpl->content, $parameters);
                        $mail = new Mail;
//			$mail->SetFrom(Yii::app()->params['misc']['adminEmail']);
                        $mail->send($user->email, $tmpl->subject, $message, $tmpl->priority);
                    }

                    // Автологин после регистрации.
                    $login = new LoginForm;
                    $login->username = $_POST['User']['email'];
                    $login->password = $_POST['User']['password'];

                    if ($login->validate() && $login->clientLogin()) {
                        if (Yii::app()->request->getPost('withoutRedirect') != "1") {
                            echo CJavaScript::jsonEncode(array('redirect' => Yii::app()->member->returnUrl));
                        } else {
                            if (Yii::app()->request->getPost('commentsForm') == "1") {
                                echo CJavaScript::jsonEncode(array('commentsForm' => 1));
                            } else {
                                echo CJavaScript::jsonEncode(array('sendSellForm' => 1));
                            }
                        }

                        Yii::app()->end();
                    }
                }

                if (Yii::app()->request->isAjaxRequest) {
                    $this->renderPartial('registration', array('model' => $user, 'model_login' => $user_login, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm), false, true);
                } else {
                    $this->render('registration', array('model' => $user, 'model_login' => $user_login, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm));
                }
            } else {
                $return = '';

                if(isset($_POST['return'])){
                    $return = $_POST['return'];
                }else{
                    $return = Yii::app()->request->cookies->contains('return') ? Yii::app()->request->cookies['return']->value : Yii::app()->request->urlReferrer;
                    unset(Yii::app()->request->cookies['return']);
                }

                if (Yii::app()->request->isAjaxRequest) {
                    $this->renderPartial('registration', array('model' => $user, 'model_login' => $user_login, 'return' => $return, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm), false, true);
                } else {
                    $this->render('registration', array('model' => $user, 'model_login' => $user_login, 'return' => $return, 'withoutRedirect' => $withoutRedirect, 'commentsForm' => $commentsForm));
                }
            }
        } else {
            if (Yii::app()->request->getPost('withoutRedirect') != "1") {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJavaScript::jsonEncode(array('redirect' => Yii::app()->member->returnUrl));
                } else {
                    $this->redirect(Yii::app()->member->returnUrl);
                }
            } else {
                if (Yii::app()->request->getPost('commentsForm') == "1") {
                    echo CJavaScript::jsonEncode(array('commentsForm' => 1));
                } else {
                    echo CJavaScript::jsonEncode(array('sendSellForm' => 1));
                }
            }
        }
    }

    public function actionChangePassword()
    {
        $model = new User;
        $model->unsetAttributes();
        $user = $model->findByPk(Yii::app()->member->id);

        $this->title = 'Change Password';

        if (isset($_POST['User'])) {
            $user->setScenario('changePass');
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(Yii::app()->member->returnUrl);
            }
        }
        $this->render('changePassword', array(
            'model' => $user
        ));
    }

    /**
     * Восстановление пароля.
     * @throws CException
     */
    public function actionForgotPassword($withoutRedirect = "", $commentsForm = "")
    {
        // Восстанавливать пароль можно только из гостевого аккаунта.
        if (!Yii:: app()->member->isGuest) {
            $this->redirect(Yii:: app()->member->returnUrl);
        }

        // Модель User.
        $model = new User;
        $model->unsetAttributes();

        // Заголовок страницы.
        $this->title = 'Forgot Password';

        if (isset($_GET['access_hash']) /* Поступил запрос на восстановление пароля */) {

            // Находим пользователя, соответсвующего указанному хэшу восстановления
            //(хэш создается автоматически при регистрации нового пользователя).
            $user = User:: model()->findByAttributes(array(
                'access_hash' => $_GET['access_hash']
            ));

            if (count($user)) {

                // Пользователь с таким хэшем восстановления найден.

                $interval = date_diff(date_create($user->time_send), date_create('now'));

                if ($interval->format('%h') > 1 /* Ссылка на восстановление действительна не более часа */) {

                    Yii:: app()->member->setFlash('timeIsOver', Yii:: t('base', 'Time to reset your password is up. Try again.'));
                    $this->redirect(array('forgotPassword'));

                } else {

                    // Сбрасываем пароль.
                    $user->password = 'blank';
                    $user->save();

                    $identity = new ClientIdentity($user->email, 'blank');

                    if ($identity->authenticate()) {

                        // Логинимся с пустым паролем и переходим на страницу смены пароля.
                        Yii:: app()->member->login($identity);
                        $this->redirect(array('changePassword'));

                    } else {

                        // Недействительный хэш восстановления пароля.
                        Yii:: app()->member->setFlash('wrongHash', Yii:: t('base', $identity->errorMessage));
                        $this->redirect(array('forgotPassword'));

                    }

                }

            } else {

                // Недействительный хэш восстановления пароля.
                Yii:: app()->member->setFlash('wrongHash', Yii::t('base', 'Access hash is wrong. Try again.'));
                $this->redirect(array('forgotPassword'));

            }

        }

        if (isset($_POST['User']) /* Запрос на отправку письма с хэшем восстановления пароля */) {

            // Находим пользователя, соответсвующего указанному e-mail.
            $user = User:: model()->findByAttributes(array(
                'email' => $_POST['User']['email']
            ));

            if (count($user)) {

                // Пользователь найден.

                // Генерируем хэш восстановления пароля.
                $hash = md5(UtilsHelper:: generateRandomString(5));

                $user->scenario = 'forgotPass';
                $user->access_hash = $hash;

                if ($user->save()) {
                    $template = Template::model()->find("alias = 'forgot_password' AND language = :lang", array(':lang' => $user->language));
                    if (count($template)) {
                        $parameters = EmailHelper::setValues($template->content, array(
                            $user,
                            array(
                                'Option' => array(
                                    'link' =>
                                        Yii:: app()->request->hostInfo .
                                        Yii:: app()->createUrl(
                                            Yii:: app()->getLanguage() . '/members/auth/forgotPassword') . '?access_hash=' . $hash,
                                    )
                                )
                            )
                        );
                        $mail = new Mail();
                        $mail->send(
                            $user->email,
                            $template->subject,
                            Yii::t('base', $template->content, $parameters),
                            $template->priority
                        );

                        die(CJSON:: encode(array(
                            'result' => 'ok',
                            'text' => Yii:: t('base', 'The link for changing your password has been sent to the e-mail address you provided.'),
                        )));
                    }
                }

            } else {
                // Пользователь с указанным e-mail не зарегистрирован.
                die(CJSON:: encode(array(
                    'result' => 'error',
                    'text' => Yii:: t('base', 'User with such email does not exist'),
                )));
            }

        }

        // Отображаем вьюху.
        if (Yii:: app()->request->isAjaxRequest /* Ajax запрос */) {
            $this->renderPartial('forgotPassword', array(
                'model' => $model,
                false,
                true
            ));
        } else {
            $this->render('forgotPassword', array(
                'model' => $model
            ));
        }
    }

    public function actionEternal(){
        echo 'eternal';
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'registration-form' || $_POST['ajax'] === 'login-form')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

function quickBooks_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
