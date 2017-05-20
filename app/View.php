<?php

namespace App;

use Smarty;

final class View extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    private function init()
    {
        $this->setTemplateDir(__DIR__ . '/../views');
        $this->setCompileDir(__DIR__ . '/../var/smarty/compiled');
        $this->setCacheDir(__DIR__ . '/../var/smarty/cache');

        return $this;
    }
}
