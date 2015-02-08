<?php
/*
   Plugin Name: ikaink Portfolio
   Plugin URI: http://ika.ink
   Description: A plugin that creates a custom post type for creating and displaying a portfolio
   Version: 1.0
   Author: Manda Eldreth
   Author URI: http://ika.ink
   License: GPL2
   */

// Register Custom Post Type
function ikaink_custom_portfolio() {

	$labels = array(
		'name'                => _x( 'Portfolio entries', 'Post Type General Name', 'ikaink' ),
		'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'ikaink' ),
		'menu_name'           => __( 'Portfolio', 'ikaink' ),
		'parent_item_colon'   => __( 'Parent Item:', 'ikaink' ),
		'all_items'           => __( 'All Portfolio Entries', 'ikaink' ),
		'view_item'           => __( 'View Portfolio Entry', 'ikaink' ),
		'add_new_item'        => __( 'Add New Entry', 'ikaink' ),
		'add_new'             => __( 'Add New Portfolio', 'ikaink' ),
		'edit_item'           => __( 'Edit Portfolio Entry', 'ikaink' ),
		'update_item'         => __( 'Update Portfolio Entry', 'ikaink' ),
		'search_items'        => __( 'Search Portfolio', 'ikaink' ),
		'not_found'           => __( 'Not found', 'ikaink' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'ikaink' ),
	);
	$rewrite = array(
		'slug'                => 'Portfolio',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'Portfolio', 'ikaink' ),
		'description'         => __( 'Holds our portfolio specific data', 'ikaink' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', ),
		'taxonomies'          => array( 'categories', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-image',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'portfolio', $args );
    flush_rewrite_rules();
}

// Hook into the 'init' action
add_action( 'init', 'ikaink_custom_portfolio', 0 );

// Custom update messages
function ikaink_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['portfolio'] = array(
    0 => '', 
    1 => sprintf( __('Portfolio entry updated. <a href="%s">Why not take a look?</a>', 'ikaink'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ikaink'),
    3 => __('Custom field deleted.', 'ikaink'),
    4 => __('Portfolio entry updated.', 'ikaink'),
    5 => isset($_GET['revision']) ? sprintf( __('Portfolio entry restored to revision from %s', 'ikaink'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Portfolio entry published. <a href="%s">Why not take a look?</a>', 'ikaink'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Portfolio entry saved.', 'ikaink'),
    8 => sprintf( __('Portfolio entry submitted. <a target="_blank" href="%s">Preview entry!</a>', 'ikaink'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Portfolio entry scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview the portfolio entry!</a>', 'ikaink'), date_i18n( __( 'M j, Y @ G:i', 'ikaink' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Portfolio entry draft updated. <a target="_blank" href="%s">Preview the portfolio entry!</a>', 'ikaink'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}

add_filter( 'post_updated_messages', 'ikaink_updated_messages' );

// Register Custom Taxonomy
function ikaink_portfolio_taxonomies() {

	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'ikaink' ),
		'singular_name'              => _x( 'Portfolio Categories', 'Taxonomy Singular Name', 'ikaink' ),
		'menu_name'                  => __( 'Portfolio Categories', 'ikaink' ),
		'all_items'                  => __( 'All Portfolio Categories', 'ikaink' ),
		'parent_item'                => __( 'Parent Item', 'ikaink' ),
		'parent_item_colon'          => __( 'Parent Item:', 'ikaink' ),
		'new_item_name'              => __( 'New Portfolio Category', 'ikaink' ),
		'add_new_item'               => __( 'Add Portfolio New Category', 'ikaink' ),
		'edit_item'                  => __( 'Edit Portfolio Category', 'ikaink' ),
		'update_item'                => __( 'Update Portfolio Category', 'ikaink' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ikaink' ),
		'search_items'               => __( 'Search portfolio categories', 'ikaink' ),
		'add_or_remove_items'        => __( 'Add or remove portfolio categories', 'ikaink' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'ikaink' ),
		'not_found'                  => __( 'Not Found', 'ikaink' ),
	);
	$rewrite = array(
		'slug'                       => 'categories',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'categories', array( 'portfolio' ), $args );
	flush_rewrite_rules();

}

// Hook into the 'init' action
add_action( 'init', 'ikaink_portfolio_taxonomies', 0 );

//Custom meta box
// Little function to return a custom field value
function ikaink_get_portfolio_custom_field( $value ) {
    global $post;

    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
        return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

    return false;
}

// Add metabox
function ikaink_portfolio_meta_box_add() {
    add_meta_box('portfolio_options', 'Options', 'ikaink_portfolio_meta_box', 'portfolio', 'normal', 'high');
}
add_action( 'add_meta_boxes', 'ikaink_portfolio_meta_box_add' );

// Output the Metabox
function ikaink_portfolio_meta_box( $post ) {
 // create a nonce field
    wp_nonce_field( 'my_ikaink_portfolio_meta_box_nonce', 'ikaink_portfolio_meta_box_nonce' ); ?>
    
    <table>
    	<tr>
    		<td>
    			<p>
			        <label for="ikaink_portfolio_textfield"><?php _e( 'Optional Link to deviantART page:', 'ikaink' ); ?></label><br>
			        <input type="text" name="ikaink_portfolio_textfield" id="ikaink_portfolio_textfield" value="<?php echo ikaink_get_portfolio_custom_field( 'ikaink_portfolio_textfield' ); ?>" size="100" />
			    </p>
    		</td>
    		<td>
    			<p>
				    <label for="ikaink_portfolio_select"><?php _e( 'Copyright year:', 'ikaink' )?></label><br>
					<select name="ikaink_portfolio_select" id="ikaink_portfolio_select">
					<?php
					    $yearOptions = range( date("Y") , 1990 );
					    foreach ($yearOptions as $year):
					?>
					<option value="<?php echo $year ?>" <?php echo ($year == ikaink_get_portfolio_custom_field( 'ikaink_portfolio_select' )) ? 'selected' : '' ?>> <?php _e( $year, 'ikaink' )?></option>'; 
					<?php endforeach; ?>
					</select>
				</p>
    		</td>
    	</tr>
    </table>
    <?php
}

// Save the Metabox values
function ikaink_portfolio_meta_box_save( $post_id ) {
    // Stop the script when doing autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // Verify the nonce. If insn't there, stop the script
    if( !isset( $_POST['ikaink_portfolio_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ikaink_portfolio_meta_box_nonce'], 'my_ikaink_portfolio_meta_box_nonce' ) ) return;

    // Stop the script if the user does not have edit permissions
    if( !current_user_can( 'edit_post' ) ) return;

    // Save the textfield
    if( isset( $_POST['ikaink_portfolio_textfield'] ) )
        update_post_meta( $post_id, 'ikaink_portfolio_textfield', esc_attr( $_POST['ikaink_portfolio_textfield'] ) );

    // Save the year
    if( isset( $_POST['ikaink_portfolio_select'] ) )
        update_post_meta( $post_id, 'ikaink_portfolio_select', esc_attr( $_POST['ikaink_portfolio_select'] ) );
}
add_action( 'save_post', 'ikaink_portfolio_meta_box_save' );

?>