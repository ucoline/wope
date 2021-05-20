<?php get_header(); ?>

<?php
$query = Theme::WP_Query(array(
    'post_type' => 'post',
));

// The Loop
while ( $query->have_posts() ) {
    $query->the_post();
    echo '<li>' . get_the_title() . '</li>';
}?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        the_content();
    }
} ?>

<?php get_footer(); ?>

</body>

</html>