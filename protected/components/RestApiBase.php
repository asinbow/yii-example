<?php
class RestApiBase
{
    private $controller;
    private $apiSchema;

    function __construct($controller, $apiSchema)
    {
        $this->controller = $controller;
        $this->apiSchema = $apiSchema;
    }

    public function actionList()
    {
        $this->actionNotImplemented();
    }

    public function actionView($id)
    {
        $this->actionNotImplemented();
    }

    public function actionCreate($attrs)
    {
        $this->actionNotImplemented();
    }

    public function actionUpdate($id, $attrs)
    {
        $this->actionNotImplemented();
    }

    public function actionDelete($id)
    {
        $this->actionNotImplemented();
    }

    protected function actionNotImplemented()
    {
        $this->controller->_sendResponse(501, 'Error: Action is not implemented');
    }
}
