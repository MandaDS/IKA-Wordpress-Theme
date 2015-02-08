<?php
/*
   Plugin Name: ikaink Slider
   Plugin URI: http://ika.ink
   Description: A plugin that creates a custom post type for creating and displaying an image slider
   Version: 1.0
   Author: Manda Eldreth
   Author URI: http://ika.ink
   License: GPL2
   */

// Register Custom Post Type
function ikaink_slider() {

    $labels = array(
        'name'                => _x( 'Slides', 'Post Type General Name', 'Ikaink' ),
        'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'Ikaink' ),
        'menu_name'           => __( 'Slider', 'ikaink' ),
        'parent_item_colon'   => __( 'Parent Item:', 'ikaink' ),
        'all_items'           => __( 'All Slides', 'ikaink' ),
        'view_item'           => __( 'View Item', 'ikaink' ),
        'add_new_item'        => __( 'Add New Slide', 'ikaink' ),
        'add_new'             => __( 'Add New', 'ikaink' ),
        'edit_item'           => __( 'Edit Item', 'ikaink' ),
        'update_item'         => __( 'Update Item', 'ikaink' ),
        'search_items'        => __( 'Search Slides', 'ikaink' ),
        'not_found'           => __( 'Not found', 'ikaink' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ikaink' ),
    );
    $args = array(
        'label'               => __( 'Slider', 'Ikaink' ),
        'description'         => __( 'Post Type DescriptionHolds Slider Information', 'ikaink' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'thumbnail', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-images-alt',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'rewrite'             => false,
        'capability_type'     => 'post',
    );
    register_post_type( 'Slider', $args );
    flush_rewrite_rules();

}

// Hook into the 'init' action
add_action( 'init', 'ikaink_slider', 0 );

// Custom update messages
function ikaink_update_message( $messages ) {
  global $post, $post_ID;
  $messages['slider'] = array(
    0 => '', 
    1 => sprintf( __('Slide updated. <a href="%s">Why not take a look?</a>', 'ikaink'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ikaink'),
    3 => __('Custom field deleted.', 'ikaink'),
    4 => __('Slide updated.', 'ikaink'),
    5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s', 'ikaink'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Slide published. <a href="%s">Why not take a look?</a>', 'ikaink'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Slide saved.', 'ikaink'),
    8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview entry!</a>', 'ikaink'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview the portfolio entry!</a>', 'ikaink'), date_i18n( __( 'M j, Y @ G:i', 'ikaink' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview the portfolio entry!</a>', 'ikaink'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'ikaink_update_message' );


//Custom meta box
// Little function to return a custom field value
function ikaink_get_custom_field( $value ) {
    global $post;

    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
        return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

    return false;
}

// Add metabox
function ikaink_meta_box_add() {
    add_meta_box('slide_link', 'Slide Link and Caption', 'ikaink_link_meta_box', 'slider', 'normal', 'default');
}
add_action( 'add_meta_boxes', 'ikaink_meta_box_add' );

// Output the Metabox
function ikaink_link_meta_box( $post ) {
 // create a nonce field
    wp_nonce_field( 'my_ikaink_meta_box_nonce', 'ikaink_meta_box_nonce' ); ?>
    
    <p>
        <label for="ikaink_textfield"><?php _e( 'Optional Link for slide (start with http://)', 'ikaink' ); ?></label><br>
        <input type="text" name="ikaink_textfield" id="ikaink_textfield" value="<?php echo ikaink_get_custom_field( 'ikaink_textfield' ); ?>" size="50" />
    </p>
    <p>
        <label for="ikaink_textarea"><?php _e( 'Description/caption (optional)', 'ikaink' ); ?>:</label><br />
        <textarea name="ikaink_textarea" id="ikaink_textarea" cols="60" rows="4"><?php echo ikaink_get_custom_field( 'ikaink_textarea' ); ?></textarea>
    </p>
    
    <?php
}

// Save the Metabox values
function ikaink_meta_box_save( $post_id ) {
    // Stop the script when doing autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // Verify the nonce. If insn't there, stop the script
    if( !isset( $_POST['ikaink_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ikaink_meta_box_nonce'], 'my_ikaink_meta_box_nonce' ) ) return;

    // Stop the script if the user does not have edit permissions
    if( !current_user_can( 'edit_post' ) ) return;

    // Save the textfield
    if( isset( $_POST['ikaink_textfield'] ) )
        update_post_meta( $post_id, 'ikaink_textfield', esc_attr( $_POST['ikaink_textfield'] ) );

    // Save the textarea
    if( isset( $_POST['ikaink_textarea'] ) )
        update_post_meta( $post_id, 'ikaink_textarea', esc_attr( $_POST['ikaink_textarea'] ) );
}
add_action( 'save_post', 'ikaink_meta_box_save' );


// Place the metabox in the post edit page below the editor before other metaboxes (like the Excerpt)
// add_meta_box( 'ikaink-meta-box', __( 'Metabox Example', 'ikaink' ), 'ikaink_meta_box_output', 'post', 'normal', 'high' );
// Place the metabox in the post edit page below the editor at the end of other metaboxes
// add_meta_box( 'ikaink-meta-box', __( 'Metabox Example', 'ikaink' ), 'ikaink_meta_box_output', 'post', 'normal', '' );
// Place the metabox in the post edit page in the right column before other metaboxes (like the Publish)
// add_meta_box( 'ikaink-meta-box', __( 'Metabox Example', 'tikaink' ), 'wikaink_meta_box_output', 'post', 'side', 'high' );
// Place the metabox in the post edit page in the right column at the end of other metaboxes
// add_meta_box( 'ikaink-meta-box', __( 'Metabox Example', 'ikaink' ), 'ikaink_meta_box_output', 'post', 'side', '' );

?>