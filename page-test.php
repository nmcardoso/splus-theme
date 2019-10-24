<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
$fields = array();
$fields['theme'] = 'splus-theme';
$fields['new_version'] = 'version';
$fields['url'] = "https://bogas.com";
$fields['package'] = 'https://github.com/nmcardoso/splus-theme/blob/zipball/zipball.zip?raw=true';
$fields['requires'] = '4.0';
$fields['requires_php'] = '5.6';
$transient = get_site_transient('update_themes');
var_dump($transient);
echo '<br><br>';
$transient->response['splus-theme'] = $fields;
set_site_transient('update_themes', $transient);
var_dump($transient);
*/



$t = wp_get_theme();
var_dump($t->get('Version'));

