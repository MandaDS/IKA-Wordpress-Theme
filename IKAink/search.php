<?php
/**
 * The Template for single post
 *
 */

get_header(); ?>
<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
    $query_split = explode("=", $string);
    $search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);

global $wp_query;
$total_results = $wp_query->found_posts;

if ( have_posts() ) : ?>

<h1>
    <?php printf( __( 'Search Results for: %s', 'ikaink' ), '<span>' . get_search_query() . '</span>' ); ?>
</h1>

<!-- Post -->
<?php // start the loop  
while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" class="post row-fluid">   
    
    <div class="post-body col-md-12">
        <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'compass' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
            
        <?php the_excerpt(); ?>
        
    </div>
</article>
<?php endwhile; ?>
<!-- Post -->

<?php else : ?>
<div class="no-results">   
    <h1>
        No Results for <?php printf( __( '%s', 'shape' ), '<span>"' . get_search_query() . '"</span>' ); ?>
    </h1>
    <p class="no-results light-box">
        <img src="<?php echo get_template_directory_uri() . '/no-results.png'; ?>">
    </p>
</div>
<?php endif; ?>

<?php get_footer(); ?>