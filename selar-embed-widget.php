<?php
/*
Plugin Name: Selar Embed Widget
Plugin URI: https://selar.co/plugins
Description: Embed a Selar product/profile on your website.
Author: Kendysond
Version: 1.0
Author URI: https://github.com/kendysond
*/

class KKD_Selar_Product_Widget extends WP_Widget {
  	public function __construct() {
	    $widget_options = array( 
	      'classname' => 'selar_product_widget',
	      'description' => 'Selar Product Widget',
	    );
	    parent::__construct( 'selar_widget', 'Selar Product Widget', $widget_options );
  	}
  	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
		<p>
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
	}
  	public function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance[ 'title' ]);
	  	$blog_title = get_bloginfo('name');
	  	$tagline = get_bloginfo('description');
	  	echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 
	  	
	  	$url = 'http://api.selar.co/v1/products/demo1';
		$response = wp_safe_remote_get($url);

		$response_code = wp_remote_retrieve_response_code( $response );
		$json = wp_remote_retrieve_body($response);
		print_r(json_decode($json));
	  	?>


		<p><strong>Site Name:</strong> <?php echo $blog_title ?></p>
		<p><strong>Tagline:</strong> <?php echo $tagline ?></p>

		<?php echo $args['after_widget'];
	}
}

function kkd_selar_register_widget() { 
  register_widget( 'KKD_Selar_Product_Widget' );
}
add_action( 'widgets_init', 'kkd_selar_register_widget' );
