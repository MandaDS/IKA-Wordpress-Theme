<?php
/**
 * The Template for pages
 *
 */
get_header();
?>
<!-- Post -->
<article id="post-<?php the_ID(); ?>" class="post row-fluid">
<?php // start the loop  
while ( have_posts() ) : the_post(); ?>   
    <h1><?php the_title(); ?></h1>
    <div class="post-body col-md-12">
        
        <!-- featured image -->
        <?php if ( has_post_thumbnail() ) { ?>
        <div class="border">
            <a href="<?php the_permalink(); ?>" class="shadow">
            <?php the_post_thumbnail( 'large', array( 'class' => 'center','alt'   => trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ) )
        ) ); ?>
            </a>
        </div>
        <?php } ?>
        <!-- featured image -->
            
        <?php the_content(); ?>
    </div>
<?php endwhile; ?>
<?php // ends the loop ?>
</article>

<!-- Post -->
<?php if ('open' == $post->comment_status) : ?>
<?php comments_template(); ?> 
<?php endif; ?>
<?php get_footer(); ?>