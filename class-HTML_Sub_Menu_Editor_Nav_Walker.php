<?php
namespace HTML_Sub_Menu;

class Editor_Nav_Walker extends \Walker_Nav_Menu_Edit
{

  /*
  * Override the original to add a hook in
  */
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
    $dummy_output = '';
    parent::start_el($dummy_output, $item, $depth, $args, $id);
    $output .= preg_replace(
      // NOTE: Check this regex from time to time!
      // it's liable to be defunct w/ WordPress updates
      '/(?=<p[^>]+class="[^"]*field-move)/',
      $this->call_hooks($item, $depth, $args),
      $dummy_output
    );
  }

  protected function call_hooks($item, $depth, $args = array(), $id = 0)
  {
    ob_start();
    // TODO there's got to be a better way to define this…
    // …IMO this is too "magical" and removed from it's definition
    do_action('wp_nav_menu_item_custom_fields', $id, $item, $depth, $args);
    return ob_get_clean();
  }
}
