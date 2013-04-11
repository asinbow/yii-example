<?php

class PublicController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionLogin()
	{
		$this->render('login',array('model'=>$model));
	}

	public function actionAuthenticate()
	{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $identity=new UserIdentity($username, $password);
        if($identity->authenticate())
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}

