<?php
/** 
 * Display Portfolio Items From Category
 */

class ikaink_widget_portfolio extends WP_Widget
{ 	
  
  function ikaink_widget_portfolio() { 
    $widget_ops = array('classname' => 'IKAinkPortfolio', 'description' => 'Main page area widget to display featured portfolio category.' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_portfolio', 'IKAink Portfolio: Main', $widget_ops, $control_ops);
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
			   $args=array( 
			      'taxonomy' => 'categories', 
			      );
			   $categories = get_categories($args);

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
		<?php endif; ?>
		<article class="portfolio post row">
			<?php
			$args = array(
				'post_type' => 'portfolio',
				'categories'  => $instance['category'],
			    'posts_per_page' => $instance['show'],
				);

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<?php if(get_theme_mod('nav_select') == 'top' or get_theme_mod('width_select') == 'fluid') { ?>
			<div class="col-md-4">
			<?php } else { ?>
			<div class="col-md-6">
			<?php } ?>
				<div class="post-body">
			        <!-- featured image -->
			        <?php if ( has_post_thumbnail() ) { ?>
			        <div class="image-container">
			            <div class="image-column">
			                <?php the_featured_image( 'portfolio-thumb' ); ?>
			                <div class="image-inside">
			                    <div class="image-inside-center">
			                        <h1 class="image-header">
			                            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'compass' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			                        </h1>
			                        <div class="separator"></div>
			                        <div class="image-text"><a href="<?php the_permalink(); ?>"><?php echo excerpt(15); ?></a></div>
			                    </div>
			                </div>
			            </div>
			            </a>
			        </div>
			        <?php } ?>
			        <!-- featured image -->
			    </div>
			</div>
			<?php endwhile; ?>
		</article>
		<?php wp_reset_postdata();
  }// widget() function
}// IKAinkPortfolio

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_portfolio");') );

?>