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


add_action('wp_nav_menu_item_custom_fields', 'a_thing', 10, 4);
function a_thing( $id, $item, $depth, $args ) {
  ?>
  <p class="description description-wide <?php echo esc_attr( $class ) ?>">
    Hello, World!
  </p>
  <?php
}
