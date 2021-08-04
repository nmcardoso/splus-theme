<?php
/**
 * Template Name: Blog Index
 * 
 * @package wordpress
 * @subpackage splus-theme
 */
add_filter('body_class', function() { return ['d-flex', 'flex-column']; });
get_header();
?>

<div style="flex: 1 0 auto;"> <!-- make footer sticky bottom -->

<?php get_template_part('partials/navbar'); ?>

<section class="page-hero">
  <div class="container">
    <h1><?php echo get_post()->post_title; ?></h1>
  </div>
</section>

<main class="page-content">
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-7">
        <h3 class="mt-0 mb-2">Press-Release</h3>
        <div class="pr-wrapper">
          <div id="carouselExampleCaptions" class="carousel slide" style="height: 400px;" data-ride="carousel">
            <?php
              $pr_cat = get_cat_ID("news");
              $pr_query = array(
                "numberposts" => 5,
                "category" => $pr_cat,
                "orderby" => "date",
                "order" => "DESC"
              );
              $pr_posts = get_posts($pr_query);
            ?>
            <ol class="carousel-indicators">
              <?php for ($i = 0; $i < count($pr_posts); $i++): ?>
              <li 
                data-target="#carouselExampleCaptions" 
                data-slide-to="<?php echo $i; ?>" 
                class="<?php echo ($i === 0) ? "active" : "" ?>">
              </li>
              <?php endfor; ?>
            </ol>
            <div class="carousel-inner" style="height: 400px;">
              <?php foreach ($pr_posts as $key => $post): setup_postdata($post); reset($pr_posts); ?>
              <div 
                class="carousel-item <?php echo (key($pr_posts) === $key) ? "active" : "" ?>" 
                style="height: 400px;">
                <?php if (has_post_thumbnail()): ?>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <img 
                      src="<?php echo get_the_post_thumbnail_url($post, "large"); ?>" 
                      height="100%"
                      width="100%"
                      class="d-block w-100" 
                      alt="<?php echo get_the_title(); ?>" />
                  </a>
                <?php else: ?>
                  <a href="<?php echo get_the_permalink(); ?>">
                    <img
                      src="<?php bloginfo('template_url'); ?>/img/stars-placeholder.jpg"
                      height="100%"
                      width="100%"
                      class="d-block w-100"
                      alt="<?php echo get_the_title(); ?>" />
                  </a>
                <?php endif; ?>
                <div class="carousel-caption d-none d-md-block">
                  <a href="<?php echo get_the_permalink(); ?>" class="caption-link">
                    <div class="carousel-text py-1 px-2 mb-3">
                      <h5 class="font-weight-bold text-truncate">
                        <?php the_title(); ?>
                      </h5>
                      <p class="description mb-0">
                        <?php echo substr(wp_strip_all_tags(get_the_content()), 0, 150); ?>
                      </p>
                    </div>
                  </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <a 
              class="carousel-control-prev" 
              href="#carouselExampleCaptions" 
              role="button" 
              data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a 
              class="carousel-control-next" 
              href="#carouselExampleCaptions" 
              role="button" 
              data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-5 mt-5 mt-lg-0">
        <h3 class="mt-0 mb-2">Announcements</h3>
        <div class="announcements-wrapper">
          <?php
          $announcements_cat = get_cat_ID("announcements");
          $announcements_query = array(
            "numberposts" => 25,
            "category" => $announcements_cat,
            "orderby" => "date",
            "order" => "DESC"
          );
          $announcements_posts = get_posts($announcements_query);
          
          foreach ($announcements_posts as $post): setup_postdata($post);
          ?>
          <div class="announcements card w-100 mb-2">
            <div class="card-body px-3 py-3">
              <h6 class="card-title mb-1" style="font-weight: bold;"><?php the_title(); ?></h6>
              <?php the_content(); ?>
              <small class="d-block text-right text-muted my-0 py-0"><?php echo get_the_date("M d, Y H:i"); ?></small>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</main>

</div> <!-- footer sticky -->

<?php get_template_part('partials/footer'); ?>

<?php get_footer(); ?>