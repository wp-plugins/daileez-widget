<?php
/*
Plugin Name: Daileez Widget
Plugin URI: http://wordpress.org/extend/plugins/daileez-widget
Description: Display icon statuses from your Daileez.com online diary in the sidebar of your blog
Version: 1.0
Author: Daileez team
Author URI: http://www.daileez.com/
*/  

class Daileez_Widget extends WP_Widget {

	function Daileez_Widget() {
		$widget_ops = array('classname' => 'widget_daileez', 'description' => __( "Display icon statuses from your Daileez.com online diary in the sidebar of your blog") );
		$this->WP_Widget('daileez', __('Daileez'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$account = urlencode( $instance['account'] );
		if ( empty($account) ) return;
		$title = apply_filters('widget_title', $instance['title']);
		
		$html .= '<li>';
		if ( !empty($title) ) $html .= '<h2 style="margin-bottom: 5px;">'.$title.'</h2>';
		$html .= '<div style="text-align: center;">';
		$html .= '<iframe id="myDiaryDaileez" src="http://plugins.daileez.com/?username='.$account.'" scrolling="no" frameborder="0" style="border:none; overflow: hidden; width:150px; height:260px;" allowTransparency="true"></iframe>';
		$html .= '</div>';
		$html .= '</li>';	
		
		$widgetIcons = $html;
		
		echo $widgetIcons;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['account'] = strip_tags(stripslashes($new_instance['account']));
		$co = array('http://', '.daileez.com/');
		$zac = array('','');
		$instance['account'] = str_replace($co, $zac, $instance['account']);
		$instance['account'] = str_replace('/', '', $instance['account']);
		$instance['account'] = str_replace('@', '', $instance['account']);
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array('account' => '', 'title' => '') );

		$account = esc_attr($instance['account']);
		$title = esc_attr($instance['title']);

		echo '<p><label for="' . $this->get_field_id('title') . '">' . __('Title:') . '
		<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
		</label></p>
		<p><label for="' . $this->get_field_id('account') . '">' . __('Daileez username:') . '
		<input class="widefat" id="' . $this->get_field_id('account') . '" name="' . $this->get_field_name('account') . '" type="text" value="' . $account . '" />
		</label></p>';

	}

}

add_action( 'widgets_init', 'daileez_widget_init' );
function daileez_widget_init() {
	register_widget('Daileez_Widget');
}
