<?php

class ColorsController extends AdminController
{
    public function actionIndex()
    {
        $data = implode(",", Yii::app()->params->colors);
        if (isset($_POST['colors'])) {
            file_put_contents(Yii::app()->getBasePath() . '/config/params/colors.php', '<?php return ' . var_export(array_map('trim', explode(",", $_POST['colors'])), true) . ';');
            Yii::app()->user->setFlash('colors', 'Colors is changed successfuly!');
            $this->redirect(array('/control/'));
        }

        $this->render('index', array(
            'data' => $data,
        ));
    }
}