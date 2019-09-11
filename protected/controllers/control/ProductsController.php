<?php

class ProductsController extends AdminController
{
    protected $key = "3CMGDJJNJAU6JXYFT7GG";
    protected $secret = "bxt9eWx6kJ/E3yvNiNkRG7N9NUbvnN/cwNAFJiQkDZk";
    protected $space_name = "n2315";
    protected $region = "fra1";
    
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => Product::model()->with('size_chart')->findByPk($id),
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Product;
        $model->setScenario('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->is_url = 0; 
            
            if($model->external_sale) {
                $model->size_type = NULL;
                //$model->category_id = Category::model()->getExternalSaleCategoryId();
            }
            $main_upload_path = Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MAX_DIR;

            $img1 = CUploadedFile::getInstance($model, 'image1');
            $img2 = CUploadedFile::getInstance($model, 'image2');
            $img3 = CUploadedFile::getInstance($model, 'image3');
            $img4 = CUploadedFile::getInstance($model, 'image4');
            $img5 = CUploadedFile::getInstance($model, 'image5');

            $model->image1 = $img1 ? ImageHelper::getUniqueValidName($main_upload_path, $img1->getName()) : null;
            $model->image2 = $img2 ? ImageHelper::getUniqueValidName($main_upload_path, $img2->getName()) : null;
            $model->image3 = $img3 ? ImageHelper::getUniqueValidName($main_upload_path, $img3->getName()) : null;
            $model->image4 = ($img4 && !$model->external_sale) ? ImageHelper::getUniqueValidName($main_upload_path, $img4->getName()) : null;
            $model->image5 = ($img5 && !$model->external_sale) ? ImageHelper::getUniqueValidName($main_upload_path, $img5->getName()) : null;

            if (empty($model->image1) && !empty($model->image_url1)) {
                if (($pos_s = strpos($model->image_url1, '?')) !== false) {
                    $model->image_url1 = substr($model->image_url1, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url1);
                $f_name = end($arr);
                $model->image1 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image2) && !empty($model->image_url2)) {
                if (($pos_s = strpos($model->image_url2, '?')) !== false) {
                    $model->image_url2 = substr($model->image_url2, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url2);
                $f_name = end($arr);
                $model->image2 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image3) && !empty($model->image_url3)) {
                if (($pos_s = strpos($model->image_url3, '?')) !== false) {
                    $model->image_url3 = substr($model->image_url3, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url3);
                $f_name = end($arr);
                $model->image3 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image4) && !empty($model->image_url4)) {
                if (($pos_s = strpos($model->image_url4, '?')) !== false) {
                    $model->image_url4 = substr($model->image_url4, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url4);
                $f_name = end($arr);
                $model->image4 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image5) && !empty($model->image_url5)) {
                if (($pos_s = strpos($model->image_url5, '?')) !== false) {
                    $model->image_url5 = substr($model->image_url5, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url5);
                $f_name = end($arr);
                $model->image5 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if ($model->save()) {
                $crop_mode = 0;
                /*if ($model->category_id == 155 || $model->category_id == 157 || $model->category_id == 140 || $model->category_id == 136 || $model->category_id == 138 || $model->category_id == 137 || $model->category_id == 163) {
                    $crop_mode = 1;
                }
                if ($model->category_id == 153 || $model->category_id == 154 || $model->category_id == 156 || $model->category_id == 129 || $model->category_id == 150 || $model->category_id == 148) {
                    $crop_mode = 2;
                }
                if ($model->category_id == 149 || $model->category_id == 162 || $model->category_id == 161) {
                    $crop_mode = 3;
                }*/
                if (isset($img1)) ImageHelper::cSaveWithReducedCopies($img1, $model->image1, false, $crop_mode);
                if (isset($img2)) ImageHelper::cSaveWithReducedCopies($img2, $model->image2, false, $crop_mode);
                if (isset($img3)) ImageHelper::cSaveWithReducedCopies($img3, $model->image3, false, $crop_mode);
                if (isset($img4)) ImageHelper::cSaveWithReducedCopies($img4, $model->image4, false, $crop_mode);
                if (isset($img5)) ImageHelper::cSaveWithReducedCopies($img5, $model->image5, false, $crop_mode);

                if (!empty($model->image_url1)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image1, $model->image_url1, $crop_mode);
                if (!empty($model->image_url2)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image2, $model->image_url2, $crop_mode);
                if (!empty($model->image_url3)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image3, $model->image_url3, $crop_mode);
                if (!empty($model->image_url4)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image4, $model->image_url4, $crop_mode);
                if (!empty($model->image_url5)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image5, $model->image_url5, $crop_mode);
                
                $path = $this->setCdnPath($model->id) . '/' . $model->image1;
                $image_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR . 'medium/' . $model->image1;
                if ($this->copyToCdn($image_path, $path)) {
                    $model->image1 = $path;
                    if ($model->save()) {
                        unlink($image_path);
                    }
                }
                
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = Product :: model()
            -> findByPk($id);

        $model->setScenario('update');

        $invalidProd = $model->checkInvalidField();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $oldModelImage1 = $model->image1;
        $oldModelImage2 = $model->image2;
        $oldModelImage3 = $model->image3;
        $oldModelImage4 = $model->image4;
        $oldModelImage5 = $model->image5;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->is_url = 0;

            if($model->external_sale) {
                $model->size_type = NULL;
                //$model->category_id = Category::model()->getExternalSaleCategoryId();
            }
            $img1 = CUploadedFile::getInstance($model, 'image1');
            $img2 = CUploadedFile::getInstance($model, 'image2');
            $img3 = CUploadedFile::getInstance($model, 'image3');
            $img4 = CUploadedFile::getInstance($model, 'image4');
            $img5 = CUploadedFile::getInstance($model, 'image5');

            $oldImage1 = isset($_POST['Product']['oldImage1']) ? $_POST['Product']['oldImage1'] : null;
            $oldImage2 = isset($_POST['Product']['oldImage2']) ? $_POST['Product']['oldImage2'] : null;
            $oldImage3 = isset($_POST['Product']['oldImage3']) ? $_POST['Product']['oldImage3'] : null;
            $oldImage4 = isset($_POST['Product']['oldImage4']) ? $_POST['Product']['oldImage4'] : null;
            $oldImage5 = isset($_POST['Product']['oldImage5']) ? $_POST['Product']['oldImage5'] : null;

            $main_upload_path = Yii::getPathOfAlias('webroot') . ShopConst::IMAGE_MAX_DIR;

            $model->image1 = $img1 ? ImageHelper::getUniqueValidName($main_upload_path, $img1->getName()) : $oldImage1;
            $model->image2 = $img2 ? ImageHelper::getUniqueValidName($main_upload_path, $img2->getName()) : $oldImage2;
            $model->image3 = $img3 ? ImageHelper::getUniqueValidName($main_upload_path, $img3->getName()) : $oldImage3;
            $model->image4 = ($img4 && !$model->external_sale) ? ImageHelper::getUniqueValidName($main_upload_path, $img4->getName()) : $oldImage4;
            $model->image5 = ($img5 && !$model->external_sale) ? ImageHelper::getUniqueValidName($main_upload_path, $img5->getName()) : $oldImage5;

            if (empty($model->image1) && !empty($model->image_url1)) {
                if (($pos_s = strpos($model->image_url1, '?')) !== false) {
                    $model->image_url1 = substr($model->image_url1, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url1);
                $f_name = end($arr);
                $model->image1 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image2) && !empty($model->image_url2)) {
                if (($pos_s = strpos($model->image_url2, '?')) !== false) {
                    $model->image_url2 = substr($model->image_url2, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url2);
                $f_name = end($arr);
                $model->image2 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image3) && !empty($model->image_url3)) {
                if (($pos_s = strpos($model->image_url3, '?')) !== false) {
                    $model->image_url3 = substr($model->image_url3, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url3);
                $f_name = end($arr);
                $model->image3 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image4) && !empty($model->image_url4)) {
                if (($pos_s = strpos($model->image_url4, '?')) !== false) {
                    $model->image_url4 = substr($model->image_url4, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url4);
                $f_name = end($arr);
                $model->image4 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if (empty($model->image5) && !empty($model->image_url5)) {
                if (($pos_s = strpos($model->image_url5, '?')) !== false) {
                    $model->image_url5 = substr($model->image_url5, 0, $pos_s);
                }
                $arr = explode('/', $model->image_url5);
                $f_name = end($arr);
                $model->image5 = ImageHelper::getUniqueValidName($main_upload_path, $f_name);
                $model->is_url = 1;
            }
            
            if ($model->save()) {
                $crop_mode = 0;
                /*if ($model->category_id == 155 || $model->category_id == 157 || $model->category_id == 140 || $model->category_id == 136 || $model->category_id == 138 || $model->category_id == 137 || $model->category_id == 163) {
                    $crop_mode = 1;
                }
                if ($model->category_id == 153 || $model->category_id == 154 || $model->category_id == 156 || $model->category_id == 129 || $model->category_id == 150 || $model->category_id == 148) {
                    $crop_mode = 2;
                }
                if ($model->category_id == 149 || $model->category_id == 162 || $model->category_id == 161) {
                    $crop_mode = 3;
                }*/
                
                if (isset($img1)) ImageHelper::cSaveWithReducedCopies($img1, $model->image1, false, $crop_mode);
                if (isset($img2)) ImageHelper::cSaveWithReducedCopies($img2, $model->image2, false, $crop_mode);
                if (isset($img3)) ImageHelper::cSaveWithReducedCopies($img3, $model->image3, false, $crop_mode);
                if (isset($img4)) ImageHelper::cSaveWithReducedCopies($img4, $model->image4, false, $crop_mode);
                if (isset($img5)) ImageHelper::cSaveWithReducedCopies($img5, $model->image5, false, $crop_mode);

                if (!empty($model->image_url1)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image1, $model->image_url1, $crop_mode);
                if (!empty($model->image_url2)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image2, $model->image_url2, $crop_mode);
                if (!empty($model->image_url3)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image3, $model->image_url3, $crop_mode);
                if (!empty($model->image_url4)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image4, $model->image_url4, $crop_mode);
                if (!empty($model->image_url5)) ImageHelper::cSaveWithReducedCopies(new CUploadedFile(null, null, null, null, null), $model->image5, $model->image_url5, $crop_mode);
                
                // if ($model->status == 'active') {
                //     $template = Template:: model()->find("alias = 'accept_item' AND language = :lang",
                //         array(':lang' => Yii::app()->getLanguage()));

                //     LogHelper::log('accept_item action 1' . ', prod. id - ' . $id . ', user id - ' . (isset(Yii::app()->member->id) ? Yii::app()->member->id : 'unknown') . ', ip - ' . Yii::app()->request->getUserHostAddress());

                //     if (count($template)) {
                //         $mail = new Mail;
                //         $parameters = EmailHelper::setValues($template->content, array(
                //             $model->user, $model
                //         ));
                //         $message = Yii::t('base', $template->content, $parameters);
                //         $mail->send(
                //             $model->user->email,
                //             $template->subject,
                //             $message,
                //             $template->priority
                //         );
                //     }
                // }

                /*if ($model->status == Product::PRODUCT_STATUS_DEACTIVE) {
                    $template = Template:: model()->find("alias = 'reject_item' AND language = :lang",
                        array(':lang' => Yii::app()->getLanguage()));

                    if (count($template)) {
                        $mail = new Mail;
                        $parameters = EmailHelper::setValues($template->content, array(
                            $model->user, $model
                        ));
                        $message = Yii::t('base', $template->content, $parameters);
                        $mail->send(
                            $model->user->email,
                            $template->subject,
                            $message
                        );
                    }
                }*/

                if ($oldModelImage1 != $model->image1) {
                    ImageHelper::removeOldProductImages($oldModelImage1);
                }
                if ($oldModelImage2 != $model->image2) {
                    ImageHelper::removeOldProductImages($oldModelImage2);
                }
                if ($oldModelImage3 != $model->image3) {
                    ImageHelper::removeOldProductImages($oldModelImage3);
                }
                if ($oldModelImage4 != $model->image4) {
                    ImageHelper::removeOldProductImages($oldModelImage4);
                }
                if ($oldModelImage5 != $model->image5) {
                    ImageHelper::removeOldProductImages($oldModelImage5);
                }
                
                $path = $this->setCdnPath($model->id) . '/' . $model->image1;
                $image_path = Yii::getPathOfAlias('application') . '/../html' . ShopConst::IMAGE_MAX_DIR . 'medium/' . $model->image1;
                if ($this->copyToCdn($image_path, $path)) {
                    $model->image1 = $path;
                    if ($model->save()) {
                        unlink($image_path);
                    }
                }

                $this->redirect(array('view', 'id' => $model->id));
            } else {
                $model->image1 = $oldModelImage1;
                $model->image2 = $oldModelImage2;
                $model->image3 = $oldModelImage3;
            }
        }

        $this->render('update', array(
            'model' => $model,
            'invalidProd' => $invalidProd,
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->deleteImage($this->loadModel($id));
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }

        HttpHelper::saveGetParameters();

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Product $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function deleteImage($model, $image = null)
    {
        if (!is_null($image)) {
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $image;
            if (is_file($imagePath) && $model->existImg($image) < 2) {
                unlink($imagePath);
            }
        } else {
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $model->image1;
            if (is_file($imagePath) && $model->existImg($model->image1) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $model->image2;
            if (is_file($imagePath) && $model->existImg($model->image2) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $model->image3;
            if (is_file($imagePath) && $model->existImg($model->image3) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $model->image4;
            if (is_file($imagePath) && $model->existImg($model->image4) < 2)
                unlink($imagePath);
            $imagePath = Yii::getPathOfAlias('webroot.images.upload') . DIRECTORY_SEPARATOR . $model->image5;
            if (is_file($imagePath) && $model->existImg($model->image5) < 2)
                unlink($imagePath);
        }
        $this->removeFromCdn($model->image1);
    }

    public function actionGetSizeType()
    {
        $category = Category::model()->findByPk($_POST['Product']['category_id']);
        echo CHtml::encode($category->sizeType->type);
    }

    /**
     * Изменение статуса продукта.
     */
    public function actionSetStatusForProduct()
    {
        // Только Ajax-запрос.
        if (!Yii:: app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        // Проверяем входные данные на корректность.
        if (!isset($_POST['id'], $_POST['status']) ||
            !is_numeric($_POST['id']) ||
            !ctype_alpha($_POST['status'])
        ) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Проверяем, что переданный статус является
        // валидным статусом для данного продукта.
        if (!array_key_exists($_POST['status'], Product :: model()->getStatuses())) {
            throw new CHttpException(400, 'Bad Request');
        }

        // Продукт для которого необходимо поменять статус.
        $product = Product :: model()->findByPk($_POST['id']);
        $product->status = $_POST['status'];

        if ($product->save()) {

            if ($product->status == Product :: PRODUCT_STATUS_ACTIVE) {
                // Продукт принят к реализации.
                $templateCode = 'accept_item';
                LogHelper::log('accept_item action 2' . ', prod. id - ' . $_POST['id'] . ', user id - ' . (isset(Yii::app()->member->id) ? Yii::app()->member->id : 'unknown') . ', ip - ' . Yii::app()->request->getUserHostAddress());
            } elseif ($product->status == Product::PRODUCT_STATUS_PENDING) {
                // Товар ожидает изменения.
                $templateCode = 'edit_item';
            } else {
                //Товар отклонен
                $templateCode = 'reject_item';
            }

            // Отправляем уведомительное письмо владельцу товара.
            $template = Template:: model()->find(
                "alias = :alias AND language = :lang",
                array(
                    ':lang' => $product->user->language,
                    ':alias' => $templateCode
                )
            );
            if (count($template)) {

                // Параметры.
                $parameters = EmailHelper:: setValues($template->content, array(
                        $product,
                        $product->user
                    )
                );

                if ($product->status == Product :: PRODUCT_STATUS_PENDING &&
                    isset($_POST['extra']) && strlen($_POST['extra'])
                ) {
                    // Пользователю отправляется ссылка на страницу редактирования продукта
                    // с указанием неправильных полей (параметр 'wrong_fields').
                    $link = Yii :: app()->request->hostInfo .
                        '/my-account/sellupdate/' . $product->id .
                        '/?wrong_fields=' . urlencode($_POST['extra']);
                    $template->content = str_replace('{Option/link}',' <a href="' . $link . '">' . $link . '</a>',$template->content);
                }

                $mail = new Mail();
                $mail->send(
                    $product->user->email,
                    $template->subject,
                    Yii:: t('base', $template->content, $parameters),
                    $template->priority
                );

            }

            // Статус успешно сохранен.
            die(CJSON:: encode(array(
                'result' => 'ok'
            )));

        } else {
            // Не удалось сохранить статус.
            die(CJSON:: encode(array(
                'result' => 'error'
            )));
        }
    }

    public function actionSetOurChoice()
    {
        if (!Yii:: app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }

        if (!isset($_POST['id'], $_POST['value']) ||
            !is_numeric($_POST['id']) || !in_array($_POST['value'], array('0', '1'))
        ) {
            throw new CHttpException(400, 'Bad Request');
        }

        $product = Product:: model()->findByPk($_POST['id']);
        $product->our_selection = $_POST['value'];

        if ($product->save(false)) {
            die(CJSON:: encode(array(
                'result' => 'ok'
            )));
        } else {
            die(CJSON:: encode(array(
                'result' => 'error'
            )));
        }
    }

    public function actionApprove($id)
    {
        $product = Product::model()->findByPk($id);
        $product->status = Product::PRODUCT_STATUS_ACTIVE;

        if ($product->save()) {
            try {
                LogHelper::log('accept_item action 3' . ', prod. id - ' . $id . ', user id - ' . (isset(Yii::app()->member->id) ? Yii::app()->member->id : 'unknown') . ', ip - ' . Yii::app()->request->getUserHostAddress());
                $template = Template::model()->find(
                    "alias = 'accept_item' AND language = :lang",
                    array(
                        ':lang' => $product->user->language,
                    )
                );
                if (count($template)) {
                    $parameters = EmailHelper::setValues($template->content, array(
                            $product,
                            $product->user
                        )
                    );
                    $mail = new Mail();
                    $mail->send(
                        $product->user->email,
                        $template->subject,
                        Yii::t('base', $template->content, $parameters),
                        $template->priority
                    );
                }
            } catch (Exception $e) {

            }
        }
        $this->redirect(array('index'));
    }

    public function actionDecline($id)
    {
        $product = Product::model()->findByPk($id);
        try {
            $template = Template::model()->find(
                "alias = 'reject_item' AND language = :lang",
                array(
                    ':lang' => $product->user->language,
                )
            );
            if (count($template)) {
                $parameters = EmailHelper::setValues($template->content, array(
                        $product,
                        $product->user
                    )
                );
                $mail = new Mail();
                $mail->send(
                    $product->user->email,
                    $template->subject,
                    Yii::t('base', $template->content, $parameters),
                    $template->priority
                );
            }
        } catch (Exception $e) {

        }
        $this->deleteImage($this->loadModel($id));
        $this->loadModel($id)->delete();
        $this->redirect(array('index'));
    }
    
    public function actionImport()
    {
        if (ScrpProduct::setDataToProduct()) {
            Yii::app()->user->setFlash('importSuccess', Yii::t('base', 'Import successfully completed'));
        }
        $this->redirect(array('index'));
    }
    
    public function actionClear()
    {
        if (Product::clearImages()) {
            Yii::app()->user->setFlash('importSuccess', Yii::t('base', 'Clearing done'));
        }
        $this->redirect(array('index'));
    }
    
    protected function setCdnPath($id)
    {
        $path = sprintf('%08x', $id);
        $path = preg_replace('/^(.{2})(.{2})(.{2})(.{2})$/', '$1/$2/$3/$4', $path);
        return $path;
    }
    
    protected function copyToCdn($uploadFile, $path)
    {
        require_once(Yii::app()->basePath . "/helpers/amazon-s3-php-class-master/S3.php");
        
        $s3 = new S3($this->key, $this->secret);
        
        if ($s3->putObjectFile($uploadFile, $this->space_name, $path, S3::ACL_PUBLIC_READ)) {
            return true;
        }
        
        return false;
    }
    
    protected function removeFromCdn($path)
    {
        require_once(Yii::app()->basePath . "/helpers/Spaces-API-master/spaces.php");
        
        $space = new SpacesConnect($this->key, $this->secret, $this->space_name, $this->region);
        
        $space->DeleteObject($path);
    }
}

