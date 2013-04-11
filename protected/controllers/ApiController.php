<?php
class ApiController extends ApiControllerBase
{
    // Actions
    public function actionList()
    {
        $controller = $_GET['controller'];
        $apiSchema =  $this->_prepareSchema($controller);
        switch($apiSchema['type'])
        {
        case 'model':
            $method = $this->_prepareMethod($apiSchema, 'GET');
            $fields = $method['fields'];
            $model = self::_getModel($apiSchema['model']);
            $records = $model->findAll();
            $items = array();
            foreach($records as $record)
            {
                $item = array();
                foreach ($fields as $field)
                {
                    $item[$field] = $record->$field;
                }
                $items[] = $item;
            }
            $this->_sendResponse(200, CJSON::encode($items));
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $items = $handler->actionList();
            $this->_sendResponse(200, CJSON::encode($items));
            break;
        default:
            $this->_sendResponse(501, Utils::i18n(
                'misconf:controller_unknown_type', $controller, $apiSchema['type'])
            );
        }
    }
    public function actionView()
    {
        $id = $_GET['id'];
        $controller = $_GET['controller'];
        $apiSchema =  $this->_prepareSchema($controller);
        switch($apiSchema['type'])
        {
        case 'model':
            $method = $this->_prepareMethod($apiSchema, 'GET');
            $fields = $method['fields'];
            $model = self::_getModel($apiSchema['model']);
            $record = $model->findByPk($id);
            $item = array();
            foreach ($fields as $field)
            {
                $item[$field] = $record->$field;
            }
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $item = $handler->actionView($id);
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        default:
            $this->_sendResponse(501, Utils::i18n(
                'misconf:controller_unknown_type', $controller, $apiSchema['type'])
            );
        }
    }
    public function actionCreate()
    {
        $controller = $_POST['controller'];
        $apiSchema =  $this->_prepareSchema($controller);
        $attrs = $_POST;
        switch($apiSchema['type'])
        {
        case 'model':
            $method = $this->_prepareMethod($apiSchema, 'POST');
            $fields = $method['fields'];
            $model = $apiSchema['model'];
            $record = new $model;
            foreach($attrs as $field=>$value) {
                if($record->hasAttribute($field) && in_array($field, $fields))
                    $record->$field = $value;
                else
                    $this->_sendResponse(403, Utils::i18n(
                        'error:model_parameter_not_allow', $model, $field)
                    );
            }
            if ($record->save())
                $this->_sendResponse(200, CJSON::encode($record));
            else
            {
                $this->_sendResponse(500, Utils::i18n('error:model_db_action', $model, 'create'));
            }
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $item = $handler->actionCreate($attrs);
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        default:
            $this->_sendResponse(501, Utils::i18n(
                'misconf:controller_unknown_type', $controller, $apiSchema['type'])
            );
        }
    }
    public function actionUpdate()
    {
        $id = $_GET['id'];
        $json = file_get_contents('php://input');
        $attrs = CJSON::decode($json,true);

        $controller = $_GET['controller'];
        $apiSchema =  $this->_prepareSchema($controller);
        switch($apiSchema['type'])
        {
        case 'model':
            $method = $this->_prepareMethod($apiSchema, 'PUT');
            $fields = $method['fields'];

            $model = self::_getModel($apiSchema['model']);
            $record = $model->findByPk($id);
            if(!$record)
                $this->_sendResponse(400, Utils::i18n('error:record_not_exists', $model, $id));

            $changed = false;
            foreach($attrs as $field=>$value) {
                if($record->hasAttribute($field))
                {
                    if ($record->$field==$value)
                        continue;
                    if (in_array($field, $fields))
                    {
                        $changed = true;
                        $record->$field = $value;
                        continue;
                    }
                }
                $this->_sendResponse(403, Utils::i18n(
                    'error:model_parameter_not_allow', $apiSchema['model'], $field)
                );
            }

            if (!$changed || $record->save())
                $this->_sendResponse(200, CJSON::encode($record));
            else
            {
                $this->_sendResponse(500, Utils::i18n('error:model_db_action', $apiSchema['model'], 'update'));
            }
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $item = $handler->actionUpdate($id, $attrs);
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        default:
            $this->_sendResponse(500, Utils::i18n(
                'misconf:controller_unknown_type', $controller, $apiSchema['type'])
            );
        }
    }
    public function actionDelete()
    {
        $id = $_GET['id'];

        $controller = $_GET['controller'];
        $apiSchema =  $this->_prepareSchema($controller);
        switch($apiSchema['type'])
        {
        case 'model':
            $method = $this->_prepareMethod($apiSchema, 'DELETE');
            $fields = $method['fields'];

            $model = self::_getModel($apiSchema['model']);
            $record = $model->findByPk($id);
            if(!$record)
                $this->_sendResponse(400, Utils::i18n('error:record_not_exists', $apiSchema['model'], $id));

            $num = $record->delete();
            if ($num>0)
                $this->_sendResponse(200, $num);
            else
                $this->_sendResponse(500, Utils::i18n('error:model_db_action', $apiSchema['model'], 'delete'));
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $item = $handler->actionUpdate($id, $attrs);
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        default:
            $this->_sendResponse(501, Utils::i18n(
                'misconf:controller_unknown_type', $controller, $apiSchema['type'])
            );
        }
    }

    private function _checkRoll($rolls, $desc) {
        $user = Yii::app()->user->getId();
        if (!$user)
        {
            $this->_sendResponse(401, Utils::i18n('error:need_login', $desc));
        }

        if (!$user->valid)
        {
            $this->_sendResponse(401, Utils::i18n('error:account_not_valid', $user->name));
        }

        // check roll type
        if ($rolls)
        {
            $roll = $user->getRoll();
            if (!in_array($roll, $rolls))
            {
                $this->_sendResponse(401, Utils::i18n('error:roll_has_no_privilege', $roll, join(',', $rolls), $desc));
            }
        }
    }

    private function _prepareSchema($controller)
    {
        $apiSchema = self::$apiSchemas[$controller];
        if (!$apiSchema)
        {
            $this->_sendResponse(501, Utils::i18n('error:api_not_implemented', $_GET['controller']));
        }

        // check login state, default true
        if (!array_key_exists('login', $apiSchema) || $apiSchema['login'])
        {
            $this->_checkRoll($apiSchema['roll'], $apiSchema['model']);
        }

        return $apiSchema;
    }

    private function _prepareMethod($apiSchema, $name)
    {
        $method = $apiSchema[$name];
        if (!$method) {
            $this->_sendResponse(501, Utils::i18n(
                'error:model_method_not_implemented', $apiSchema['model'], $name)
            );
        }
        $rolls = $method['roll'];
        if ($rolls) {
            $this->_checkRoll($rolls, $apiSchema['model'] . '.' . $name);
        }
        return $method;
    }
}

