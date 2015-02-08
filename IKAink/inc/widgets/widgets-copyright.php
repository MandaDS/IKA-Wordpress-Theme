<?php
/** 
 * Display copyright information
 */

class ikaink_widget_copyright extends WP_Widget
{ 	
  
  function ikaink_widget_copyright() { 
    $widget_ops = array('classname' => 'IKAinkcopyright', 'description' => 'Will automatically display copyright information' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_copyright', 'IKAink Copyright: Footer', $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'text'=>'' ) );
	$text = $instance['text']; ?>
	<div>
		<p><label for="<?php echo $this->get_field_id('text'); ?>">Optional text: <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" /></label></p>
	</div>
	
<?php  } // form() function

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['text'] = $new_instance['text'];
    return $instance;
  }
  
  function widget($args, $instance) { ?>
  	<div class="copy-right"><p>
  	&copy; <?php echo date("Y") ?> <?php echo bloginfo( 'name' ); ?>.
	  	<?php if ($instance['text']): 
	  		echo $instance['text']; 
		endif; ?>
	</p></div> <?php
  }// widget() function
}// IKAinkCopyright

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_copyright");') );

?>