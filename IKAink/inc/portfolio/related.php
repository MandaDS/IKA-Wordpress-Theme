<?php
function get_related()  {
// Get related posts for portfolio entries
// Get the custom post type's taxonomy terms
$custom_taxterms = wp_get_object_terms( $post->ID, 'post_tag', array('fields' => 'ids') );

$args = array(
'post_type' => 'portfolio',
'post_status' => 'publish',
'posts_per_page' => 4,
'orderby' => 'rand', //random
'tax_query' => array(
    array(
        'taxonomy' => 'post_tag',
        'field' => 'id',
        'terms' => $custom_taxterms
    )
),
'post__not_in' => array ($post->ID),
);
$related_items = new WP_Query( $args );

if ($related_items->have_posts()) : ?>

<div class="related-portfolio row">
<h3>Related:</h3>

<?php else: endif;

// loop over query
if ($related_items->have_posts()) :
while ( $related_items->have_posts() ) : $related_items->the_post();
?>
    <?php if(get_theme_mod('nav_select') == 'top') { ?>
    <div class="col-md-3 col-sm-6">
    <?php } else { ?>
    <div class="col-md-3">
    <?php } ?>
        <div class="related-body">

            <!-- featured image -->
            <?php if ( has_post_thumbnail() ) { ?>
            <div class="main-image">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?> posted on <?php the_date(); ?>">
                <?php the_post_thumbnail( 'related-thumb', array( 'class' => 'aligncenter','alt' => trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ))
                 )); ?>
                </a>
            </div>
            <?php } ?>
            <!-- featured image -->

        </div>
    </div>
<?php
endwhile;
endif;
wp_reset_postdata();
if ($related_items->have_posts()) : ?>
</div>
<?php else: endif; } ?>