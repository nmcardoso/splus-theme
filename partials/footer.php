<footer class="mt-5" style="flex-shrink: 0;">
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
        <ul class="quick-links">
          <?php foreach($items as $item): ?>
          <li><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-5">
        <h4>SUPPORTERS</h4>
        <ul class="logos text-center mb-0">
          <li><a href="http://www.fapesp.br" target="_blank" data-toggle="tooltip" data-placement="top" title="FAPESP - Fundação de Amparo à Pesquisa do Estado de São Paulo"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_fapesp.png" height="44px" alt="FAPESP"></a></li>
          <li><a href="http://www.cnpq.br" target="_blank" data-toggle="tooltip" data-placement="top" title="CNPq - Conselho Nacional de Desenvolvimento Científico e Tecnológico"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_cnpq.png" height="44px" alt="CNPq"></a></li>
          <li><a href="https://www.capes.gov.br" target="_blank" data-toggle="tooltip" data-placement="top" title="CAPES - Coordenação de Aperfeiçoamento de Pessoal de Nível Superior"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_capes.png" height="44px" alt="CAPES"></a></li>
          <li><a href="http://www.faperj.br" target="_blank" data-toggle="tooltip" data-placement="top" title="FAPERJ - Fundação Carlos Chagas Filho de Amparo à Pesquisa do Estado do Rio de Janeiro"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_faperj.png" height="44px" alt="FAPERJ"></a></li>
          <li><a href="http://www.finep.gov.br" target="_blank" data-toggle="tooltip" data-placement="top" title="FINEP - Financiadora de Estudos e Projetos"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_finep.png" height="44px" alt="FINEP"></a></li>
          <li><a href="https://www.cefca.es" target="_blank" data-toggle="tooltip" data-placement="top" title="CEFCA - Centro de Estudios de Física del Cosmos de Aragón"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_cefca.png" height="44px" alt="CEFCA"></a></li>
          <li><a href="http://www.inpe.br" target="_blank" data-toggle="tooltip" data-placement="top" title="INPE - Instituto Nacional de Pesquisas Espaciais"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_inpe.png" height="44px" alt="INPE"></a></li>
        </ul>

        <h4>FOUNDERS</h4>
        <ul class="logos text-center mb-0">
          <li><a href="http://usp.br" target="_blank" data-toggle="tooltip" data-placement="top" title="USP - Universidade de São Paulo"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_usp2.png" height="44px" alt="USP"></a></li>
          <li><a href="https://on.br" target="_blank" data-toggle="tooltip" data-placement="top" title="ON - Observatório Nacional"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_ON.png" height="44px" alt="ON"></a></li>
          <li><a href="http://www.ufs.br" target="_blank" data-toggle="tooltip" data-placement="top" title="UFS - Universidade Federal de Sergipe"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_ufs.png" height="44px" alt="UFS"></a></li>
          <li><a href="https://ufsc.br" target="_blank" data-toggle="tooltip" data-placement="top" title="UFSC - Universidade Federal de Santa Catarina"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_ufsc2.png" height="44px" alt="UFSC"></a></li>
          <li><a href="http://www.userena.cl" target="_blank" data-toggle="tooltip" data-placement="top" title="ULS - Universidad de La Serena"><img class="mr-3 mb-4 mb-lg-3" src="<?php bloginfo('template_url'); ?>/img/logo_univ_la_serena2.png" height="44px" alt="ULS"></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid text-white text-center py-2" style="background-color: #2C3037;">
    <span class="small">&copy; Copyright 2019. All Rights Reserved.</span>
  </div>
</footer>