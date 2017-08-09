<?php
/*
Plugin Name: Selar.co Widget
Plugin URI: https://selar.co/plugins
Description: Embed a Selar product/profile on your website.
Author: Kendysond
Version: 1.0
Author URI: https://github.com/kendysond
*/

define( 'KDD_SELAR_WIDGET_MAIN_FILE', __FILE__ );
define( 'KDD_SELAR_WIDGET_VERSION', '1.0' );
define( 'KDD_SELAR_WIDGET_ENDPOINT', 'http://api.selar.co/v1/' );

class KKD_Selar_Product_Widget extends WP_Widget {
  	public function __construct() {
	    $widget_options = array( 
	      'classname' => 'selar_product_widget',
	      'description' => 'Selar Product Widget',
	    );
	    parent::__construct( 'selar_widget', 'Selar Product Widget', $widget_options );
  	}
  	public function form( $instance ) {
		$code = ! empty( $instance['code'] ) ? $instance['code'] : ''; ?>
		<p>
		    <label for="<?php echo $this->get_field_id( 'code' ); ?>">Product Code:</label>
		    <input type="text" id="<?php echo $this->get_field_id( 'code' ); ?>" name="<?php echo $this->get_field_name( 'code' ); ?>" value="<?php echo esc_attr( $code ); ?>" />
		</p>
		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'code' ] = strip_tags( $new_instance[ 'code' ] );
		return $instance;
	}
  	public function widget( $args, $instance ) {
  		echo $args['before_widget'] . $args['before_title'] . $args['after_title']; 
		$code = $instance[ 'code' ];
	  	$url = KDD_SELAR_WIDGET_ENDPOINT.'products/'.$code;
	  	
		$response = wp_safe_remote_get($url);
		$json = wp_remote_retrieve_body($response);
		$response_object = json_decode($json);
		$response_code = wp_remote_retrieve_response_code($response);
		if ($response_code == 200) { ?>
			<p><strong><?php echo $response_object->name; ?></strong></p>
			<p><img src="<?php echo $response_object->image; ?>"><strong></strong></p>
			<p><strong> <a href="<?php echo $response_object->url; ?>" target="_blank"><?php echo $response_object->url; ?></a></strong></p>


		<?php }else{ ?>

			<p><strong><?php echo $response_object->message; ?></strong></p>
		
		<?php } echo $args['after_widget'];
	}
}

function kkd_selar_register_widget() { 
  register_widget( 'KKD_Selar_Product_Widget' );
  // register_widget( 'KKD_Selar_Merchant_Widget' );
}
add_action( 'widgets_init', 'kkd_selar_register_widget' );
