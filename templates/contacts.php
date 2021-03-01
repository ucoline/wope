<?php

/**
 * Template Name: Contacts
 * @package WordPress
 * @since Wope theme 1.0.0
 */

get_header(); ?>

<!-- Section -->
<section class="page-content white-page pt-70">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="post-content">
                <div class="post-content-in">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="main_heading text_align_left">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- /end Section -->

<?php get_footer(); ?>

</body>

</html>
