<?php
namespace App\Controllers;

class Controller
{
    protected $view;
    protected $controllerName;
    protected $actionName;

    public function __construct(\App\View $view)
    {
        $this->view = $view;
    }

    public function setControllerName($controllerName = '')
    {
         if (null === $this->controllerName && !empty($controllerName)) {
            $this->controllerName = $controllerName;
            return true;
        }

        return false;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function setActionName($actionName = '')
    {
        if (null === $this->actionName && !empty($actionName)) {
            $this->actionName = $actionName;
            return true;
        }

        return false;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    protected function render($templateName = '')
    {
        if (empty($templateName)) {
            $templateName = $this->getDefaultTemplateName();
        }

        if ($this->view->templateExists($templateName)) {
            $this->view->assign('render_template', $templateName);
        }

        $this->view->assign('view', $this->view);

        $this->view->display('index.tpl');
    }

    protected function getDefaultTemplateName()
    {
        $templateName = '';

        if (!empty($this->templatesDir) && !empty($this->actionName)) {
            $templateName = implode(
                '/',
                [
                    $this->templatesDir,
                    "{$this->actionName}.tpl",
                ]
            );
        }

        return $templateName;

    }
}