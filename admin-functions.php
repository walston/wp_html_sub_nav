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
  $wrapperId = $id . '-wrapper';
  add_thickbox();
  ?>
  <p class="description description-wide <?php echo esc_attr($class) ?>">
    <label for="<?php echo esc_attr($wrapperId); ?>">
      <?php echo esc_html($label); ?><br />
      <fieldset id="<?php echo esc_attr($wrapperId); ?>" class="hidden">
        <p>
          <label for="<?php echo esc_attr($id); ?>">
            <?php echo esc_html($label); ?>
            <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name) ?>" class="widefat"><?php echo esc_textarea($value); ?></textarea>
          </label>
        </p>
      </fieldset><!-- .hidden -->
      <a href="TB_inline?width=600&height=550&inlineId=<?php echo esc_attr($wrapperId); ?>" class="thickbox">
        <input type="button" class="button-secondary <?php echo esc_attr($id); ?>" value="Edit HTML Sub-Menu" />
      </a>
    </label>
  </p>
  <?php
}
