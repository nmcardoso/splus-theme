<nav id="navbar" class="navbar navbar-dark navbar-expand-lg navbar-toggleable-md">
  <a class="navbar-brand" href="/">
    <img src="<?php bloginfo('template_url'); ?>/img/splus.png" height="32px" alt="" class="mb-2">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php
    $menu_name = 'primary';
    $locations = get_nav_menu_locations();
    $menu_id = $locations[$menu_name];
    $items = wp_get_nav_menu_items($menu_id);
    ?>
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
  </div>
</nav>