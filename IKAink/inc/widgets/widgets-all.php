<?php
/** 
 * Show Blog Feed on main page
 */

class ikaink_widget_all extends WP_Widget
{ 	
  
  function ikaink_widget_all() { 
    $widget_ops = array('classname' => 'IKAinkBlogFeed', 'description' => 'For use in main page area to show all blog posts in all categories.' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_all', 'IKAink Blog Feed: Main', $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title'=>'', 'sub_title'=>'', 'show'=>'1' ) );
	$title = $instance['title'];
	$sub_title = $instance['sub_title'];
	$show = $instance['show'];?>
	<div>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('sub_title'); ?>">Sub Title: <input class="widefat" id="<?php echo $this->get_field_id('sub_title'); ?>" name="<?php echo $this->get_field_name('sub_title'); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('show'); ?>">Show How many?: <input style="width: 100px;" class="widefat" id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" type="show" value="<?php echo esc_attr($show); ?>" /></label></p>
	</div>
	
<?php  } // form() function

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['sub_title'] = $new_instance['sub_title'];
	$instance['show'] = $new_instance['show'];
    return $instance;
  }
  
  function widget($args, $instance) { 

  		if ($instance['title'] && $instance['sub_title']):?>
  			<h1><?php echo $instance['title']; ?> <span>|| <?php echo $instance['sub_title']; ?></span></h1>
		<?php elseif ($instance['title']): ?>
			<h1><?php echo $instance['title']; ?></h1>
		<?php endif;

		query_posts('showposts='.$instance['show'].''); if (have_posts()) : while (have_posts()) : the_post();  ?>

		<article id="post-<?php the_ID(); ?>" class="post post-clear row-fluid"> 
		    <div class="post-body"> 

			    <h2>
			    	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'compass' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			    	<?php get_dashicons(); ?>
			        <?php the_title(); ?>
			        </a>
			    </h2>

			    <?php get_details(); ?>
		        <!-- featured image -->
		        <?php if ( has_post_thumbnail() ) { ?>
		        <a href="<?php the_permalink(); ?>">
		        <?php the_featured_image(); ?>
		        </a>
		        <?php } ?>
		        <!-- featured image -->

		        <?php the_content(); ?>
		    </div>
		</article>

		<?php  endwhile;
		else : ?>
		<h2>No Posts</h2> 
 		<?php endif; wp_reset_query();
  }// widget() function
}// IKAinkBlogFeed

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_all");') );

?>