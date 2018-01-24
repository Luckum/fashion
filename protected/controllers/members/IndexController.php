<?php

class IndexController extends MemberController
{
    public $layout = '//layouts/index_layout';
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index', array());
    }
}