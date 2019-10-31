<?php 

get_header(); 
get_template_part('partials/navbar');

?>

<section class="hero">
    <div class="hero-inner">
      <h1><?php echo bloginfo('title'); ?></h1>
      <h2><?php echo bloginfo('description'); ?></h2>
    </div>
    <a href="#home" data-smooth-scroll class="btn">EXPLORE</a>
  </section>

  <main id="home">

  <?php
  
  $p = get_post();
  echo $p->post_content;

  ?>

  <?php /*
    <section class="home-gallery mt-5 pt-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <h1>WE ARE MAPPING THE SOUTHERN SKY…</h1>
            <p class="pt-2">
              Lorem ipsum dolor sit amet, mel deserunt inciderint cu,
              iudicabit efficiendi an vis, sed id inani abhorreant deterruisset.
              Ea etiam verterem reprimique vix, sit ceteros intellegebat ne,
              te vis minim verterem reprehendunt.
            </p>
            <a href="#" class="btn base float-right">More Details</a>
          </div>
          <div class="col-lg-4">

          </div>
        </div>
      </div>
    </section>

    <section class="mt-5 pt-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h1>…THAT WILL BENEFIT MANY ASTRONOMY FIELDS…</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="mt-5">
      <div class="container-fluid py-5" style="background-color: #9A3838;">
        <h2 class="text-center py-5 text-white">Vamos preencher isso de alguma forma</h2>
      </div>
    </section>

    <section class="multicol-inverted mt-5 pt-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <img src="<?php bloginfo('template_url'); ?>/img/photo1.png" width="100%" alt="">
          </div>
          <div class="col-lg-8">
            <h1>…WITH A 86-CM TELESCOPE LOCATED IN CTIO.</h1>
            <p class="pt-2">
              Lorem ipsum dolor sit amet, mel deserunt inciderint cu,
              iudicabit efficiendi an vis, sed id inani abhorreant deterruisset.
              Ea etiam verterem reprimique vix, sit ceteros intellegebat ne,
              te vis minim verterem reprehendunt.
            </p>
            <a class="btn base float-right" href="#">More Details</a>
          </div>
        </div>
      </div>
    </section>

    */?>
  </main>

<?php get_template_part('partials/footer.php'); ?>

<?php get_footer(); ?>