<?php
/*
Plugin Name: AMP Migrator
Plugin URI: https://ampforwp.com/
Description: Easiest way to move from other AMP plugins
Version: 0.1
Author: Mohammed Kaludi
Author URI: https://ampforwp.com/
Donate link: https://www.paypal.me/Kaludi/25
License: GPL2+
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Redirection for Homepage and Archive Pages when Turned Off from options panel
function ampforwp_better_amp_migration() {

	if ( class_exists('Better_AMP') ){
		return;
	}

  	if ( function_exists('ampforwp_is_amp_endpoint') && ampforwp_is_amp_endpoint() ||  function_exists('is_amp_endpoint') && is_amp_endpoint() ) {
		global $wp;
		$redirection_location  =  add_query_arg( '', '', home_url( $wp->request ) );
		$redirection_location  =  trailingslashit($redirection_location );

		// Default url
		$final_url = home_url( $wp->request );

		$request =  $wp->request ;
		$request_exploded = explode('/', $request);
		
		if ( $request_exploded[0] === 'amp' && $request_exploded[1] && $request_exploded[1] != 'page') {
			
			unset($request_exploded[0]);

			$final_url 	= implode('/', $request_exploded);
			$final_url 	= home_url( $final_url );
			if ( function_exists('ampforwp_url_controller') ) {
				$final_url 	= ampforwp_url_controller( $final_url );
			} else {
				$final_url 	= trailingslashit( $final_url ) . 'amp';
			}
				
			wp_safe_redirect( $final_url );
			exit;
		}
	}
}

add_action( 'template_redirect', 'ampforwp_better_amp_migration', 5 );