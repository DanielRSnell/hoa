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
        // Initialize handlers
        $this->handlers = [
            'assets' => new Handlers\AssetsHandler($this->version),
            'classes' => new Handlers\ClassesHandler(),
            'init' => new Handlers\InitHandler(),
            'context' => new Handlers\ContextHandler(),
            'rules' => new Handlers\RulesHandler(),
            'render' => new Handlers\RenderHandler(
                $this->getHandler('context'),
                $this->getHandler('rules')
            ),
        ];
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
