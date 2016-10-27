<?php
/**
  * Register new Post_Type of submenu
  */

register_post_type('html_sub_menu', array(
  'labels' => array(
    'name' => 'Sub-Menus',
    'singular_name' => 'Sub-Menu',
    'menu_name' => 'HTML Sub-Menus'
  ),
  'description' => 'HTML Sub-Menus for use in custom \HTML_Sub_Menu\Nav_Walker',
  'public' => FALSE,
  'exclude_from_search' => TRUE,
  'show_ui' => TRUE,
  'supports' => array('title','editor','revisions'),
  'can_export' => TRUE,
));
