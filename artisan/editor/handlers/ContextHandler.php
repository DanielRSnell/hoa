<?php
namespace Artisan\Editor\Handlers;

use Timber\Timber;

class ContextHandler
{
    private $context = [];

    public function mergeContext($userContext = [])
    {
        $this->context = array_merge(
            Timber::context(),
            $userContext,
            $this->getEditorContext()
        );

        return $this->context;
    }

    public function getContext()
    {
        return $this->context;
    }

    private function getEditorContext()
    {
        return [
            'editor' => [
                'post_id' => get_the_ID(),
                'form' => [
                    'post_id' => get_the_ID(),
                    'post_title' => false,
                    'post_content' => false,
                    'submit_value' => 'Update Page',
                    'return' => add_query_arg('editor', 'true', get_permalink()),
                ],
            ],
        ];
    }
}
