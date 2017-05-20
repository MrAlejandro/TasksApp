<?php

namespace App\Controllers;

class Controller
{
    protected $view;

    public function __construct(\Smarty $view)
    {
        $this->view = $view;
        $this->configureView();
    }

    private function configureView()
    {
        $this->view->setTemplateDir(__DIR__ . '/../../views');
        $this->view->setCompileDir(__DIR__ . '/../../var/smarty/compiled');
        $this->view->setCacheDir(__DIR__ . '/../../var/smarty/cache');
        return $this;
    }
}

