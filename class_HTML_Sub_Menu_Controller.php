<?php
namespace HTML_Sub_Menu;
class Controller {

  private static $fields = array();

  function __construct($fields_to_add = array()) {
    add_action('wp_nav_menu_item_custom_fields', array( __CLASS__, 'render'), 10, 4);
    add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );


    if ($fields_to_add) {
      foreach ($fields_to_add as $key => $value) {
        self::$fields[$key] = $value;
      }
    }
  }

  function render( $id, $item, $depth, $args ) {
    foreach ( self::$fields as $_key => $label) {
      $key   = sprintf( 'menu-item-%s', $_key );
      $id    = sprintf( 'edit-%s-%s', $key, $item->ID );
      $name  = sprintf( '%s[%s]', $key, $item->ID );
      $value = get_post_meta( $item->ID, $key, true );
      $class = sprintf( 'field-%s', $_key );

      ?>
      <p class="description description-wide <?php echo esc_attr( $class ) ?>">
        <label for="<?php echo esc_attr( $id ); ?>">
          <?php echo esc_html( $label ); ?><br />
          <div id="<?php echo esc_attr( $id ) . '-wrapper'; ?>" class="hidden">
            <textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ) ?>"><?php echo esc_textarea( $value ); ?></textarea>
          </div><!-- .hidden -->
          <input type="button" class="button-secondary <?php echo esc_attr( $id ); ?>" onclick="jQuery('#<?php echo esc_attr( $id ) . '-wrapper'; ?>').toggleClass('hidden');" value="Edit HTML Sub-Menu" />
        </label>
      </p>
    <?php
    }
  }

  public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf( 'menu-item-%s', $_key );

			// Sanitize
			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				// Do some checks here...
				$value = $_POST[ $key ][ $menu_item_db_id ];
			}
			else {
				$value = null;
			}

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
			}
			else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
	}
}
