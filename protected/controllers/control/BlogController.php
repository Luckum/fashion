<?php
/**
 * ���������� ������.
 */
class BlogController extends AdminController
{
    public function actionIndex()
    {
        $this -> render('index');
    }
}