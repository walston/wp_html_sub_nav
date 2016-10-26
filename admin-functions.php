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

add_action('menu-item-html-sub-menu-render', 'html_sub_menu_render', 1, 6);
function html_sub_menu_render($label, $key, $id, $name, $value, $class)
{
  ?>
  <p class="description description-wide <?php echo esc_attr($class) ?>">
    <label for="<?php echo esc_attr($id); ?>">
      <?php echo esc_html($label); ?><br />
      <div id="<?php echo esc_attr($id) . '-wrapper'; ?>" class="hidden">
        <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name) ?>"><?php echo esc_textarea($value); ?></textarea>
      </div><!-- .hidden -->
      <input type="button" class="button-secondary <?php echo esc_attr($id); ?>" onclick="jQuery('#<?php echo esc_attr($id) . '-wrapper'; ?>').toggleClass('hidden');" value="Edit HTML Sub-Menu" />
    </label>
  </p>
  <?php
}
