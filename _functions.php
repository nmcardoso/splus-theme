<?php

function register_menus() {
  // register_nav_menus(array(
  //   'primary' => __('Primary Menu', 'splus'),
  //   'footer' => __('Footer Menu', 'splus')
  // ));

  register_nav_menu('primary', __('Primary Menu'));
  register_nav_menu('footer', __('Footer Menu'));
}

add_action('after_setup_theme', 'register_menus');

function register_meta_box() {
  add_meta_box('meta1', __('Visibility'), 'meta_box_callback', null, 'side', 'high');
}

function meta_box_callback($post) {
  wp_nonce_field('save_meta_box_data', 'meta_box_nonce');

  $value = get_post_meta($post->ID, '_meta_is_private', true);
  $public = $value == 'public' ? 'selected' : '';
  $private = $value == 'private' ? 'selected' : '';

  $o  = '<label for="meta_box_private_field">Visibility </label>';
  $o .= '<select name="meta_box_private_field" id="meta_box_private_field">';
  $o .= '<option value="public" ' . $public . '>Public</option>';
  $o .= '<option value="private" ' . $private . '>Private</option>';
  $o .= '</select>';
  <ul class="navbar-nav ml-auto">
    <?php 
    foreach ($items as $item):
      $active = $item->object_id == get_the_ID() ? 'active' : '';
      $post_meta = get_post_meta($item->object_id);
      $show = true;
      if (isset($post_meta['_meta_is_private']) && 
          $post_meta['_meta_is_private'][0] == 'private'):
        $show = is_user_logged_in();
      endif;

      if ($show):
    ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $active; ?>" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
    </li>
    <?php
      endif;
    endforeach;
    if (!is_user_logged_in()):
    ?>
    <li class="nav-item">
      <a class="nav-link login" href="/login">Login</a>
    </li>
    <?php endif; ?>
  </ul>

  echo $o;
}

function meta_box_save_data($post_id) {
  if (
    !isset($_POST['meta_box_nonce']) ||
    !wp_verify_nonce($_POST['meta_box_nonce'], 'save_meta_box_data') ||
    (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
    !current_user_can('edit_post', $post_id) ||
    !isset($_POST['meta_box_private_field'])
  ) return;

  $data = $_POST['meta_box_private_field'];

  update_post_meta($post_id, '_meta_is_private' , $data);
}

add_action('add_meta_boxes', 'register_meta_box');
add_action('save_post', 'meta_box_save_data');