<?php
/**
 * Social Media
 *
 */
?>
<ul>
    <?php
        if(get_theme_mod('facebook') && get_theme_mod('facebook') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('facebook'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/facebook.png" alt="Visit my Facebook" title="Visit my Facebook"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('twitter') && get_theme_mod('twitter') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('twitter'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/twitter.png" alt="View Twitter" title="View Twitter"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('googleplus') && get_theme_mod('googleplus') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('googleplus'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/googleplus.png" alt="View Google+" title="View Google+"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('linkedin') && get_theme_mod('linkedin') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('linkedin'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/linkedin.png" alt="Visit Linkedin" title="Visit Linkedin"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('instagram') && get_theme_mod('instagram') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('instagram'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/instagram.png" alt="View Instagram" title="View Instagram"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('lastfm') && get_theme_mod('lastfm') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('lastfm'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/lastfm.png" alt="Visit last.fm" title="Visit last.fm"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('tumblr') && get_theme_mod('tumblr') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('tumblr'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/tumblr.png" alt="View tumblr" title="View tumblr"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('deviantart') && get_theme_mod('deviantart') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('deviantart'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/deviantart.png" alt="Visit my deviantART page" title="Visit my deviantART page"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('flickr') && get_theme_mod('flickr') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('flickr'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/flickr.png" alt="View flickr" title="View flickr"></a>
    </li>
    <?php 
        }
        if(get_theme_mod('youtube') && get_theme_mod('youtube') != '') {
    ?>
    <li>
        <a href="<?php echo get_theme_mod('youtube'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/icons/youtube.png" alt="Watch Youtube" title="Watch Youtube"></a>
    </li>
    <?php 
        }
    ?>     
</ul>