<footer class="mt-5">
    <div class="container py-4">
      <div class="row">
        <div class="col-sm-8 col-lg-4">
          <div style="max-width: 170px;">
            <img class="ml-auto" src="<?php bloginfo('template_url'); ?>/img/splus@2x.png" width="100%" alt="splus logo">
          </div>
          <p class="pt-2">S-PLUS is an international collaboration founded by Universidade de Sao Paulo, Observatório Nacional, Universidade Federal de Sergipe, Universidad de La Serena and Universidade Federal de Santa Catarina.</p>
        </div>
        <div class="col-sm-4 col-lg-3">
          <h4>QUICK LINKS</h4>
          <?php
          $menu_name = 'footer';
          $locations = get_nav_menu_locations();
          $menu_id = $locations[$menu_name];
          $items = wp_get_nav_menu_items($menu_id);
          $items = array_filter($items, function($i) {
            return (int)$i->menu_item_parent == 0;
          });
          ?>
          <ul class="quick-links">
            <?php foreach($items as $item): ?>
            <li><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="col-lg-5">
          <h4>ACKNOWLEDGMENTS</h4>
          <ul class="logos text-center">
            <li><a href="#"><img class="mr-2 mt-2" src="<?php bloginfo('template_url'); ?>/img/fapesp@2x.png" height="60px" alt=""></a></li>
            <li><a href="#"><img class="mr-2 mt-2" src="<?php bloginfo('template_url'); ?>/img/on@2x.png" height="60px" alt=""></a></li>
            <li><a href="#"><img class="mr-2 mt-2" src="<?php bloginfo('template_url'); ?>/img/inpe@2x.png" height="60px" alt=""></a></li>
            <li><a href="#"><img class="mr-2 mt-2" src="<?php bloginfo('template_url'); ?>/img/logo@2x.png" height="60px" alt=""></a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid text-white text-center py-2" style="background-color: #2C3037;">
      <span class="small">&copy; Copyright 2019. All Rights Reserved.</span>
    </div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="<?php bloginfo('template_url'); ?>/script.js"></script>
</body>

</html>