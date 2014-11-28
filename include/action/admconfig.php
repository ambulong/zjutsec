<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if(!z_is_login()) {
	die("请先登录.");
}
if(!z_is_admin()) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(!z_validate_token()) {
	die("token is incorrect.");
}

$name = isset ( $_POST ["name"] ) ? trim($_POST ["name"]) : "";
$url = isset ( $_POST ["url"] ) ? trim($_POST ["url"]) : "";
$label = isset ( $_POST ["label"] ) ? trim($_POST ["label"]) : "";
$time = isset ( $_POST ["expiretime"] ) ? intval($_POST ["expiretime"]) : 10;
$isAlert = isset ( $_POST ["alert"] ) ? intval($_POST ["alert"]) : 0;
$mails = isset ( $_POST ["alertmail"] ) ? trim($_POST ["alertmail"]) : "";

$config_obj = new zConfig();
$config_obj->updateAlert($isAlert);
$config_obj->updateAlertMails($mails);
$config_obj->updateExpireTime($time);
$config_obj->updateLabel($label);
$config_obj->updateName($name);
$config_obj->updateURL($url);
echo "更新成功。";