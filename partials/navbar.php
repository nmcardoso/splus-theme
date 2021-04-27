<nav id="navbar" class="navbar navbar-dark navbar-expand-lg navbar-toggleable-md">
  <a class="navbar-brand" href="/">
    <img src="<?php bloginfo('template_url'); ?>/img/splus-cropped@2x.png" height="34px" alt="splus logo">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php
    $menu_name = 'primary';
    $locations = get_nav_menu_locations();

    if (array_key_exists($menu_name, $locations)) {
      $menu_id = $locations[$menu_name];
      $items = wp_get_nav_menu_items($menu_id);

      if ($items) {
        $items = array_filter($items, function($i) {
          return (int)$i->menu_item_parent == 0;
        });
      } else {
        $items = [];
      }
    } else {
      $items = [];
    }
    ?>
    <ul class="navbar-nav ml-auto">
      <?php 
      foreach ($items as $item):
        $active = $item->object_id == get_the_ID() ? 'active' : '';
        $post_meta = get_post_meta($item->object_id);
      ?>
      <li class="nav-item">
        <a class="nav-link <?php echo $active; ?>" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
      </li>
      <?php
      endforeach;
      if (!is_user_logged_in()):
      ?>
      <li class="nav-item">
        <a class="nav-link login" href="/login">Login</a>
      </li>
      <?php else: ?>
      <li class="nav-item">
        <a class="nav-link login" href="/login?action=logout">Logout</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>