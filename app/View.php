<?php
namespace App;

use Smarty;

final class View extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->init();
        $this->assign([
            'view' => $this,
        ]);
    }

    public function __($text = '', $lang = 'en')
    {
        // TODO: implement translation logic if required
        return $text;
    }

    private function init()
    {
        $this->setTemplateDir(__DIR__ . '/../views');
        $this->setCompileDir(__DIR__ . '/../var/smarty/compiled');
        $this->setCacheDir(__DIR__ . '/../var/smarty/cache');

        return $this;
    }
}
