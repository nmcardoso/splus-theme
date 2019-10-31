<?php

function get_validate_email($email, $url) {
  $template = file_get_contents(__DIR__ . '/confirm_email.html');
  $template = str_replace('{{email}}', $email, $template);
  $template = str_replace('{{logo_url}}', get_template_directory_uri() . '/img/splus@2x.png', $template);
  $template = str_replace('{{confirm_url}}', $url, $template);

  return $template;
}

function get_auth_email($name, $email, $institution, $position, $url) {
  $template = file_get_contents(__DIR__ . '/auth_email.html');
  $template = str_replace('{{name}}', $name, $template);
  $template = str_replace('{{email}}', $email, $template);
  $template = str_replace('{{institution}}', $institution, $template);
  $template = str_replace('{{position}}', $position, $template);
  $template = str_replace('{{auth_url}}', $url, $template);
  $template = str_replace('{{logo_url}}', get_template_directory_uri() . '/img/splus@2x.png', $template);

  return $template;
}

function get_authorized_email($email) {
  $template = file_get_contents(__DIR__ . '/authorized_email.html');
  $template = str_replace('{{email}}', $email, $template);
  $template = str_replace('{{login_url}}', get_site_url() . '/login', $template);

  return $template;
}
