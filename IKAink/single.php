<?php
/**
 * The Template for single post
 *
 */
get_header(); ?>
<!-- Post -->
<?php // start the loop  
while ( have_posts() ) : the_post();

get_template_part( 'content-full' ); ?>
<nav class="post-nav">
    <ul>
        <li class="previous">
            <?php previous_post_link('%link', '<span class="glyphicon glyphicon-circle-arrow-left"></span> Previous', TRUE); ?>
        </li>
        <li class="next">
            <?php next_post_link('%link', 'Next <span class="glyphicon glyphicon-circle-arrow-right"></span>', TRUE); ?>
        </li>
    </ul>
</nav>

<?php
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
} endwhile; ?>
<!-- Post -->
<?php get_footer(); ?>