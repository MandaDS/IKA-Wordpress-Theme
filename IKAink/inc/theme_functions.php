<?php
/*
 * IKA.ink Theme Functions
 * 
 * Implement Basic Custom Theme functions.
 *
 */

// Breadcrumb 
function get_breadcrumbs()	{ ?>
<div id="top" class="row-fluid">
        <div class="col-md-12">
             <ol class="breadcrumb">
			<?php
			$delimiter = ' / ';
			$name = get_bloginfo('name');
			$currentBefore = ' <span class="active">';
			$currentAfter = '</span> ';
			$type = get_post_type();

			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo('name'); ?></a> / 
			<?php
			if (!is_home() && !is_front_page() && get_post_type() == $type || is_paged()) {

				global $post;
				$home = esc_url( home_url() );
				if (is_category()) {
					global $wp_query;
					$cat_obj = $wp_query->get_queried_object();
					$thisCat = $cat_obj->term_id;
					$thisCat = get_category($thisCat);
					$parentCat = get_category($thisCat->parent);
					if ($thisCat->parent != 0) {
						echo(get_category_parents($parentCat, true, '' . $delimiter . ''));
					}
					echo $currentBefore . single_cat_title() . $currentAfter;
				}
				else if (is_day()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '';
					echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
					echo $currentBefore . get_the_time('d') . $currentAfter;
				} else if (is_month()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '';
					echo $currentBefore . get_the_time('F') . $currentAfter;
				} else if (is_year()) {
					echo $currentBefore . get_the_time('Y') . $currentAfter;
				} else if (is_attachment()) {
					echo $currentBefore;
					the_title();
					$currentAfter;
				} elseif ( get_post_type() == 'portfolio' ) {
					$cat = $post->post_type;
					echo $cat;
					echo $delimiter;
					echo $currentBefore;

					echo $currentAfter;;
				} if (is_single() && get_post_type() == $type ){
					$cat = get_the_category();
					$cat = $cat[0];
					if ($cat !==NULL) {
						echo get_category_parents($cat, true, ' ' . $delimiter . '');
					}
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_page() && !$post->post_parent) {
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_page() && $post->post_parent) {
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach($breadcrumbs as $crumb)
					echo $crumb . ' ' . $delimiter . ' ';
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_search()) {
					echo $currentBefore . __('Search Results For:','limelight') . ' ' . get_search_query() . $currentAfter;
				} else if (is_tag()) {
					echo $currentBefore . single_tag_title() . $currentAfter;
				} else if (is_author()) {
					global $author;
					$userdata = get_userdata($author);
					echo $currentBefore . $userdata->display_name . $currentAfter;
				} else if (is_404()) {
					echo $currentBefore . '404 Not Found' . $currentAfter;
				}
				if (get_query_var('paged')) {
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo  $currentBefore;
					}
					echo __('Page','limelight') . ' ' . get_query_var('paged');
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo $currentAfter;
					}
				}
			} ?>
        </ol>
    </div>
</div>
<?php } 

// Dashicons
function get_dashicons()  {
if ( has_post_format( 'status' )) { ?>
        <div class="dashicons dashicons-format-status"></div>
        <?php } elseif ( has_post_format( 'quote' )) { ?>
        <div class="dashicons dashicons-format-quote"></div>
        <?php } elseif ( has_post_format( 'gallery' )) { ?>
        <div class="dashicons dashicons-format-gallery"></div>
        <?php } elseif ( has_post_format( 'image' )) { ?>
        <div class="dashicons dashicons-format-image"></div>
        <?php } elseif ( has_post_format( 'video' )) { ?>
        <div class="dashicons dashicons-format-video"></div>
        <?php } elseif ( has_post_format( 'audio' )) { ?>
        <div class="dashicons dashicons-format-audio"></div>
        <?php } else { ?>
        <div class="dashicons dashicons-admin-post"></div>
<?php } }

// Post Details
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
<?php } 

// Top navigation option 
function get_top_navigation()  {
if(get_theme_mod('nav_select') && get_theme_mod('nav_select') == 'top'): ?>
<div id="top-nav" class="container hidden-xs">
    <header id="header" class="header row">
        <?php if ( get_header_image() ) : ?>
        <div id="site-header" class="top-logo col-md-8 col-sm-4">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php header_image(); ?>" title="<?php bloginfo( 'description' ); ?>" alt="<?php bloginfo( 'description' ); ?>">
            </a>
        </div>
        <?php else: ?>
        <div id="site-header" class="top-logo col-md-8 col-sm-4">
            <h1><?php bloginfo( 'name' ); ?></h1>
            <h3><?php bloginfo( 'description' ); ?></h3>
        </div>
        <?php endif; ?>

        <!--- Social and Search -->
        <div class="social-media col-md-4">
            <?php get_template_part( 'social-media' ); ?>
            <div class="search-box">
                <?php get_search_form(); ?>
            </div>
        </div>
        <!--- Social and Search -->
    </header>
</div>

<div class="row-fluid hidden-xs">
    <div class="top-nav col-md-12">
        <div class="container">
            <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
        </div>
    </div>
</div>

<!-- Responsive Top Navigation -->
<aside id="sidebar-sm" class="col-sm-12 hidden-lg hidden-md hidden-sm">
    <div class="nav-sm">
        <?php if ( get_header_image() ) : ?>
        <div id="site-header" class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php header_image(); ?>" title="<?php bloginfo( 'description' ); ?>" alt="IKA.ink">
            </a>
        </div>
        <?php endif; ?>
        <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
    </div>
</aside>
<!-- Responsive Top Navigation -->

<!-- Page Content -->
    <div class="<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-left') { ?>container-left<?php } ?>
    <?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-right') { ?>container-right<?php } ?> 
    <?php if(get_theme_mod('width_select') && get_theme_mod('width_select') == 'fluid') { ?>container-fluid<?php } else { ?>container<?php } ?>">
        <div class="row">
            <div class="col-md-12">
<?php endif; }

