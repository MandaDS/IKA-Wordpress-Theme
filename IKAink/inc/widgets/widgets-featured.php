<?php
/** 
 * Show Blog Feed on main page
 */

class ikaink_widget_featured extends WP_Widget
{ 	
  
  function ikaink_widget_featured() { 
    $widget_ops = array('classname' => 'IKAinkFeatured', 'description' => 'Choose a featured category for view on the main page. Set up for use on the main page widget area only!' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_featured', 'IKAink Featured Category: Main', $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title'=>'', 'sub_title'=>'', 'show'=>'1', 'category'=>'' ) );
	$title = $instance['title'];
	$sub_title = $instance['sub_title'];
	$show = $instance['show'];
	$category = $instance['category'];
	?>
	<div>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('sub_title'); ?>">Sub Title: <input class="widefat" id="<?php echo $this->get_field_id('sub_title'); ?>" name="<?php echo $this->get_field_name('sub_title'); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('show'); ?>">Show How many?: <input style="width: 100px;" class="widefat" id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" type="show" value="<?php echo esc_attr($show); ?>" /></label></p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>">Category: 
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
			   <?php
			   $categories = get_categories();

  				foreach ($categories as $cat)
			   {
				   if ($cat->slug == $category) {
				   		echo '<option value="'.$cat->slug.'" selected>'.$cat->name.'</option>';
				   	} else {
				        echo '<option value="'.$cat->slug.'">'.$cat->name.'</option>';
				   	}
			    }
			    ?>
			</select>
			</label>
		</p>
	</div>
	
<?php  } // form() function

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['sub_title'] = $new_instance['sub_title'];
	$instance['show'] = $new_instance['show'];
	$instance['category'] = $new_instance['category'];
    return $instance;
  }
  
  function widget($args, $instance) { 

  		if ($instance['title'] && $instance['sub_title']):?>
  			<h1><?php echo $instance['title']; ?> <span>|| <?php echo $instance['sub_title']; ?></span></h1>
		<?php elseif ($instance['title']): ?>
			<h1><?php echo $instance['title']; ?></h1>
		<?php endif;

		$args = array(
		   'category_name'  => $instance['category'],
		   'posts_per_page' => $instance['show'],
		   'orderby' => 'date',
		   'order' => 'DESC'
		);

		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); ?>

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

		        <?php the_excerpt(); ?>
		    </div>
		</article>

		<?php  endwhile;
 		wp_reset_postdata();
  }// widget() function
}// IKAinkFeatured

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_featured");') );

?>