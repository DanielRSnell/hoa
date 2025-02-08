<?php
namespace VillaCapriani\Controllers;

use Timber\Timber;

class FlexibleContent {
  protected $context;
  protected $post;

  public function __construct($post = null) {
    $this->context = Timber::context();
    $this->post = $post ?: Timber::get_post();
    $this->context['post'] = $this->post;
    $this->context['components'] = $this->getComponents();
  }

  public function render() {
    return Timber::render('layouts/flexible.twig', $this->context);
  }

  protected function getComponents() {
    $components = [];
    
    if (!function_exists('get_field')) {
      return $components;
    }

    $layouts = get_field('components', $this->post->ID);
    
    if (!$layouts) {
      return $components;
    }

    foreach ($layouts as $layout) {
      $components[] = [
        'template' => 'components/' . $layout['acf_fc_layout'] . '.twig',
        'data' => $layout
      ];
    }

    return $components;
  }
}
