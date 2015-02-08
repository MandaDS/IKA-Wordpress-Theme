<?php
function get_details()  { ?>
<div class="detail">
    <!-- date -->
    <span><span class="glyphicon glyphicon-calendar"></span> <?php the_date(); ?></span> 
    <!-- date -->
    <!-- comments -->
    <span><span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
    <!-- comments -->
    <!-- category -->
    <?php if ( count( get_the_category() ) ) : ?>
    <span><span class="glyphicon glyphicon-folder-close"></span> <?php echo get_the_category_list( ', ' ); ?></span>
    <?php endif; ?>
    <!-- category -->
    <!-- tags -->
    <?php if ( has_tag() ) { ?>
    <br><span><span class="glyphicon glyphicon-tags"></span> <?php the_tags(); ?></span>
    <?php } ?>
    <!-- tags -->
    <!-- edit -->
    <?php edit_post_link('<span><span class="glyphicon glyphicon glyphicon-pencil"></span>Edit</span>',''); ?>
    <!-- edit -->
</div>
<?php } ?>