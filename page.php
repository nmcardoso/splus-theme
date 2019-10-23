<?php 

get_header();
get_template_part('partials/navbar');

?>

<?php $p = get_post(); ?>

<section class="page-hero">
  <div class="container">
    <h1><?php echo $p->post_title; ?></h1>
  </div>
</section>

<main class="page-content">
  <section class="mt-5 pt-5">
    <div class="container">
      <?php echo $p->post_content; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>