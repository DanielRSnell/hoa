<?php
namespace VillaCapriani\Controllers;

use Timber\Timber;
use VillaCapriani\Models\Common\QueryBuilder;

class FlexibleContent
{
    protected $context;
    protected $post;

    public function __construct($post = null)
    {
        /**
         * Change controller to just handle a passed context to extract compoennts for live render.
         * Context creation and management should be handled at the controller level.
         * This prevents black box functionality allowing the developer to extend without additional knowledge other than standard
         * WordPress ecosystem knowledge.
         */
        $this->context = Timber::context();
        $this->post = $post ?: Timber::get_post();
        $this->context['post'] = $this->post;
        $this->context['components'] = $this->getComponents();
    }

    public function render()
    {
        return Timber::render('layouts/flexible.twig', $this->context);
    }

    protected function getComponents()
    {
        $components = [];

        if (!function_exists('get_field')) {
            return $components;
        }

        $layouts = get_field('components', $this->post->ID);

        if (!$layouts) {
            return $components;
        }

        foreach ($layouts as $layout) {
            $componentType = $layout['acf_fc_layout'];
            $variant = isset($layout['variant']) ? $layout['variant'] : 'default';

            // Process the component data
            $componentData = $this->processComponentData($layout);

            $components[] = [
                'template' => "components/{$componentType}/{$variant}.twig",
                'data' => $componentData,
            ];
        }

        return $components;
    }

    protected function processComponentData($layout)
    {
        $processedData = $layout;

        // Check for query data
        if ($this->hasQueryData($layout)) {
            $queryResults = QueryBuilder::executeQuery($layout);
            if ($queryResults !== false) {
                $processedData['query_results'] = $queryResults;
            }
        }

        // Process any nested queries
        $processedData = $this->processNestedQueries($processedData);

        return $processedData;
    }

    protected function hasQueryData($layout)
    {
        return isset($layout['query_mode']);
    }

    protected function processNestedQueries($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($this->hasQueryData($value)) {
                    $queryResults = QueryBuilder::executeQuery($value);
                    if ($queryResults !== false) {
                        $data[$key . '_results'] = $queryResults;
                    }
                }

                $data[$key] = $this->processNestedQueries($value);
            }
        }

        return $data;
    }
}
