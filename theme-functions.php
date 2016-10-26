<?php

add_filter('theme_primary_nav_menu_walker', 'visitor_walker');

function visitor_walker($walker)
{
  $walker_replacement = '\\HTML_Sub_Menu\\Nav_Walker';

  if (class_exists($walker)) {
    if (!class_exists($walker_replacement)) {
      include_once(dirname(__FILE__) . '/class-HTML_Sub_Menu_Nav_Walker.php');
    }
    $walker = $walker_replacement;
  }
  return $walker;
}
