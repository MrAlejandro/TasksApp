<?php
namespace App\Controllers;

class Controller
{
    protected $view;

    public function __construct(\App\View $view)
    {
        $this->view = $view;
    }
}

