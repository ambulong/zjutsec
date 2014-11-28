<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! z_is_login ()) {
	die ( "请先登录." );
}
if (! z_validate_token ()) {
	die ( "token is incorrect." );
}
$type = isset ( $_REQUEST ["type"] ) ? $_REQUEST ["type"] : 0; // 0.base64 1.filename

$target_dir = ZSEC_ABSPATH . "static/upimg/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if(!isset($_FILES ["image"]))
	die ( "error." );
$target_file = $target_dir . basename ( $_FILES ["image"] ["name"] );

$imageFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
if(strcmp($imageFileType, "png") == 0){
	$target_file = $target_dir . get_salt(50) . ".png";
	while(file_exists($target_file)) {
		$target_file = $target_dir . get_salt(50) . ".png";
	}
}elseif(strcmp($imageFileType, "jpeg") == 0){
	$target_file = $target_dir . get_salt(50) . ".jpeg";
	while(file_exists($target_file)) {
		$target_file = $target_dir . get_salt(50) . ".jpeg";
	}
}elseif(strcmp($imageFileType, "gif") == 0){
	$target_file = $target_dir . get_salt(50) . ".gif";
	while(file_exists($target_file)) {
		$target_file = $target_dir . get_salt(50) . ".gif";
	}
}elseif(strcmp($imageFileType, "jpg") == 0){
	$target_file = $target_dir . get_salt(50) . ".jpg";
	while(file_exists($target_file)) {
		$target_file = $target_dir . get_salt(50) . ".jpg";
	}
}else{
	die( "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
}
$imageFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
}

if ($type == 1) {
	if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		echo "./static/upimg/".basename( $target_file);
	}else{
		echo "error";
	}
} else {
	echo "data:image/{$imageFileType};base64,".base64_encode(file_get_contents($_FILES["image"]["tmp_name"]));
}