<?php
namespace Artisan\Editor;

class Editor
{
    private static $instance = null;
    private $version = '1.0.0';
    private $handlers = [];

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->initializeHandlers();
    }

    private function initializeHandlers()
    {
        // Initialize base handlers first
        $this->handlers['assets'] = new Handlers\AssetsHandler($this->version);
        $this->handlers['classes'] = new Handlers\ClassesHandler();
        $this->handlers['init'] = new Handlers\InitHandler();
        $this->handlers['context'] = new Handlers\ContextHandler();
        $this->handlers['rules'] = new Handlers\RulesHandler();

        // Initialize handlers that depend on other handlers last
        $this->handlers['render'] = new Handlers\RenderHandler(
            $this->handlers['context'],
            $this->handlers['rules']
        );
    }

    public function render($context = [])
    {
        return $this->getHandler('render')->render($context);
    }

    private function getHandler($name)
    {
        return $this->handlers[$name] ?? null;
    }
}
