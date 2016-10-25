<?php
// this is how WP wants us to edit nav
add_filter('wp_edit_nav_menu_walker', 'use_GCK_Walker_Edit');


function use_GCK_Walker_Edit( $walker_to_use ) {
  $walker_to_use = 'GCK_Walker_Nav_Menu_Edit';
  if ( !class_exists($walker_to_use) ) {
    declare_GCK_walker();
  }
  return $walker_to_use;
}

function declare_GCK_walker() {
  if ( class_exists('Walker_Nav_Menu_Edit') ) {

    class GCK_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit{

      /*
      * Override the original to add a hook in
      */
      function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $dummy_output = '';
        parent::start_el( $dummy_output, $item, $depth, $args, $id );
        $output .= preg_replace(
          // NOTE: Check this regex from time to time!
          // it's liable to be defunct w/ WordPress updates
    			'/(?=<p[^>]+class="[^"]*field-move)/',
    			$this->call_hooks( $item, $depth, $args ),
    			$dummy_output
        );
      }

      protected function call_hooks( $item, $depth, $args = array(), $id = 0 ) {
        ob_start();
        do_action( 'wp_nav_menu_item_custom_fields', $id, $item, $depth, $args );
        return ob_get_clean();
      }
    }
  }
  else {
    error_log("Walker_Nav_Menu_Edit doesn't exist yet...");
  }
}


class GCK_custom_fields_manager {

  private static $fields = array();

  function init($fields_additive = array()) {
    add_action('wp_nav_menu_item_custom_fields', array( __CLASS__, 'print_fields'), 10, 4);

    if ($fields_additive) {
      foreach ($fields_additive as $key => $value) {
        self::$fields[$key] = $value;
      }
    }
  }

  function print_fields( $id, $item, $depth, $args ) {
    foreach ( self::$fields as $_key => $label) {
      $key   = sprintf( 'menu-item-%s', $_key );
      $id    = sprintf( 'edit-%s-%s', $key, $item->ID );
      $name  = sprintf( '%s[%s]', $key, $item->ID );
      $value = get_post_meta( $item->ID, $key, true );
      $class = sprintf( 'field-%s', $_key );

      ?>
      <p class="description description-wide <?php echo esc_attr( $class ) ?>">
        <?php printf(
          '<label for="%1$s">%2$s<br /><input type="button" id="%1$s" class="button-secondary $1$s" name="%3$s" value="Edit HTML Sub-Menu" /></label>',
          esc_attr( $id ),
          esc_html( $label ),
          esc_attr( $name )
        )
        ?>
      </p>
    <?php
    }
  }
}

GCK_custom_fields_manager::init( array(
  'HTML Sub-Menu' => 'HTML Sub-Menu'
) );
