<?php

	// Cargo el acceso a bd de Wordpress
	$wp_path = $_SERVER["DOCUMENT_ROOT"];
	if( file_exists($wp_path . '/wp-config.php') ) 
	{
		include_once( $wp_path.'/wp-config.php' );
		include_once( $wp_path.'/wp-includes/wp-db.php' );
	}
	else
	{
		$wp_plugin_path_modified = explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ), -3 );
		$wp_path = implode( DIRECTORY_SEPARATOR, $wp_plugin_path_modified );
		include_once( $wp_path . '/wp-config.php' );
		include_once( $wp_path . '/wp-includes/wp-db.php' );
	}
	if( !file_exists( $wp_path . '/wp-config.php' ) )
		exit;
	if( !$wpdb )
		$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST ); ;

?>