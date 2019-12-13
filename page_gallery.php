<?php 
/**
 * Template Name: Gallery Page
 */

add_filter('body_class', function() { return ['d-flex', 'flex-column']; });
get_header();
?>

<div style="flex: 1 0 auto;"> <!-- make footer sticky bottom -->

<?php
get_template_part('partials/navbar');

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
  <section class="mt-5">
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
      $content = $p->post_content;

      function get_bulk_data($arr) {
        // https://wordpress.stackexchange.com/questions/125554/get-image-description
        return array_map(function($id) {
          $attachment = get_post($id);

          return array(
            'src' => wp_get_attachment_image_src($id, 'medium')[0],
            'caption' => $attachment->post_excerpt | '',
            'href' => get_permalink($id),
            'title' => $attachment->post_title,
            'id' => $id
          );
        }, $arr);
      }

      $data = [];
      // Find wp:image blocks
      if (preg_match_all('/wp:image {.*"id":(\d+).*}/m', $content, $match)) {
        $ids = array_map(function ($e) {
          return $e;
        }, $match[1]);
        $data = get_bulk_data($ids);
      }
      
      // Find wp:gallery blocks
      if (preg_match_all('/wp:gallery {.*"ids":\[([\d+,?]+)\].*}/m', $content, $match2)) {
        $ids = array_reduce($match2[1], function ($carry, $e) {
          return array_merge($carry, explode(',', $e));
        }, []);
        $data = array_merge($data, get_bulk_data($ids));
      }
      ?>

      <div id="gallery"></div>

      <script src="<?php bloginfo('template_url'); ?>/mosaic.js"></script>
      <script>
        const g = document.getElementById('gallery')
        const data = JSON.parse('<?php echo json_encode($data); ?>')
        const M = new Mosaic(data, g)
        M.imagesPerRow({
          small: 2,
          medium: 2,
          large: 3,
          xlarge: 3,
          default: 3
        })
        M.setMargin({
          small: 4,
          medium: 5,
          large: 8,
          xlarge: 14,
          default: 8
        })
        M.render()
      </script>

      <?php endif; ?>

    </div>
  </section>
</main>

</div> <!-- footer sticky -->

<?php 
get_template_part('partials/footer');
get_footer(); 
?>