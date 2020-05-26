<?php get_header(); ?>

<!-- Section -->
<section class="page-content white-page pt-30 pb-20">
  <div class="container">
    <div class="row">
      <?php if (have_posts()): ?>
      <div class="post-content">
        <div class="post-content-in">
          <?php while (have_posts()) : the_post(); ?>
            <div class="col-12">
              <h2 class="mt-20"><?php the_title(); ?></h2>
              <?php the_content(); ?>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- /end Section -->

<?php get_footer(); ?>

</body>
</html>
