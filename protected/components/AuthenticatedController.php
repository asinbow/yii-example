<?php
class AuthenticatedController extends Controller
{
    
    protected function beforeAction($action) {
        $user = Utils::getUser();
        if (!$user)
        {
            $this->redirect("/index.php/public/login");
        }

        return parent::beforeAction($action);
    }
}
