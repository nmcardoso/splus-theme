<?php

$dev_mode = getenv('PHP_ENV');
if ($_dev_mode !== false && $dev_mode === 'DEV') {
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);
}

function register_menus() {
  // register_nav_menus(array(
  //   'primary' => __('Primary Menu', 'splus'),
  //   'footer' => __('Footer Menu', 'splus')
  // ));

  register_nav_menu('primary', __('Primary Menu'));
  register_nav_menu('footer', __('Footer Menu'));
}

//add_action('after_setup_theme', 'register_menus');

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

function theme_update($transient) {
  $env = getenv('PHP_ENV');
  if ($env !== false && $env == 'DEV') {
    return $transient;
  }

  $response = wp_remote_get('https://raw.githubusercontent.com/nmcardoso/splus-theme/zipball/version.txt');
  if (is_wp_error($response)) {
    return;
  }

  $curr_version = get_site_option('splus_theme_version', 'none');
  $remote_version = $response['body'];
  
  
  if ($curr_version !== $remote_version) {
    $fields = array();
    $fields['theme'] = 'splus-theme';
    $fields['new_version'] = $remote_version;
    $fields['url'] = "https://example.com";
    $fields['package'] = 'https://github.com/nmcardoso/splus-theme/blob/zipball/zipball.zip?raw=true';
    $fields['requires'] = '4.0';
    $fields['requires_php'] = '5.6';
    //$transient = get_site_transient('update_themes');
    $transient->response['splus-theme'] = $fields;
    //set_site_transient('update_themes', $transient);
  }
  
  return $transient;
}

add_filter('pre_set_site_transient_update_themes', 'theme_update');

function theme_version_setup() {
  $response = wp_remote_get('https://raw.githubusercontent.com/nmcardoso/splus-theme/zipball/version.txt');
  if (is_wp_error($response)) {
    return;
  }

  $curr_version = get_site_option('splus_theme_version', 'none');
  $remote_version = $response['body'];
  
  update_site_option('splus_theme_version', $remote_version);
}

add_action('upgrader_process_complete', 'theme_version_setup');

function theme_setup() {
  register_menus();
  //theme_version_setup();
}

add_action('after_setup_theme', 'theme_setup');

function redirect_subscribers() {
  if (current_user_can('subscriber')) {
    wp_redirect(home_url());
    exit;
  }
}

add_action('admin_init', 'redirect_subscribers');

function block_unauthorized_users($user, $username, $password) {
  if (is_wp_error($user)) {
    return $user;
  }

  $auth = get_user_meta($user->ID, 'splus_user_authorized', false);
  $user_roles = $user->roles;
  
  if ($auth !== 'true' && count($user_roles) === 1 && in_array('subscriber', $user_roles, true)) {
    return new WP_Error('user_unauthorized', 'User unauthorized. Wait for staff to approve your registration');
  } else {
    return $user;
  }
}

add_filter('authenticate', 'block_unauthorized_users', 99, 3);

function su_spoiler_handler($attrs, $content, $tag) {
  static $index = 1;

  $title = $attrs['title'];
  
  $html = '<div class="pb-2">';
  $html .= '<a class="" data-toggle="collapse" href="#coll' . $index . '">';
  $html .= $title;
  $html .= '</a>';
  $html .= '<div class="collapse" id="coll' . $index . '">';
  $html .= '<div class="card card-body">';
  $html .= do_shortcode($content);
  $html .= '</div>';
  $html .= '</div>';
  $html .= '</div>';

  $index++;

  return $html;
}

add_shortcode('su_spoiler', 'su_spoiler_handler');
