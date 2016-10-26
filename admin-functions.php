<?php

add_filter('wp_edit_nav_menu_walker', 'admin_walker');

function admin_walker($walker)
{
  $walker_replacement = '\\HTML_Sub_Menu\\Editor_Nav_Walker';

  if (class_exists($walker)) {
    if (!class_exists($walker_replacement)) {
      include_once(dirname(__FILE__) . "/class-HTML_Sub_Menu_Editor_Nav_Walker.php");
    }
    $walker = $walker_replacement;
  }
  return $walker;
}

include_once(dirname(__FILE__) . "/class_HTML_Sub_Menu_Controller.php");

new HTML_Sub_Menu\Controller(array(
  'html-sub-menu' => 'HTML Sub-Menu'
));
