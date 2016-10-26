<?php
/** Plugin Name: GoCheck Site Navigation Bar
  * Description: Site Navigation using nav_menu_item->post_content as a dropdown
  * Version: 1.0.0
  * Author: Nathaniel Walston via Square 1 Partners
  * License: Copyright 2016 Square 1 Parners
  */
namespace HTML_Sub_Menu {

add_action('wp_loaded', 'HTML_Sub_Menu\theme');
add_action('admin_init', 'HTML_Sub_Menu\admin');

function theme() {
  include_once( dirname( __FILE__ ) . '/theme-functions.php');
}

function admin() {
  include_once( dirname( __FILE__ ) . '/admin-functions.php');
}

} // namespace HTML_Sub_Menu
