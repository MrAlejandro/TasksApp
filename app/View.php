<?php
namespace App;

use Smarty;

final class View extends Smarty
{
    protected $translator;

    public function __construct(\Gettext\Translator $translator)
    {
        parent::__construct();

        $this->translator = $translator;
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
        // Smarty setup
        $this->setTemplateDir(__DIR__ . '/../views');
        $this->setCompileDir(__DIR__ . '/../var/smarty/compiled');
        $this->setCacheDir(__DIR__ . '/../var/smarty/cache');

        // Translator setup
        // TODO: implement multilanguages support if required
        $this->translator->loadTranslations(__DIR__ . '/../var/langs/en.php');
        $this->translator->register(); // make the __() function global

        return $this;
    }
}
