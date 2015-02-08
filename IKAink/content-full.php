<?php
/**
 * The Template for posts
 *
 */
?>
<article id="post-<?php the_ID(); ?>" class="post post-clear row-fluid">

    <h1>
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'compass' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
        <?php get_dashicons(); ?>
        <?php the_title(); ?>
        </a>
    </h1>
    <?php get_details();
    if ( empty( $post->post_excerpt ) ) { 
    } else { ?>
        <h2><span><?php the_excerpt(); ?></span></h2>
    <?php } ?>
    <div class="post-body col-md-12">

    <!-- featured image -->
        <?php if ( has_post_thumbnail() ) { ?>
        <a href="<?php the_permalink(); ?>">
        <?php the_featured_image(); ?>
        </a>
        <?php } ?>
    <!-- featured image --> 

        <?php the_content(); ?>
    </div>
</article>