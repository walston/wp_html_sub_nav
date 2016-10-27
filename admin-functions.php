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

/**
 *  Construct a new navigation menu item, and generate a corresponding action
 *  of format "menu-item-{$slug}-render" for rendering html
 *
 *  @since 1.0.0
 *
 *  @argument array in format $slug => $label
 *
 */
new HTML_Sub_Menu\Controller(array('html-sub-menu' => 'HTML Sub-Menu'));

/**
 *  Automatically generated action for each new form-field
 *
 *  @since 1.0.0
 *
 *  @argument string  $action-slug Generated as "menu-item-{$slug}-render"
 *  @argument string  $callable    Function name of renderer
 *  @argument integer $priority    Lower = earlier (should only be 1 render callable per menu-item)
 *  @argument integer $arguments   should always be 6, see documentation below
 *
 */
add_action('menu-item-html-sub-menu-render', 'html_sub_menu_render', 1, 6);

/**
 *  Rendering function for menu-item-html-sub-menu-render
 *
 *  @since 1.0.0
 *
 *  @param string $label  Label to display above control in HTML
 *  @param string $key    Post_Meta key, used to find in wp_postmeta table
 *  @param string $id     REQUIRED HTML id tag
 *  @param string $name   REQUIRED form input name, used for POST submission
 *  @param string $value  REQUIRED the value of this Post_Meta
 *  @param string $class  REQUIRED wordpress builtins for paragraph wrapper
 *
 */
function html_sub_menu_render($label, $key, $id, $name, $value, $class)
{
  ?>
  <p class="description description-wide <?php echo esc_attr($class) ?>">
    <label for="<?php echo esc_attr($id); ?>">
      <?php echo esc_html($label); ?><br />
      <select name="<?php echo esc_attr($name); ?>" class="widefat">
        <option value="">No Submenu</option>
        <?php echo dropdown_render($value); ?>
      </select>
    </label>
    <a href="/wp-admin/post-new.php?post_type=html_sub_menu">Create New Sub-Menu</a>
  </p>
  <?php
}

function dropdown_render($selected_value)
{
  ob_start();

  $html_sub_menus = get_posts(array('post_type' => 'html_sub_menu'));

  foreach ($html_sub_menus as $submenu) {
    $id = $submenu->ID;
    $title = $submenu->post_title;

    echo sprintf(
      '<option value="%1$s"%3$s>%2$s</option>',
      esc_attr($id),
      esc_html($title),
      $selected_value == $id ? ' selected="selected"' : ''
    );
  }

  return ob_get_clean();
}
