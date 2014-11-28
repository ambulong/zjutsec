<?php
/**
 * 登录
 */
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$email = isset ( $_POST ['email'] ) ? $_POST ['email'] : "";
$password = isset ( $_POST ['password'] ) ? $_POST ['password'] : "";
$user = new zUser();
if (! $user->validatePassword($email, $password)) {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "The username or password you input is incorrect." );
}
if ($user->login($email)) {
	gotourl(z_get_home_url());
} else {
	header ( 'Content-Type: text/plain; charset=utf-8' );
	die ( "Unknow error occured." );
}