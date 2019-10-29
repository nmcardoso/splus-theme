<?php 

get_header();
get_template_part('partials/navbar');

?>

<?php 

$p = get_post();
$post_meta = get_post_meta($p->ID);
$visibility = $post_meta['_meta_is_private'][0];

?>

<section class="page-hero">
  <div class="container">
    <h1><?php echo $p->post_title; ?></h1>
  </div>
</section>

<?php
get_template_part('partials/submenus');
?>

<main class="page-content">
  <section class="mt-5 pt-5">
    <div class="container">
      <?php if (!is_user_logged_in() &&  $visibility === 'private'): ?>
      <div class="jumbotron">
        <h1 class="display-4">Private Content</h1>
        <p class="lead">This content is reserved for authenticated users.</p>
        <hr class="my-4">
        <p><a href="/register">Register</a> a new account or <a href="/login">Login</a> to your account</p>
        <a class="btn base btn-lg mr-3" href="/register" role="button">Register</a>
        <a class="btn base btn-lg" href="/login" role="button">Login</a>
      </div>
      <div class="pb-5"></div>
      <?php else:
      echo $p->post_content;
      endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>