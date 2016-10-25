<?php

if ( class_exists( 'Walker_Nav_Menu' ) ) {

  class GoCheck_Site_Nav_Walker extends Walker_Nav_Menu {
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      if ( get_post_meta( $item->ID, 'menu-item-html-sub-menu', true ) ){
        error_log("There's something in here");
        $output .= '<div class="sub-menu"><div class="container"><div class="row">';
        $output .= get_post_meta( $item->ID, 'menu-item-html-sub-menu', true );
        $output .= '</div></div></div>';
      }
      $output .= "</li>\n";
    }

  }
}
else {
  error_log('Walker_Nav_Menu does not exist yet...');
}
