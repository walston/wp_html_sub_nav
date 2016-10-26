<?php
namespace HTML_Sub_Menu;

class Controller
{

  private static $fields = array();

  function __construct($fields_to_add = array())
  {
    add_action('wp_nav_menu_item_custom_fields', array(__CLASS__, 'render'), 10, 4);
    add_action('wp_update_nav_menu_item', array(__CLASS__, '_save'), 10, 3);

    if ($fields_to_add) {
      foreach ($fields_to_add as $key => $value) {
        self::$fields[$key] = $value;
      }
    }
  }

  function render($id, $item, $depth, $args)
  {
    foreach (self::$fields as $_key => $label) {
      $key   = sprintf('menu-item-%s', $_key);
      $id    = sprintf('edit-%s-%s', $key, $item->ID);
      $name  = sprintf('%s[%s]', $key, $item->ID);
      $value = get_post_meta($item->ID, $key, true);
      $class = sprintf('field-%s', $_key);

      $action_name = $key . '-render';
      error_log(str_repeat('!_LOG', 8));
      error_log($action_name);
      do_action($action_name, $label, $key, $id, $name, $value, $class);
    }
  }

  public static function _save($menu_id, $menu_item_db_id, $menu_item_args)
  {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			return;
		}

		check_admin_referer('update-nav_menu', 'update-nav-menu-nonce');

		foreach (self::$fields as $_key => $label) {
			$key = sprintf('menu-item-%s', $_key);

			// Sanitize
			if (! empty($_POST[ $key ][ $menu_item_db_id ])) {
				// Do some checks here...
				$value = $_POST[ $key ][ $menu_item_db_id ];
			}
			else {
				$value = null;
			}

			// Update
			if (! is_null($value)) {
				update_post_meta($menu_item_db_id, $key, $value);
			}
			else {
				delete_post_meta($menu_item_db_id, $key);
			}
		}
	}
}
