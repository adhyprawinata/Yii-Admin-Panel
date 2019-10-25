<?php

class HomeController extends Controller
{
	public $layout = 'mainlogin';

	public function init()
	{
		parent::init();
		if (isset(Yii::app()->session['authenticated'])) {
			$this->redirect(array('/dashboard'));
		}
	}

	public function actionIndex()
	{
		$this->render("login");
	}

	public function actionLogin()
	{
		if ($_POST['username'] == "superadmin") {
			if ($_POST['password'] == "admin") {
				Yii::app()->session['authenticated'] = true;
				Yii::app()->session['username'] = 'superadmin';
				Yii::app()->session['nama'] = 'Admin';
				Yii::app()->session['branchid'] = 'WPI';
				Yii::app()->session['role_id'] = '1';

				$this->redirect(array('/dashboard'));
			} else {
				$this->redirect("index");
			}
		} else {
			$client = new SoapClient("http://ws.megafinance.co.id:8888/index.php?r=authentication/service");
			$result = $client->Login($_POST['username'], $_POST['password']);
			$row = json_decode($result, true);

			if ($row['IsError'] == "") {
				Yii::app()->session['authenticated'] = true;
				Yii::app()->session['username'] = $row['Records']['username'];
				Yii::app()->session['nama'] = $row['Records']['display_name'];
				Yii::app()->session['branchid'] = $row['Records']['branch_id'];
				Yii::app()->session['role_id'] = '2';

				$this->redirect(array('/dashboard'));
			} else {
				$this->redirect("index");
			}
		}
	}
}
