<?php 
/**
 * Index page
 *
 */
get_header();

if ($post->post_type == "portfolio"): 
?>

<!-- Post -->
 <h1> Portfolio </h1>  
<article class="portfolio post row">  
    <?php // start the loop  
    while ( have_posts() ) : the_post();

    get_template_part( 'portfolio' ); ?>

    <?php endwhile; ?>
</article>
<!-- Post -->

<?php else: ?>

<!-- Post -->
<?php // start the loop  
while ( have_posts() ) : the_post();

get_template_part( 'content' ); 

// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
}

endwhile; ?>
<!-- Post -->

<?php endif; ?>

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