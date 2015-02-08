<?php
/**
 * The Template for single post
 *
 */
get_header(); 
?>
<!-- Post -->
<?php // start the loop  
while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" class="post full row">   
    <h1><?php the_title(); ?></h1> 
    <h2><span><?php the_excerpt(); ?></span></h2>

    <div class="post-body col-md-12">
        <!-- featured image -->
        <?php if ( has_post_thumbnail() ) { ?>
        <?php the_featured_image(); ?>
        <?php } ?>
        <!-- featured image -->

        <?php the_content(); ?>
        <?php get_portfolio_footer(); ?>
    </div>
</article>

<?php

get_related(); 

// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
}

endwhile; ?>
<!-- Post -->
<nav class="post-nav">
    <ul>
        <li class="previous">
            <?php next_posts_link( '<span class="glyphicon glyphicon-circle-arrow-left"></span> Older posts' ); ?>
        </li>
        <li class="next">
            <?php previous_posts_link( 'Newer posts <span class="glyphicon glyphicon-circle-arrow-right"></span>' ); ?>
        </li>
    </ul>
</nav>
<?php get_footer(); ?>