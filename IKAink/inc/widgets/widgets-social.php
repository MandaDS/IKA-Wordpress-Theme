<?php
/** 
 * Display Portfolio Items From Category
 */

class ikaink_widget_social extends WP_Widget
{ 	
  
  function ikaink_widget_social() { 
    $widget_ops = array('classname' => 'IKAinkSocial', 'description' => 'Place in sidebars to display social media links! Links can be added via the customizer.' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_social', 'IKAink Social Media: Sidebar', $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title'=>'') );
	$title = $instance['title'];
	?>
	<div>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">(Optional) Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	</div>
	
<?php  } // form() function

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
  
  function widget($args, $instance) { ?>
  		<?php if ($instance['title']):?>
  			<h2><?php echo $instance['title']; ?></h2>
		<?php endif; ?>
  		<div class="social-media">
		<?php get_template_part( 'social-media' ); ?>
		</div>
	<?php
  }// widget() function
}// IKAinkSocial

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_social");') );

?>