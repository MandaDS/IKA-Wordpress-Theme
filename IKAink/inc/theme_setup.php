<?php
/*
 * IKA.ink Theme Setup Support
 * 
 * Implement Theme Setup.
 *
 */

/**
 * Register our sidebars and widgetized areas.
 *
 */
require_once ( get_template_directory() . '/widgets.php' );

function ikaink_widgets_init() {

	register_sidebar( array(
		'name' => 'Main Area on Page',
		'description' => __('Place IKAink main page widgets here to customize main page display. Please only place IKAink widgets that were specifically made for main page display. Other widgets may not show correctly.', 'ikaink'),
		'id' => 'main',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => 'Sidebar',
		'description' => __('Widgets placed here will show in the sidebar area for the "Hover over sidebar" or "Drop down sidebar" navigation layout option.', 'ikaink'),
		'id' => 'sidebar',
		'before_widget' => '<div class="light-box hidden-xs">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => 'Footer left',
		'id' => 'footer_left',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
    register_sidebar( array(
		'name' => 'Footer middle',
		'id' => 'footer_middle',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
    register_sidebar( array(
		'name' => 'Footer right',
		'id' => 'footer_right',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
    register_sidebar( array(
		'name' => 'Footer bottom',
		'id' => 'footer_bottom',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
}

add_action( 'widgets_init', 'ikaink_widgets_init' );

/**
 * Register Menu area.
 *
 */
function register_my_menus() {
  register_nav_menus(
    array(
      'main-nav' => __( 'Main Navigation', 'ikaink' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );

/**
*
* Register Theme Features
*
*/
function custom_theme_features()  {
	global $wp_version;

	// Title tag
	add_theme_support( 'title-tag' );

	// Enable HTML5 markup
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Add theme support for Post Formats
	$formats = array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', );
	add_theme_support( 'post-formats', $formats );	

	// Add theme support for Featured Images
	add_theme_support( 'post-thumbnails', array( 'post', 'portfolio', 'page', 'slider' ) );

	// Add theme support for automatic rss
	add_theme_support( 'automatic-feed-links' );

	 // Set custom thumbnail dimensions
	set_post_thumbnail_size( 200, 200, true );

	// Add theme support for Custom Background
	$background_args = array(
		'default-color'          => '#002c43',
		'default-image'          => get_template_directory_uri() .'/images/waterbg.png',
		'default-repeat'         => 'repeat-x',
		'default-position-x'     => 'left',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $background_args );

	// Add theme support for Custom Header
	$header_args = array(
		'default-image'          => '',
		'width'                  => 0,
		'height'                 => 0,
		'flex-width'             => true,
		'flex-height'            => true,
		'random-default'         => true,
		'header-text'            => true,
		'default-text-color'     => '',
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $header_args );
}

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'custom_theme_features' );

function my_after_setup_theme(){
    add_action( 'customize_preview_init', 'mytheme_customize_preview_js' );
}
add_action( 'after_setup_theme', 'my_after_setup_theme' );

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'portfolio-thumb', 400, 300, true ); //(cropped)
	add_image_size( 'related-thumb', 200, 200, true ); //(cropped)
}

// Enable dash-icons
add_action( 'wp_enqueue_scripts', 'ikaink_scripts' );

function ikaink_scripts() {
    wp_enqueue_style( 'ikaink-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );
}

// Header Image
function ikaink_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ikaink_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => 1260,
		'height'                 => 240,
		'flex-height'            => true,
		'wp-head-callback'       => 'ikaink_header_style',
		'admin-head-callback'    => 'ikaink_admin_header_style',
		'admin-preview-callback' => 'ikaink_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'ikaink_custom_header_setup' );

if ( ! function_exists( 'ikaink_header_style' ) ) :

function ikaink_header_style() {
	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="ikaink-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title a {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // ikaink_header_style

/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see ikaink_custom_header_setup()
 *
 */
if ( ! function_exists( 'ikaink_admin_header_style' ) ) :
	
function ikaink_admin_header_style() {
?>
	<style type="text/css" id="ikaink-admin-header-css">
	.appearance_page_custom-header #headimg {
		background-color: #fff;
		border: none;
		max-width: 1260px;
		min-height: 48px;
	}
	#heading h1 {
		font-family: Lato, sans-serif;
		font-size: 18px;
		line-height: 48px;
		margin: 0 0 0 30px;
	}
	#heading h1 a {
		color: #fff;
		text-decoration: none;
	}
	#heading img {
		vertical-align: middle;
	}
	</style>
<?php
}
endif; // ikaink_admin_header_style

if ( ! function_exists( 'ikaink_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see ikaink_custom_header_setup()
 *
 */
function ikaink_admin_header_image() {
?>
	<div id="heading">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		<h1 class="displaying-header-text"><a id="name"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}
endif; // ikaink_admin_header_image

/**
 * Excerpt link
 *
 */

// add more link to excerpt
function ikaink_new_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-file"></span>' . __('Read More', 'ikaink') . '</button></a>';
}

add_filter( 'excerpt_more', 'ikaink_new_excerpt_more' );

// custom excerpt length
function ikaink_custom_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'ikaink_custom_excerpt_length', 999 );

// Custom Excerpt
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }    
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }    
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}


/**
 * Comments Display
 *
 */
function ikaink_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>

<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body row">
    <?php endif; ?>
        <div class="avatar col-md-3">
            <?php if ( $args['avatar_size'] = 126 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <h4><?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?></h4>
        </div>
        <div class="col-md-9">
            <div class="comment-text">
                <?php comment_text(); ?>
                <div class="date hidden-xs">
                    Posted on <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                    <?php
                    /* translators: 1: date, 2: time */
                     printf( __('%1$s at %2$s', 'ikaink'), get_comment_date(),  get_comment_time() ); ?></a>
                </div>
                <div class="arrow"></div>
            </div>
            <p class="reply" align="right">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </p>
        </div>
        <?php if ( 'div' != $args['style'] ) : ?>
    </div>
<?php endif; 
}

/**
 * Comments Form
 *
 */

add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );
function bootstrap3_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name', 'ikaink' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email', 'ikaink' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website', 'ikaink' ) . '</label> ' .
                    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
    );
    
    return $fields;
}
add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );
function bootstrap3_comment_form( $args ) {
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun', 'ikaink' ) . '</label> 
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
    return $args;
}
add_action('comment_form', 'bootstrap3_comment_button' );
function bootstrap3_comment_button() {
    echo '<button class="btn btn-default" type="submit">' . __( 'Submit', 'ikaink' ) . '</button>';
}

/**
 * Theme support
 *
 */
function the_featured_image( $size = 'full', $class = 'center featured-img' ) {
 
    global $post;
 
    if ( has_post_thumbnail( $post->ID ) ) {
 
    /* get the title attribute of the post or page 
     * and apply it to the alt tag of the image if the alt tag is empty
     */
    $attachment_id = get_post_thumbnail_id( $post->ID );
 
    if ( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) === '' ) {
        // if no alt attribute is filled out then echo "Featured Image of article: Article Name"
        $title = the_title_attribute( 
            array( 
                'before' => __( 'Featured image of article: ', 'ikaink' ), 
                'echo' => false
            ) 
        );
    } else {
        // the post thumbnail img alt tag
        $title = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
    }
 
    $default_attr = array(
        'class' => $class,
        'alt' => $title,
        'title' => $title
    );
 
    // echo the featured image
    the_post_thumbnail( $size, $default_attr );
 
    } // end if has_post_thumbnail
}

function remove_img_attr ($html) {
    return preg_replace('/(width|height)="\d+"\s/', "", $html);
}
add_filter( 'post_thumbnail_html', 'remove_img_attr' );

?>