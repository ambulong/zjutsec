<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(!z_is_login()) {
	die("请先登录.");
}
if(z_validate_token()) {
	z_logout();
	gotourl(z_get_home_url());
}else {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "Token is incorrect." );
}