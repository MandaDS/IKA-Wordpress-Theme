 <?php
 function get_portfolio_footer() { ?>
 <div class="portfolio-footer">
    <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>
    <div class="details">
        <p><?php the_title(); ?> by <?php the_author(); ?> <span class="copy"> 
        <?php 
        // If copyright display
        $year = get_post_meta(get_the_ID(), 'ikaink_portfolio_select', true);
            if (! $year) { echo ''; }
            if ($year == date('Y')) { echo '&copy;'. $year; }
            if ($year < date('Y')) { echo '&copy;'. $year . ' - ' . date('Y'); }
            if ($year > date('Y')) { echo '&copy;'. $year; }
        ?>
        </span></p>
        <p class="copy">Posted on <?php the_date(); ?></p>
        <?php 
        // If deviantART link
        $da_link = get_post_meta(get_the_ID(), 'ikaink_portfolio_textfield', true);
            if($da_link != '') { ?>
        <p class="copy">
        deviantART: <a href="<?php echo $da_link; ?>" target="_blank" ><?php echo $da_link; ?></a>
        </p>
        <?php } ?>
        
        <p><span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
    </div>
</div>
<?php }?>