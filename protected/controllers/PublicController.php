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
        
        $redirect = Yii::app()->request->getQuery("redirect", Yii::app()->homeUrl);
		$this->render('login',array('redirect'=>$redirect));
	}

	public function actionAuthenticate()
	{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $redirect = $_POST['redirect'];
        if ($username && $password) {
            $rememberme = $_POST['rememberme'];
            $identity=new UserIdentity($username, $password);
            $identity->authenticate();
            if($identity->errorCode===UserIdentity::ERROR_NONE)
            {
                $duration=$rememberme ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($identity,$duration);
                if (!$redirect) $redirect = Yii::app()->homeUrl;
                $this->redirect($redirect);
            }
        }
        $this->redirect(Utils::getLoginUrl($redirect));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}

