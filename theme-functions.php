<?php
if ( class_exists( 'Walker_Nav_Menu' ) ) {
  if ( !class_exists( 'GoCheck_Site_Nav_Walker' ) ) {
    include_once( dirname( __FILE__ ) . '/class-HTML_Sub_Menu_Nav_Walker.php');
  }
}
