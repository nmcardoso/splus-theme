<?php

function get_icon($icon) {
  $path = __DIR__ . '/../img/';
  $icon_path = $path . $icon . '.svg';
  //echo $icon_path;

  if (file_exists($icon_path)) {
    $icon = file_get_contents($icon_path);
    echo $icon;
  }
}