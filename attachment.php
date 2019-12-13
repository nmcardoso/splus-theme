<?php 
add_filter('body_class', function() { return ['d-flex', 'flex-column']; });
get_header();
?>

<div style="flex: 1 0 auto;"> <!-- make footer sticky bottom -->

<?php
get_template_part('partials/navbar');

$attachment = get_post();
?>

<section class="page-hero">
  <div class="container">
    <h1><?php echo $attachment->post_title; ?></h1>
  </div>
</section>

<?php
get_template_part('partials/submenus');
?>

<main class="page-content">
  <section class="my-5 pt-5">
    <div class="container">
      <div class="d-flex justify-content-center">
        <img src="<?php echo wp_get_attachment_image_src($attachment->ID, 'full')[0]; ?>" class="mw-100" />
      </div>
      <?php
      $caption = $attachment->post_content | $attachment->post_excerpt;
      if ($caption):
      ?>
      <div class="w-100 p-3 p-lg-4 mt-4" style="background-color: #d2d2d2; border-radius: 4px;">
        <p class="mb-0" style="font-size: 1.1rem;"><b>Description:</b> <?php echo $caption; ?></p>
      </div>
      <?php endif; ?>
    </div>
  </section>
</main>

</div> <!-- footer sticky -->

<?php get_template_part('partials/footer'); ?>

<?php get_footer(); ?>