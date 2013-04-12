<?php
class AuthenticatedController extends Controller
{

    protected function beforeAction($action) {
        $user = $this->getUser();
        if ($user)
            return parent::beforeAction($action);

        $redirect = Utils::getLoginUrl($_SERVER['REQUEST_URI']);
        $this->redirect($redirect);
    }
}
