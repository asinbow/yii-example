<?php
class Utils
{
    static function uuid()
    {
        return UUID::generate(UUID::UUID_RANDOM, UUID::FMT_STRING);
    }

    static function assetsDir()
    {
        return Yii::app()->basePath . '/../assets';
    }

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

    static function getLoginUrl($redirect) {
        $baseUrl = Yii::app()->request->baseUrl;
        $loginUrl = "$baseUrl/index.php/public/login";
        if ($redirect) {
            $loginUrl = $loginUrl . "?redirect=" . urlencode($redirect);
        }
        return $loginUrl;
    }

    static function getUploadedFile($files, $name)
    {
        $file = $files[$name];
        if ($file)
        {
            $error = $file['error'];
            if (empty($error))
            {
                $tmp_name = $file['tmp_name'];
                if ($tmp_name && $tmp_name!='none')
                {
                    $fname = $file['name'];
                    $info = pathinfo($fname);
                    $result = array(
                        'file'=>$tmp_name,
                        'fname'=>$fname,
                        'ext'=>$info['extension'],
                    );
                }
                else
                {
                    $result['error'] = 'No file was uploaded';
                }
            }
            else
            {
                switch($error)
                {
                case '1':
                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;
                case '2':
                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;
                case '3':
                    $error = 'The uploaded file was only partially uploaded';
                    break;
                case '4':
                    $error = 'No file was uploaded.';
                    break;

                case '6':
                    $error = 'Missing a temporary folder';
                    break;
                case '7':
                    $error = 'Failed to write file to disk';
                    break;
                case '8':
                    $error = 'File upload stopped by extension';
                    break;
                case '999':
                default:
                    $error = 'No error code avaiable';
                }
                $result['error'] = $error;
            }
        }
        else
        {
            $result['error'] = 'File with name not found';
        }
        return $result;
    }
}

