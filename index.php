<?php
/** Plugin Name: GoCheck Site Navigation Bar
  * Description: Site Navigation using nav_menu_item->post_content as a dropdown
  * Version: 1.0.0
  * Author: Nathaniel Walston via Square 1 Partners
  * License: Copyright 2016 Square 1 Parners
  */

/** Dependencies:
  *   menu-item-custom-fieldsi
  */

add_action('wp_loaded', 'gck_navigation_init');
add_action('admin_init', 'gck_navigation_admin_init');

function gck_navigation_init() {
  include_once( dirname( __FILE__ ) . '/theme-functions.php');
}

function gck_navigation_admin_init() {
  include_once( dirname( __FILE__ ) . '/admin-functions.php');
}
