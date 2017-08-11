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
define( 'KDD_SELAR_WIDGET_ENDPOINT', 'https://selar.co/' );

class KKD_Selar_Product_Widget extends WP_Widget {
  	public function __construct() {
	    $widget_options = array( 
	      'classname' => 'selar_product_widget',
	      'description' => 'Selar Product Widget',
	    );
	    parent::__construct( 'selar_widget', 'Selar Product Widget', $widget_options );
  	}
  	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : ''; 
		$code = ! empty( $instance['code'] ) ? $instance['code'] : ''; 
		$affiliate = ! empty( $instance['affiliate'] ) ? $instance['affiliate'] : ''; ?>
		<p>
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
		    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'code' ); ?>">Product Code:</label>
		    <input type="text" id="<?php echo $this->get_field_id( 'code' ); ?>" name="<?php echo $this->get_field_name( 'code' ); ?>" value="<?php echo esc_attr( $code ); ?>" />
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id( 'affiliate' ); ?>">Affiliate Code:</label>
		    <input type="text" id="<?php echo $this->get_field_id( 'affiliate' ); ?>" name="<?php echo $this->get_field_name( 'affiliate' ); ?>" value="<?php echo esc_attr( $affiliate ); ?>" />
		</p>
		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'code' ] = strip_tags( $new_instance[ 'code' ] );
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'affiliate' ] = strip_tags( $new_instance[ 'affiliate' ] );
		return $instance;
	}
  	public function widget( $args, $instance ) {
  		echo $args['before_widget'] . $args['before_title'] . $instance[ 'title' ] . $args['after_title']; 
		$code = $instance[ 'code' ];
		$affiliate = $instance[ 'affiliate' ];
	 	?>
	 	<script  src="<?php echo KDD_SELAR_WIDGET_ENDPOINT; ?>widget/widget.min.js" product-code="<?php echo $code; ?>" affiliate-code="<?php echo $affiliate; ?>" data-type="product"></script>
		<br>
		<?php echo $args['after_widget'].'<br>';
	}
}

function kkd_selar_register_widget() { 
  register_widget( 'KKD_Selar_Product_Widget' );
}
add_action( 'widgets_init', 'kkd_selar_register_widget' );
