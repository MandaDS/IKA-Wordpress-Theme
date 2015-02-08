<?php get_header(); ?>

<!-- Display Main Page Widgets -->
<?php dynamic_sidebar( 'main' ); ?>
<!-- Display Main Page Widgets -->

<!-- Index list of Posts -->
<?php  
//query_posts('showposts=2'); if (have_posts()) : while (have_posts()) : the_post(); 

//get_template_part( 'content' );

//endwhile;
//else : ?>
<?php //endif; wp_reset_query(); ?>
<!-- Index List of Posts -->

<?php get_footer(); ?>