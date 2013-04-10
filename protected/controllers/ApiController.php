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
            $this->_sendResponse(501,
                sprintf('Error: REST API <b>%s</b> is not implemented', $_GET['controller'])
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
            $this->_sendResponse(501,
                sprintf('Error: REST API <b>%s</b> is not implemented', $_GET['controller'])
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
                    $this->_sendResponse(500, sprintf(
                        'Parameter <b>%s</b> is not allowed for model <b>%s</b>',
                        $fields, $model)
                    );
            }
            if ($record->save())
                $this->_sendResponse(200, CJSON::encode($record));
            else
            {
                $msg = "<h1>Error</h1>";
                $msg .= sprintf("Couldn't create model <b>%s</b>", $model);
                $msg .= "<ul>";
                foreach($record->errors as $attribute=>$attr_errors) {
                    $msg .= "<li>Attribute: $attribute</li>";
                    $msg .= "<ul>";
                    foreach($attr_errors as $attr_error)
                        $msg .= "<li>$attr_error</li>";
                    $msg .= "</ul>";
                }
                $msg .= "</ul>";
                $this->_sendResponse(500, $msg );
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
            $this->_sendResponse(501,
                sprintf('Error: REST API <b>%s</b> is not implemented', $_GET['controller'])
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
                $this->_sendResponse(400, 
                    sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $apiSchema['model'], $id)
                );

            foreach($attrs as $field=>$value) {
                if($record->hasAttribute($field) && in_array($field, $fields))
                    $record->$field = $value;
                else
                    $this->_sendResponse(500, sprintf(
                        'Parameter <b>%s</b> is not allowed for model <b>%s</b>',
                        $fields, $model)
                    );
            }

            if ($record->save())
                $this->_sendResponse(200, CJSON::encode($record));
            else
            {
                $msg = "<h1>Error</h1>";
                $msg .= sprintf("Couldn't update model <b>%s</b>", $apiSchema['model']);
                $msg .= "<ul>";
                foreach($record->errors as $attribute=>$attr_errors) {
                    $msg .= "<li>Attribute: $attribute</li>";
                    $msg .= "<ul>";
                    foreach($attr_errors as $attr_error)
                        $msg .= "<li>$attr_error</li>";
                    $msg .= "</ul>";
                }
                $msg .= "</ul>";
                $this->_sendResponse(500, $msg );
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
            $this->_sendResponse(501,
                sprintf('Error: REST API <b>%s</b> is not implemented', $_GET['controller'])
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
                $this->_sendResponse(400, 
                    sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $apiSchema['model'], $id)
                );

            $num = $record->delete();
            if ($num>0)
                $this->_sendResponse(200, $num);
            else
                $this->_sendResponse(500, 
                    sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
                    $apiSchema['model'], $id)
                );
            break;
        case 'class':
            $class = $apiSchema['class'];
            include(dirname(__FILE__) . '/api/' . $class . '.php');
            $handler = new $class($this, $apiSchema);
            $item = $handler->actionUpdate($id, $attrs);
            $this->_sendResponse(200, CJSON::encode($item));
            break;
        default:
            $this->_sendResponse(501,
                sprintf('Error: REST API <b>%s</b> is not implemented', $_GET['controller'])
            );
        }
    }

    private function _prepareSchema($controller)
    {
        $apiSchema = self::$apiSchemas[$controller];
        if (!$apiSchema)
        {
            $this->_sendResponse(501,
                sprintf('Error: API <b>%s</b> is not implemented', $_GET['model'])
            );
        }

        // check login state, default true
        if (!array_key_exists('login', $apiSchema) || $apiSchema['login'])
        {
        }

        // check roll type
        if ($apiSchema['roll'])
        {
            // is_array
        }

        return $apiSchema;
    }

    private function _prepareMethod($apiSchema, $name)
    {
        $method = $apiSchema[$name];
        if (!$method) {
            $this->_sendResponse(401, 
                sprintf('Error: METHOD <b>%s</b> not available on %s <b>%s</b>',
                    $name, $apiSchema['type'], $apiSchema['model'])
            );
        }
        return $method;
    }
}

