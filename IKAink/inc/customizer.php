<?php
/**
 * IKA.ink Theme Customizer support
 *
 * Implement Theme Customizer additions and adjustments.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
  
function get_categories_select() {
 $teh_cats = get_categories();
    $results;
    $count = count($teh_cats);
    for ($i=0; $i < $count; $i++) {
      if (isset($teh_cats[$i]))
        $results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
      else
        $count++;
    }
  return $results;
}

function get_portfolio_select() {
 $teh_cats = get_categories("taxonomy=categories");
    $results;
    $count = count($teh_cats);
    for ($i=0; $i < $count; $i++) {
      if (isset($teh_cats[$i]))
        $results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
      else
        $count++;
    }
  return $results;
}

// Thanks to "Pluto" for this! See full post for opacity color pallet here:
// http://pluto.kiwi.nz/2014/07/how-to-add-a-color-control-with-alphaopacity-to-the-wordpress-theme-customizer/
 
function ikaink_add_customizer_custom_controls( $wp_customize ) {
 
    class Ikaink_Customize_Alpha_Color_Control extends WP_Customize_Control {
    
        public $type = 'alphacolor';
        //public $palette = '#3FADD7,#555555,#666666, #F5f5f5,#333333,#404040,#2B4267';
        public $palette = true;
        //public $default = '#3FADD7';
    
        protected function render() {
            $id = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
            $class = 'customize-control customize-control-' . $this->type; ?>
            <li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
                <?php $this->render_content(); ?>
            </li>
        <?php }
    
        public function render_content() { ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <input type="text" data-palette="<?php echo $this->palette; ?>" data-default-color="<?php echo $this->default; ?>" value="<?php echo intval( $this->value() ); ?>" class="pluto-color-control" <?php $this->link(); ?>  />
            </label>
        <?php }
    }
 
}
add_action( 'customize_register', 'ikaink_add_customizer_custom_controls' );

// Alpha Opacity
function ikaink_enqueue_customizer_admin_scripts() {
 
  wp_register_script( 'customizer-admin-js', get_template_directory_uri() . '/js/admin/customizer-admin.js', array( 'jquery' ), NULL, true );
  wp_enqueue_script( 'customizer-admin-js' );
 
  }
add_action( 'admin_enqueue_scripts', 'ikaink_enqueue_customizer_admin_scripts' );

// Add Customizer Style Sheet
function ikaink_enqueue_customizer_controls_styles() {
 
  wp_register_style( 'customizer-controls', get_template_directory_uri() . '/css/admin/customizer-controls.css', NULL, NULL, 'all' );
  wp_enqueue_style( 'customizer-controls' );
 
  }
add_action( 'customize_controls_print_styles', 'ikaink_enqueue_customizer_controls_styles' );

// Add Customizer Link
function register_my_custom_menu_page(){
    add_menu_page( 'customize', 'Customize', 'manage_options', 'customize.php', '', 'dashicons-welcome-widgets-menus', 8 );
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );

 //Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
function mytheme_customize_preview_js() {
    wp_enqueue_script( 'ikaink-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'jquery','customize-preview' ), '20120187', true );
}

function ikaink_customize_register( $wp_customize ) {

// Genertal Options Panel
  $wp_customize->add_panel( 'general_options_panel', array(
    'priority'    => 10,
    'capability'  => 'edit_theme_options',
    'title'       => 'General Options',
    'description' => 'Choose display options and additional functionality.',
  ));

  // Page Display Section
  $wp_customize->add_section('ikaink_display_options', array(
    'title'       => __('Page display', 'ikaink'),
    'description' => 'Choose how the page should display.',
    'priority'    => 10,
    'panel'       => 'general_options_panel',
  ));

  // Page Display Section: Navigation Settings
  $wp_customize->add_setting('nav_select', array(
    'default'     => 'top',
    'capability'  => 'edit_theme_options',
  ));
  $wp_customize->add_control( 'nav_select', array(
    'settings'    => 'nav_select',
    'label'       => 'Navigation Style',
    'description' => 'Choose where and how the navigation displays. Note that responsive navigation will default to drop down sidebar in tablet mode.',
    'section'     => 'ikaink_display_options',
    'priority'    => 10,
    'type'        => 'select',
    'choices'     => array(
            'top' => 'Hover over top',
            'side-hover' => 'Hover over sidebar',
            'side-drop'  => 'Drop down sidebar',
  )));

  $wp_customize->add_setting('position_select', array(
    'default'     => 'center',
    'capability'  => 'edit_theme_options',
  ));
  $wp_customize->add_control( 'position_select', array(
    'settings'    => 'position_select',
    'label'       => 'Position',
    'description' => 'Choose the main display position of the page',
    'section'     => 'ikaink_display_options',
    'priority'    => 20,
    'type'        => 'select',
    'choices'     => array(
            'container-left'  => 'Left',
            'center'          => 'Center',
            'container-right' => 'Right',
  )));

  $wp_customize->add_setting('width_select', array(
    'default'     => 'fixed',
    'capability'  => 'edit_theme_options',
  ));
  $wp_customize->add_control( 'width_select', array(
    'settings'    => 'width_select',
    'label'       => 'Page Width',
    'description' => 'Choose to display the page at fixed width or full width.',
    'section'     => 'ikaink_display_options',
    'priority'    => 30,
    'type'        => 'select',
    'choices'     => array(
            'fixed'   => 'Fixed',
            'fluid'   => 'Full Width',
  )));

  // Theme Options Panel
  $wp_customize->add_panel( 'theme_colors_panel', array(
    'priority'    => 15,
    'capability'  => 'edit_theme_options',
    'title'       => 'Theme Options',
    'description' => 'Change the themes main color scheme!',
  ));

    // Slider Options Section
  $wp_customize->add_section('ikaink_slider', array(
    'title'       => __('Slider Options', 'ikaink'),
    'description' => 'Use the options below to customize the slider. Make sure to place the IKAink Slider widget in the main page area before customizing!',
    'panel'       => 'theme_colors_panel',
    'priority'    => 10,
  ));
   
  // Slider Options Section: Slider Settings 
  $wp_customize->add_setting('arrows', array(
    'default'     => 'default',
  ));
  $wp_customize->add_control( 'arrows', array(
    'settings'    => 'arrows',
    'label'       => 'Navigation Arrows',
    'section'     => 'ikaink_slider',
    'type'        => 'select',
    'priority'    => 30,
    'choices'     => array(
            'default' => 'Default',
            'minimal' => 'Minimal',
            'circle'  => 'Circle',
            'bold'    => 'Bold',
            'arrow'   => 'Arrow'
  )));

  $wp_customize->add_setting('animation', array(
    'default'     => 'standard',
  ));
  $wp_customize->add_control( 'animation', array(
    'settings'    => 'animation',
    'label'       => 'Animation',
    'section'     => 'ikaink_slider',
    'type'        => 'select',
    'priority'    => 40,
    'choices'     => array(
            'carousel-fade'=> 'Fade',
            'standard'     => 'Slide',
  )));

  $wp_customize->add_setting('animation_loop', array(
    'default'     => 'true',
  ));
  $wp_customize->add_control( 'animation_loop', array(
    'settings'    => 'animation_loop',
    'label'       => 'Auto Scroll',
    'section'     => 'ikaink_slider',
    'type'        => 'select',
    'priority'    => 50,
    'choices'     => array(
            'true'      => 'On',
            'false'     => 'Off',
  )));
    
  $wp_customize->add_setting('slide_speed', array(
    'default'        => '4000',
  ));
  $wp_customize->add_control( 'slide_speed', array(
    'settings'    => 'slide_speed',
    'label'       => 'Slide Speed',
    'section'     => 'ikaink_slider',
    'type'        => 'select',
    'priority'    => 60,
    'choices'     => array(
            '1000'     => 'Super Quick',
            '2000'     => 'Quick',
            '4000'     => 'Standard',
            '50000'    => 'Slow',
            '10000'    => 'Super Slow',
  )));

  // Color Section
  $wp_customize->add_section('theme_color_options', array(
    'title'       => __('Colors', 'ikaink'),
    'priority'    => 15,
    'panel'       => 'theme_colors_panel',
  ));

  // Color Section: Color Settings
  $wp_customize->add_setting( 'text-color', array(
    'default'     => '#ffffff',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text-color', array(
    'label'       => 'Text Color',
    'palette'     => true,
    'description' => 'Color of page text.',
    'section'     => 'theme_color_options',
    'settings'    => 'text-color',
    'priority'    => 5,
  )));
  $wp_customize->add_setting( 'shadow-color', array(
    'default'     => '#000000',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shadow-color', array(
    'label'       => 'Shadow Color',
    'palette'     => true,
    'description' => 'Color of text shadow.',
    'section'     => 'theme_color_options',
    'settings'    => 'shadow-color',
    'priority'    => 7,
  )));
  
  $wp_customize->add_setting( 'primary-color', array(
    'default'     => '#ed4b5b',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary-color', array(
    'label'       => 'Primary Color',
    'palette'     => true,
    'description' => 'Controls link color and hover over highlights.',
    'section'     => 'theme_color_options',
    'settings'    => 'primary-color',
    'priority'    => 10,
  )));

  $wp_customize->add_setting( 'secondary-color', array(
    'default'     => 'rgba(0, 44, 67, 0.5)',
  ));
  $wp_customize->add_control( new ikaink_Customize_Alpha_Color_Control( $wp_customize,'secondary-color', array(
    'label'       => 'Secondary Color',
    'palette'     => true,
    'description' => 'Used for forms and footer container (supports opacity).',
    'section'     => 'theme_color_options',
    'settings'    => 'secondary-color',
    'priority'    => 20,
  )));

  $wp_customize->add_setting( 'container-color', array(
    'default'     => 'rgba(255, 255, 255, 0.1)',
  ));
  $wp_customize->add_control( new ikaink_Customize_Alpha_Color_Control( $wp_customize,'container-color', array(
    'label'       => 'Container Color',
    'palette'     => true,
    'description' => 'Background color of page, post, portfolio, widget and main menu containers (supports opacity).',
    'section'     => 'theme_color_options',
    'settings'    => 'container-color',
    'priority'    => 30,
  )));

  // Footer Options Section
  $wp_customize->add_section('ikaink_footer_options', array(
    'title'       => __('Footer', 'ikaink'),
    'description' => 'Choose footer options!',
    'priority'    => 40,
    'panel'       => 'theme_colors_panel',
  ));

  // Footer Options Section: Footer Settings
  $wp_customize->add_setting('footer_select', array(
    'default'     => 'yes',
    'capability'  => 'edit_theme_options',
  ));
  $wp_customize->add_control( 'footer_select', array(
    'settings'    => 'footer_select',
    'label'       => 'Footer Image',
    'description' => 'Display footer image?',
    'section'     => 'ikaink_footer_options',
    'priority'    => 10,
    'type'        => 'select',
        'choices' => array(
            'yes'    => 'Yes',
            'no'     => 'No',
  )));

  $wp_customize->add_setting('footer_image', array(
    'default'     =>  esc_url( get_template_directory_uri() ) . '/images/jellyfish.png',
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'footer_image', array(
    'label'       => 'Upload Footer Image',
    'description' => 'Add a custom footer image to display at the bottom of the page behind the footer.',
    'section'     => 'ikaink_footer_options',
    'settings'    => 'footer_image',
    'priority'    => 20,
  )));

  $wp_customize->add_setting( 'top-color', array(
    'default'     => '#002c43',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'top-color', array(
    'label'       => 'Footer Gradient Top',
    'palette'     => true,
    'description' => 'First color for footer gradient (make both top and bottom the same color for no gradient).',
    'section'     => 'ikaink_footer_options',
    'settings'    => 'top-color',
    'priority'    => 30,
  )));
  $wp_customize->add_setting( 'bottom-color', array(
    'default'     => '#307673',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'bottom-color', array(
    'label'       => 'Footer Gradient Bottom',
    'palette'     => true,
    'description' => 'Second color for footer gradient (make both top and bottom the same color for no gradient).',
    'section'     => 'ikaink_footer_options',
    'settings'    => 'bottom-color',
    'priority'    => 40,
  )));
  
  // Social Media Panel
  $wp_customize->add_panel( 'social_media_panel', array(
    'priority'    => 30,
    'capability'  => 'edit_theme_options',
    'title'       => 'Social Media',
    'description' => 'Change the themes main color scheme!',
  ));

  // Social Media Section 
  $wp_customize->add_section('ikaink_social_media', array(
    'title'       => __('Social Media Links', 'ikaink'),
    'description' => 'Enter the URL linking to your social media pages. Please include http://...',
    'priority'    => 30,
    'panel'       => 'social_media_panel',
  ));
  
  // Social Media Section: Social Media Settings
  $wp_customize->add_setting(
    'facebook'
  );
  $wp_customize->add_control( 'facebook', array(
    'label'       => 'Facebook',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 10,
  ));
    
  $wp_customize->add_setting(
    'instagram'
  );
  $wp_customize->add_control( 'instagram', array(
    'label'       => 'Instagram',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 20,
  ));
    
  $wp_customize->add_setting(
    'deviantart'
  );
  $wp_customize->add_control( 'deviantart', array(
    'label'       => 'deviantART',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 30,
  ));

  $wp_customize->add_setting(
    'twitter'
  );
  $wp_customize->add_control( 'twitter', array(
    'label'       => 'Twitter',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 40,
  ));

  $wp_customize->add_setting(
    'flickr'
  );
  $wp_customize->add_control( 'flickr', array(
    'label'       => 'Flickr',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 50,
  ));

  $wp_customize->add_setting(
    'lastfm'
  );
  $wp_customize->add_control( 'lastfm', array(
    'label'       => 'last.fm',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 60,
  ));

  $wp_customize->add_setting(
    'googleplus'
  );
  $wp_customize->add_control( 'googleplus', array(
    'label'       => 'Google+',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 70,
  ));

  $wp_customize->add_setting(
    'linkedin'
  );
  $wp_customize->add_control( 'linkedin', array(
    'label'       => 'Linkedin',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 80,
  ));

  $wp_customize->add_setting(
    'youtube'
  );
  $wp_customize->add_control( 'youtube', array(
    'label'       => 'YouTube',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 90,
  ));

  $wp_customize->add_setting(
    'tumblr'
  );
  $wp_customize->add_control( 'tumblr', array(
    'label'       => 'Tumblr',
    'section'     => 'ikaink_social_media',
    'type'        => 'url',
    'priority'    => 100,
  ));

  // Other Customizations
  $wp_customize->get_setting( 'blogname'          )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription'   )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor'  )->transport = 'postMessage';
  $wp_customize->get_control( 'background_color'  )->transport = 'postMessage';
  $wp_customize->get_section( 'header_image'      )->title     = 'Header';
  $wp_customize->get_section( 'header_image'      )->priority  = 6;
  $wp_customize->get_section( 'header_image'      )->panel     = 'theme_colors_panel';
  $wp_customize->get_control( 'background_color'  )->section   = 'background_image';
  $wp_customize->get_section( 'background_image'  )->title     = 'Background Settings';
  $wp_customize->get_section( 'background_image'  )->panel     = 'theme_colors_panel';
  $wp_customize->get_section( 'background_image'  )->priority  = 7;
  $wp_customize->get_section( 'title_tagline'     )->title     = 'Site Title';
  $wp_customize->get_section( 'title_tagline'     )->panel     = 'general_options_panel';
  $wp_customize->get_section( 'title_tagline'     )->priority  = 8;
  $wp_customize->remove_section( 'colors' );
  $wp_customize->remove_section( 'static_front_page' );
}
add_action( 'customize_register', 'ikaink_customize_register' );

function ikaink_customizer_css() {

    $primary_color = get_theme_mod( 'primary-color' );
    $secondary_color = get_theme_mod( 'secondary-color' );
    $container_color = get_theme_mod( 'container-color' );
    $top_color = get_theme_mod( 'top-color' );
    $bottom_color = get_theme_mod( 'bottom-color' );
    $text_color = get_theme_mod( 'text-color' );
    $shadow_color = get_theme_mod( 'shadow-color' );
    if ( $primary_color != '#ed4b5b' || $secondary_color != 'rgba(0, 44, 67, 0.5)' || $container_color != 'rgba(255, 255, 255, 0.1)' || $top_color != '#002c43' || $bottom_color != '#002c43' || $text_color != '#ffffff' || $shadow_color != '#000000' ) :
    ?>
    <style type="text/css">
    body {
      color: <?php echo $text_color; ?>;
    }
    h1, 
    h2, 
    h3, 
    h4, 
    h5, 
    h6 {
        color: <?php echo $text_color; ?>;
        text-shadow: 0 0 6px <?php echo $shadow_color; ?>;
    }
    a, a:link, a:visited, .comment-text a:hover {
        color: <?php echo $primary_color; ?>;
    }
    .nav ul li, .nav-sm ul li, .top-nav ul li, .post .post-body-clear, .post .post-body, .portfolio .post-body, .related-portfolio, .comment-list ul li .comment-body, .comment-form, #slider .carousel-caption, footer, .light-box {
        text-shadow: 0 0 6px <?php echo $shadow_color; ?>;
    }
    .nav ul li:hover, .nav-sm ul li:hover, .top-nav ul li:hover, .nav ul li > ul li, .top-nav ul li > ul li {
        background-color: <?php echo $primary_color; ?>;
    }
    .search-box input[type=search]:focus {
        border: 1px solid <?php echo $primary_color; ?>;
        -webkit-box-shadow: 0 0 5px <?php echo $primary_color; ?>;
        -moz-box-shadow: 0 0 5px <?php echo $primary_color; ?>;
        box-shadow: 0 0 5px <?php echo $primary_color; ?>;
    }
    .search-box input[type=search], .image-inside:hover, select, .widgets select, .widgets input[type=text], .widgets input[type=email], .widgets input[type=url], .widgets #calendar_wrap tbody tr:nth-child(odd), .footer-widgets {
        background-color: <?php echo $secondary_color; ?>;
    }
    .nav ul li, .nav-sm ul li, .top-nav ul li, .nav-sm ul li > ul li, .post .post-body, .post-nav ul li, .portfolio, .related-portfolio,  .comment-list ul li .comment-body, .comment-form, #slider, .light-box, footer ul li, .light-box ul li, .timeline.var-chromeless {
        background-color: <?php echo $container_color; ?>;
    }
    .post .dashicons, .post-body .dashicons {
      border: solid 3px <?php echo $text_color; ?>;
    }
    .portfolio .post-body {
        background-color: rgba(255, 255, 255, 0.0);
    }
    footer {
        background: <?php echo $top_color; ?>;
        background: -moz-linear-gradient(top, <?php echo $top_color; ?> 0%, <?php echo $bottom_color; ?> 100%);
        background: -webkit-gradient(left top, left bottom, color-stop( 0%, <?php echo $top_color; ?> ), color-stop(100%, <?php echo $bottom_color; ?>));
        background: -webkit-linear-gradient(top, <?php echo $top_color; ?> 0%, <?php echo $bottom_color; ?> 100%);
        background: -o-linear-gradient(top, <?php echo $top_color; ?> 0%, <?php echo $bottom_color; ?> 100%);
        background: -ms-linear-gradient(top, <?php echo $top_color; ?> 0%, <?php echo $bottom_color; ?> 100%);
        background: linear-gradient(to bottom, <?php echo $top_color; ?> 0%, <?php echo $bottom_color; ?> 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $top_color; ?>', endColorstr='<?php echo $bottom_color; ?>', GradientType=0 );
    }
    </style>
    <?php
    endif;
}
add_action( 'wp_head', 'ikaink_customizer_css' );

function example_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
?>