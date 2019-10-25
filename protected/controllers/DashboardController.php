<?php

class DashboardController extends Controller
{
    public function init()
    {
        parent::init();
        if (!isset(Yii::app()->session['authenticated'])) {
            $this->redirect(array('/home'));
        }
    }

    public function actionIndex()
    {
        $this->render("home");
    }

    public function actionLogout()
    {
        Yii::app()->session->clear();
        Yii::app()->session->destroy();

        $this->redirect(array('/home'));
    }
}
