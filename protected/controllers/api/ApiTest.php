<?php
class ApiTest extends RestApiBase
{
    public function actionList()
    {
        return array(
            array(
                'name'=>'admin',
            ),
            array(
                'name'=>'test',
            ),
        );
    }
    public function actionView($id)
    {
        return array(
            'name'=>'admin',
            //'name'=> Yii::app()->user->getId(),
        );
    }
}



