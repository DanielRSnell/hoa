<?php
namespace Artisan\Editor;

use Artisan\Editor\Handlers\AssetsHandler;
use Artisan\Editor\Handlers\ClassesHandler;
use Artisan\Editor\Handlers\InitHandler;
use Artisan\Editor\Handlers\TemplateHandler;

class Editor
{
    private static $instance = null;
    private $version = '1.0.0';
    private $assets_handler;
    private $classes_handler;
    private $init_handler;
    private $template_handler;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->assets_handler = new AssetsHandler($this->version);
        $this->classes_handler = new ClassesHandler();
        $this->init_handler = new InitHandler();
        $this->template_handler = new TemplateHandler();
    }

    public function renderEditor($context = [])
    {
        return $this->template_handler->renderEditor($context);
    }
}

return Editor::getInstance();
