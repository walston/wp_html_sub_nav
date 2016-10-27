<?php
namespace HTML_Sub_Menu;

class Nav_Walker extends \Walker_Nav_Menu
{
  public function end_el(&$output, $item, $depth = 0, $args = array())
  {
    $submenuID = get_post_meta($item->ID, 'menu-item-html-sub-menu', true);

    if ($submenuID === "0" || $submenuID > 0) {
      $submenu = array(
        'content' => get_post($submenuID)->post_content,
        'status' => get_post($submenuID)->post_status
      );
    }

    if ($submenu && $submenu['status'] == 'publish') {
      $output .= '<div class="sub-menu">';
      $output .= '<div class="container">';
      $output .= '<div class="row">';
      $output .= $submenu['content'];
      $output .= '</div></div></div>';
    }
    parent::end_el($output, $item, $depth, $args);
  }
}
