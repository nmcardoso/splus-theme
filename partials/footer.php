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
          <li><a href="http://www.fapesp.br" target="_blank" data-toggle="tooltip" data-placement="top" title="FAPESP - Fundação de Amparo à Pesquisa do Estado de São Paulo"><img class="mr-3 mt-2" src="<?php bloginfo('template_url'); ?>/img/logo_fapesp.png" height="42px" alt="Fapesp"></a></li>
          <li><a href="https://on.br" target="_blank" data-toggle="tooltip" data-placement="top" title="ON - Observatório Nacional"><img class="mr-3 mt-2" src="<?php bloginfo('template_url'); ?>/img/logo_ON.png" height="42px" alt="ON"></a></li>
          <li><a href="http://www.inpe.br" target="_blank" data-toggle="tooltip" data-placement="top" title="INPE - Instituto Nacional de Pequisas Espaciais"><img class="mr-3 mt-2" src="<?php bloginfo('template_url'); ?>/img/logo_inpe.png" height="42px" alt="INPE"></a></li>
          <li><a href="https://www.cefca.es" target="_blank" data-toggle="tooltip" data-placement="top" title="CEFCA - Centro de Estudios de Física del Cosmos de Aragón"><img class="mr-3 mt-2" src="<?php bloginfo('template_url'); ?>/img/logo_cefca.png" height="42px" alt="CEFCA"></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid text-white text-center py-2" style="background-color: #2C3037;">
    <span class="small">&copy; Copyright 2019. All Rights Reserved.</span>
  </div>
</footer>