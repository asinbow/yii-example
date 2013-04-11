<?php

class SiteController extends AuthenticatedController
{
	public function actionIndex()
	{
		$this->render('index', array('name'=>'ASINBOW'));
	}

}