// Sidebar hover effect navigation option
function get_side_hover_navigation()  {
if(get_theme_mod('nav_select') && get_theme_mod('nav_select') == 'side-hover') { ?>
<div class="<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-left') { ?>container-left<?php } ?>
<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-right') { ?>container-right<?php } ?> 
<?php if(get_theme_mod('width_select') && get_theme_mod('width_select') == 'fluid') { ?>container-fluid<?php } else { ?>container<?php } ?>">
    <div class="row">

        <!-- Hover navigation -->
        <aside id="sidebar" class="col-md-3 col-sm-4 hidden-md hidden-sm hidden-xs">
            <div class="nav"> 
                <?php if ( get_header_image() ) : ?>
                <div id="site-header" class="logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php header_image(); ?>" title="<?php bloginfo( 'description' ); ?>" alt="IKA.ink">
                    </a>
                </div>
                <?php else: ?>
                <div id="site-header" class="top-logo col-md-8 col-sm-4">
                    <h1><?php bloginfo( 'name' ); ?></h1>
                    <h3><?php bloginfo( 'description' ); ?></h3>
                </div>
                <?php endif; ?>
                <div class="main-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
                </div>
            </div> 
            <div class="widgets">
                <?php dynamic_sidebar( 'sidebar' ); ?>
            </div>
        </aside>
        <!-- Hover Navigation -->
        <!-- Responsive Navigation -->
        <aside id="sidebar-sm" class="col-md-3 col-sm-4 hidden-lg">
            <div class="nav-sm">
                
                <?php if ( get_header_image() ) : ?>
                <div id="site-header" class="logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php header_image(); ?>" title="<?php bloginfo( 'description' ); ?>" alt="IKA.ink">
                    </a>
                </div>
                <?php else: ?>
                <div id="site-header" class="top-logo col-md-8 col-sm-4">
                    <h1><?php bloginfo( 'name' ); ?></h1>
                    <h3><?php bloginfo( 'description' ); ?></h3>
                </div>
                <?php endif; ?>
                <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
            </div>
            <div class="widgets">
                <?php dynamic_sidebar( 'sidebar' ); ?>
            </div>
        </aside>
        <!-- Responsive Navigation -->

        <div class="col-md-9 col-sm-8">
            <div class="header">
                <!-- Main Header -->
                <div class="social-media hidden-xs">
                    <?php get_template_part( 'social-media' ); ?>
                </div>
                <div class="search-box row">
                    <div class="col-md-4 col-md-offset-8 col-xs-12">
                        <?php get_search_form(); ?>
                    </div>
                </div>
                <!-- Main Header -->
            </div>
            <!-- Page Content -->
            <div class="content">
<?php } } 

// Sidebar dropdown navigation option
function get_side_drop_navigation()  {
 if(get_theme_mod('nav_select') && get_theme_mod('nav_select') == 'side-drop') { ?>

<div class="<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-left') { ?>container-left<?php } ?>
<?php if(get_theme_mod('position_select') && get_theme_mod('position_select') == 'container-right') { ?>container-right<?php } ?> 
<?php if(get_theme_mod('width_select') && get_theme_mod('width_select') == 'fluid') { ?>container-fluid<?php } else { ?>container<?php } ?>">
    <div class="row">
        <!-- Drop and responsive navigation -->
        <aside id="sidebar-sm" class="col-md-3 col-sm-4">
            <div class="nav-sm">
                
                <?php if ( get_header_image() ) : ?>
                <div id="site-header" class="logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php header_image(); ?>" title="<?php bloginfo( 'description' ); ?>" alt="IKA.ink">
                    </a>
                </div>
                <?php endif; ?>
                <div class="main-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) ); ?>
                </div>
            </div>
            <div class="widgets">
                <?php dynamic_sidebar( 'sidebar' ); ?>
            </div>
        </aside>
        <!-- Drop and responsive navigation -->
        <div class="col-md-9 col-sm-8">
            <div class="header">
                <!-- Main Header -->
                <div class="social-media hidden-xs">
                   <?php get_template_part( 'social-media' ); ?>
                </div>
                <div class="search-box row">
                    <div class="col-md-4 col-md-offset-8 col-xs-12">
                        <?php get_search_form(); ?>
                    </div>
                </div>
                <!-- Main Header -->
            </div>
            <!-- Page Content -->
            <div class="content">
<?php  } } ?> 