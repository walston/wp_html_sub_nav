<?php

if ( class_exists( 'Walker_Nav_Menu' ) ) {
  
  class GoCheck_Site_Nav_Walker extends Walker_Nav_Menu {
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      $output .= '<div class="sub-menu"><div class="container"><div class="row">';
      $output .= $item->post_content;
      $output .= '</div></div></div>';
      $output .= "</li>\n";
    }

  }
}
else {
  error_log('Walker_Nav_Menu does not exist yet...');
}
