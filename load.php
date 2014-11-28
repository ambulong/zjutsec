<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}

require_once (ZSEC_ABSPATH . ZSEC_INC . 'envchk.php');
require_once (ZSEC_ABSPATH . ZSEC_INC . 'functions.php');
require_once (ZSEC_ABSPATH . ZSEC_INC . 'autoload.php');
require_once (ZSEC_ABSPATH . 'settings.php');

zsec_debug_mode ();
zsec_check_php_mysql ();
date_default_timezone_set ( ZSEC_TIMEZONE );
if (! is_session_started ())
	session_start ();