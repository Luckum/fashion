<?php

class CommentsController extends AdminController
{
    public function actionBannedwords()
    {
        $data = implode(",", Yii::app()->params->bannedwords);
        if (isset($_POST['banned_words'])) {
            file_put_contents(Yii::app()->getBasePath().'/config/params/bannedwords.php', '<?php return ' . var_export(array_map('trim', explode(",", $_POST['banned_words'])), true) . ';');
            Yii::app()->user->setFlash('bannedwords','Banned words is changed successfuly!');
            $this->redirect(array('/control/'));
        }
        
        $this->render('bannedwords',array(
            'data' => $data,
        ));
    }

    public function actionModerate()
    {
        $dataProvider = new CActiveDataProvider('Comments', array(
            'sort'=>array(
                'defaultOrder'=>'added_date DESC',
            )
        ));
       
        $this->render('moderate',array(
            'model' => $dataProvider,
        ));
    }
    
    public function actionView($id = '', $userid = '')
    {
        if (empty($userid)) {
            $this->render('view',array(
                'model'=>$this->loadModel($id),
            ));
        } else {
            $user = User::model()->findByPk($userid);
            $ratings = Comments::model()->with(array('user' => array('alias' => 'buyer'), 'seller.user'))->findAll("t.user_id = :userId OR t.seller_id = :userId", array(':userId' => $userid));
            $this->render('messaging', array(
                'ratings' => $ratings,
                'user' => $user,
            ));
        }
    }
    
    public function loadModel($id)
    {
        $model = Comments::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    public function actionPublish($id, $type)
    {
        if ($type == 'c') {
            Comments::model()->updateAll(array("comment_status" => 'published'), "id = :id", array(':id' => $id));
        } else {
            Comments::model()->updateAll(array("response_status" => 'published'), "id = :id", array(':id' => $id));
        }
        
        $this->redirect(array('/control/settings/comments/moderate'));
    }
    public function actionBan($id, $type)
    {
        if ($type == 'c') {
            Comments::model()->updateAll(array("comment_status" => 'banned'), "id = :id", array(':id' => $id));
        } else {
            Comments::model()->updateAll(array("response_status" => 'banned'), "id = :id", array(':id' => $id));
        }
        
        $this->redirect(array('/control/settings/comments/moderate'));
    }
    
    public function actionUpdate($id, $type)
    {
        $model = $this->loadModel($id);
        
        if (isset($_POST['banned_comments'])) {
            if (isset($_POST['save'])) {
                if ($type == 'c') {
                    Comments::model()->updateAll(array("comment" => $_POST['banned_comments']), "id = :id", array(':id' => $id));
                } else {
                    Comments::model()->updateAll(array("response" => $_POST['banned_comments']), "id = :id", array(':id' => $id));
                }
            }
            if (isset($_POST['publish'])) {
                if ($type == 'c') {
                    Comments::model()->updateAll(array("comment" => $_POST['banned_comments']), "id = :id", array(':id' => $id));
                    Comments::model()->updateAll(array("comment_status" => 'published'), "id = :id", array(':id' => $id));
                } else {
                    Comments::model()->updateAll(array("response" => $_POST['banned_comments']), "id = :id", array(':id' => $id));
                    Comments::model()->updateAll(array("response_status" => 'published'), "id = :id", array(':id' => $id));
                }
            }
            $this->redirect(array('/control/settings/comments/moderate'));
        }
        $this->render('update',array(
            'model' => $model,
            'type' => $type,
        ));
    }
    
    public function actionDelete($id, $type)
    {
        if ($type == 'r') {
            Comments::model()->updateAll(array("response_status" => 'published', "response" => ''), "id = :id", array(':id' => $id));
        } else {
            $this->loadModel($id)->delete();
        }        
        
        $this->redirect(array('/control/settings/comments/moderate'));
    }
}
