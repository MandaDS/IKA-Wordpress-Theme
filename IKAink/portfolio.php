<?php
/**
 * The Template for portfolio posts
 *
 */
?>
<?php if(get_theme_mod('nav_select') == 'top') { ?>
<div class="col-md-4">
<?php } else { ?>
<div class="col-md-6">
<?php } ?>
    <div class="post-body">
        
        <!-- featured image -->
        <?php if ( has_post_thumbnail() ) { ?>
        <div class="image-container">
            <div class="image-column">
                <?php the_featured_image( 'portfolio-thumb' ); ?>
                <div class="image-inside">
                    <div class="image-inside-center">
                        <h1 class="image-header">
                            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'compass' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h1>
                        <div class="separator"></div>
                        <div class="image-text"><a href="<?php the_permalink(); ?>"><?php echo excerpt(15); ?></a></div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
        <!-- featured image -->

    </div>
</div>