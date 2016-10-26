<?php
namespace HTML_Sub_Menu {

  // wp_hook to replace the class the name of the admin_nav_walker
  function replace_walker( $walker ) {
    $walker_replacement = 'HTML_Sub_Menu_Editor_Nav_Walker';
    // is the original defined?
    // we'll need it in our definition;
    if ( class_exists( $walker ) ) {
      // if our class is already instantiated, we needn't redeclare it
      // this is a safety measure… odds are against this ever not happening
      if ( ! class_exists( $walker_replacement ) ) {
        include_once( dirname(__FILE__) . "/class-HTML_Sub_Menu_Editor_Nav_Walker.php");
      }
      $walker = $walker_replacement;
    }
    return $walker;
  }

} // namespace HTML_Sub_Menu

namespace { // global

add_filter('wp_edit_nav_menu_walker', 'HTML_Sub_Menu\replace_walker');

include_once( dirname( __FILE__ ) . "/class_HTML_Sub_Menu_Controller.php");

new HTML_Sub_Menu\Controller( array(
  'html-sub-menu' => 'HTML Sub-Menu'
) );

} // namespace global
