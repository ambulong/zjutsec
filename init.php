<?php
if (defined ( "ZSEC_ENTRANCE" )) {
	/**
	 * Absolute path to ZSEC directory
	 */
	define ( 'ZSEC_ABSPATH', dirname ( __FILE__ ) . '/' );
	
	define ( 'ZSEC_INC', 'include/' );
	
	define ( 'ZSEC_SUBINC', 'inc/' );
	
	/**
	 * Require the configure file
	 */
	require_once (ZSEC_ABSPATH . 'config.php');
	
	/**
	 * Loads the environment and template
	 */
	require_once (ZSEC_ABSPATH . 'load.php');
	
	(new ZSEC ())->init ();
} else {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}