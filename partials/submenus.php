<?php

function get_all_items() {
  $menu_name = 'primary';
  $locations = get_nav_menu_locations();
  $menu_id = $locations[$menu_name];
  $all_items = wp_get_nav_menu_items($menu_id);

  return $all_items;
}

function get_submenu_items($id, $all_items) {
  // object_id to db_id
  // $page_object_id = $id;
  // $page_id = null;
  // foreach ($all_items as $i) {
  //   if ($i->object_id == $page_object_id) {
  //     $page_id = $i->ID;
  //     break;
  //   }
  // }

  // find all children pages
  $items = array();
  foreach ($all_items as $i) {
    if ($i->menu_item_parent == $id) {
      $items[] = $i;
    }
  }

  return $items;
}

$all_items = get_all_items();
$page_object_id = get_the_ID();
$parent_id = null;

foreach ($all_items as $i) {
  if ($i->object_id == $page_object_id) {
    if ((int)$i->menu_item_parent == 0) {
      $parent_id = $i->ID;
      break;
    } else {
      $parent_id = $i->menu_item_parent;
      break;
    }
  }
}

$items = get_submenu_items($parent_id, $all_items);

// remove private pages from submenus listing for unauthenticated users
if (!is_user_logged_in()) {
  $items = array_reduce($items, function($carry, $item) {
    $post_meta = get_post_meta($item->object_id);
    if (isset($post_meta['_meta_is_private']) && 
        $post_meta['_meta_is_private'][0] == 'private') {
          return $carry;
    } else {
      array_push($carry, $item);
      return $carry;
    }
  }, array());
}

?>

<?php if (!empty($items)): ?>
<div class="container-fluid">
  <div id="submenu">
    <ul class="items d-sm-flex d-block pl-0 pr-md-3">
      <?php foreach($items as $i): ?>
      <li class="item ml-sm-4 my-2 text-right">
        <a href="<?php echo $i->url; ?>" class="item-link"><?php echo $i->title; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endif; ?>
