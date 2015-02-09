                <!-- Page Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container -->

    <footer>
        <?php if(get_theme_mod('footer_select') && get_theme_mod('footer_select') == 'yes') { ?><div class="jelly"><img src="<?php if (get_theme_mod( 'footer_image' )) : echo get_theme_mod( 'footer_image'); else: echo get_template_directory_uri() . '/images/jellyfish.png'; endif; ?>"></div><?php } ?>
        <div class="<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-left') { ?>container-left<?php } ?>
    <?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-right') { ?>container-right<?php } ?> 
    <?php if(get_theme_mod('width_select') && get_theme_mod('width_select') == 'fluid') { ?>container-fluid<?php } else { ?>container<?php } ?>">
            <div class="widgets">

                <?php if ( is_active_sidebar( 'footer_left' ) && is_active_sidebar( 'footer_middle' ) && is_active_sidebar( 'footer_right' )): ?>
                <div class="footer-widgets row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_left' ); ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_middle' ); ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_right' ); ?>
                    </div>
                </div>
                <?php  elseif (  is_active_sidebar( 'footer_left' ) && is_active_sidebar( 'footer_middle' )): ?>
                <div class="footer-widgets row">
                    <div class="col-md-8 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_left' ); ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_middle' ); ?>
                    </div>
                </div>
                <?php elseif  ( is_active_sidebar( 'footer_middle' ) && is_active_sidebar( 'footer_right' )): ?>
                <div class="footer-widgets row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_middle' ); ?>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_right' ); ?>
                    </div>
                </div>
                <?php elseif  ( is_active_sidebar( 'footer_left' ) && is_active_sidebar( 'footer_right' )): ?>
                <div class="footer-widgets row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_left' ); ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php dynamic_sidebar( 'footer_right' ); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bottom-widget">
            <?php dynamic_sidebar( 'footer_bottom' ); ?>
            <div class="copy-right">IKA theme created by <a href="http://ika.ink" target="_blank">MandaDS</a>. Proudly powered by Wordpress.</div>
        </div>
    </footer>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
    <script type="text/javascript">
        $('.carousel').carousel({
          <?php if(get_theme_mod('animation_loop') == 'true') { ?>
          interval: <?php echo get_theme_mod('slide_speed'); ?>
          <?php } else { ?>
          interval: false
          <?php } ?>
        })
    </script>
    <?php wp_footer(); ?>
</body>
</html>