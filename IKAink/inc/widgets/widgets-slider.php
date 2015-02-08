<?php
/** 
 * Main Page Slider
 */

class ikaink_widget_slider extends WP_Widget
{ 	
  
  function ikaink_widget_slider() { 
    $widget_ops = array('classname' => 'IKAinkSlider', 'description' => 'Place in main page area where slider should show. You may control slider settings in the customizer.' );
	$control_ops = array('width' => 350, 'height' => 350); // making widget window larger
	$this->WP_Widget('ikaink_widget_slider', 'IKAink Slider: Main', $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title'=>'', 'sub_title'=>'' ) );
	$title = $instance['title'];
	$sub_title = $instance['sub_title'];
	?>
	<div>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('sub_title'); ?>">Sub Title: <input class="widefat" id="<?php echo $this->get_field_id('sub_title'); ?>" name="<?php echo $this->get_field_name('sub_title'); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>" /></label></p>
	</div>
	
<?php  } // form() function

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['sub_title'] = $new_instance['sub_title'];
    return $instance;
  }
  
  function widget($args, $instance) { 

		$args = array(
		    'post_type' => 'slider'
		); ?>

		<section id="slider">
			<?php if ($instance['title'] && $instance['sub_title']):?>
	  			<h1><?php echo $instance['title']; ?> ||<span> <?php echo $instance['sub_title']; ?></span></h1>
			<?php elseif ($instance['title']): ?>
				<h1><?php echo $instance['title']; ?></h1>
			<?php endif; ?>

			<div id="ikaink-slider" class="carousel slide <?php if(get_theme_mod('animation') == 'carousel-fade') { ?>carousel-fade<?php } ?>" data-ride="carousel">
				<ol class="carousel-indicators">
				<!-- Indicators -->
				<?php 
					$count = 0;
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post(); 
					?>
				    <li data-target="#ikaink-slider" data-slide-to="<?php echo($count); ?>" <?php if($count == 0) { ?>class="active"<?php } ?>></li>
				<?php $count++; endwhile; ?>
				</ol>

			    <!-- Wrapper for slides -->
			    <div class="carousel-inner" role="listbox">
				  	<?php 
				  	$count = 0;
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
				    <div class="<?php if($count == 0) { ?>active <?php } ?>item">
				    <?php 
				    // If URL is present open link
		            $url = get_post_meta(get_the_ID(), 'ikaink_textfield', true);
		            if($url != '') { ?>
		            <a href="<?php echo $url; ?>">
		            <?php }
				      echo the_post_thumbnail($post_id, '', array(
								'alt'	=> trim(strip_tags( $attachment->post_excerpt )),
								'title'	=> trim(strip_tags( $attachment->post_excerpt )),
						)); 

				        // If there is a caption print it
				        $caption = get_post_meta(get_the_ID(), 'ikaink_textarea', true);
				        if($caption != '') { ?>
				        	<div class="carousel-caption"><p><?php echo $caption; ?></p></div>
				        <?php }
				        // If URL is present open link
			            $url = get_post_meta(get_the_ID(), 'ikaink_textfield', true);
			            if($url != '') { ?>
			            </a>
			            <?php } ?>
				    </div>
				    <?php $count++; endwhile; ?>
			    </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#ikaink-slider" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-left 
			    <?php if(get_theme_mod('arrows') == 'default') { ?> glyphicon-chevron-left<?php } ?>
			    <?php if(get_theme_mod('arrows') == 'minimal') { ?> glyphicon-menu-left<?php } ?>
			    <?php if(get_theme_mod('arrows') == 'circle') { ?> glyphicon-circle-arrow-left<?php } ?>
			    <?php if(get_theme_mod('arrows') == 'bold') { ?> glyphicon-triangle-left<?php } ?>
			    <?php if(get_theme_mod('arrows') == 'arrow') { ?> glyphicon-arrow-left<?php } ?>
			    " aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#ikaink-slider" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-right 
			    <?php if(get_theme_mod('arrows') == 'default') { ?> glyphicon-chevron-right <?php } ?>
			    <?php if(get_theme_mod('arrows') == 'minimal') { ?> glyphicon-menu-right <?php } ?>
			    <?php if(get_theme_mod('arrows') == 'circle') { ?> glyphicon-circle-arrow-right <?php } ?>
			    <?php if(get_theme_mod('arrows') == 'bold') { ?> glyphicon-triangle-right <?php } ?>
			    <?php if(get_theme_mod('arrows') == 'arrow') { ?> glyphicon-arrow-right <?php } ?>
			    " aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>

			</div>

		    <?php /*<div class="flexslider">
        		<ul class="slides">
				<?php $loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<li>
			            <?php

			            // If URL is present open link
			            $url = get_post_meta(get_the_ID(), 'ikaink_textfield', true);
			            if($url != '') { ?>
			            <a href="<?php echo $url; ?>">
			            <?php }

			            echo the_post_thumbnail($post_id, '', array(
							'alt'	=> trim(strip_tags( $attachment->post_excerpt )),
							'title'	=> trim(strip_tags( $attachment->post_excerpt )),
						));

			            // If URL is present close link
			            if($url != '') { ?>

			            </a>

			            <?php } 

			            // If there is a caption print it
			            $caption = get_post_meta(get_the_ID(), 'ikaink_textarea', true);
			            if($caption != '') { ?>

			            <p class="flex-caption"><?php echo $caption; ?></p>

			            <?php } ?>
		            </li>
	 			<?php endwhile; ?>
	 			</ul>
	 		</div>
	 	</section> */ ?>
	 	<?php wp_reset_postdata();
  }// widget() function
}// IKAinkSlider

add_action( 'widgets_init', create_function('', 'return register_widget("ikaink_widget_slider");') );

?>