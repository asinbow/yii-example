<?php
class Utils
{

    static function i18n()
    {
        $args = func_get_args();
        if (count($args)==0) return "";

        $args[0] = Yii::t('default', $args[0]);
        return call_user_func_array('sprintf', $args);
    }

    static function getUser() {
        return Yii::app()->user->getId();
    }
}

