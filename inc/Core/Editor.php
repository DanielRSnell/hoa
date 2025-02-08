<?php
namespace VillaCapriani\Core;

class Editor {
  public static function init() {
    add_action('init', [self::class, 'removePageEditor']);
  }

  public static function removePageEditor() {
    remove_post_type_support('page', 'editor');
  }
}
