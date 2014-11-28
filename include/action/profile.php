<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if(!z_is_login()) {
	die("请先登录.");
}
if(!z_validate_token()) {
	die("token is incorrect.");
}

$avatar = isset ( $_POST ["avatar"] ) ? trim($_POST ["avatar"]) : "";
$password = isset ( $_POST ["password"] ) ? $_POST ["password"] : "";
$password2 = isset ( $_POST ["password2"] ) ? $_POST ["password2"] : "";
$label = isset ( $_POST ["label"] ) ? trim($_POST ["label"]) : "";
$desc = isset ( $_POST ["desc"] ) ? trim($_POST ["desc"]) : "";
$url = isset ( $_POST ["url"] ) ? trim($_POST ["url"]) : "";
$org = isset ( $_POST ["org"] ) ? trim($_POST ["org"]) : "";
$phone = isset ( $_POST ["phone"] ) ? trim($_POST ["phone"]) : "";
$qq = isset ( $_POST ["qq"] ) ? trim($_POST ["qq"]) : "";
if(strcasecmp($password, $password2) != 0) {
	die ( "两次输入密码不同." );
}
if(strlen($password) < 6 && $password != "") {
	die ( "密码不能小于6位." );
}

$user_obj = new zUser();
$uid = z_get_uid();

$user_obj->updateAvatar($avatar, $uid);
$user_obj->updateDesc($desc, $uid);
$user_obj->updateLabel($label, $uid);
$user_obj->updateOrg($org, $uid);
if($password != "")
	$user_obj->updatePassword($password, $uid);
$user_obj->updatePhone($phone, $uid);
$user_obj->updateQQ($qq, $uid);
$user_obj->updateURL($url, $uid);
echo "更新成功。";