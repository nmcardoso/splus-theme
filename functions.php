<?php

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

