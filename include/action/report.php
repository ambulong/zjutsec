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

$anonymous = isset ( $_POST ["anonymous"] ) ? intval($_POST ["anonymous"]) : 0;
$title = isset ( $_POST ["title"] ) ? trim($_POST ["title"]) : "";
$incharge = isset ( $_POST ["incharge"] ) ? trim($_POST ["incharge"]) : "";
$tags = isset ( $_POST ["tags"] ) ? trim($_POST ["tags"]) : "";
$desc = isset ( $_POST ["desc"] ) ? trim($_POST ["desc"]) : "";
$comment = isset ( $_POST ["comment"] ) ? trim($_POST ["comment"]) : "";
$rank = isset ( $_POST ["rank"] ) ? intval($_POST ["rank"]) : 0;

if($anonymous != 0 && $anonymous != 1){
	die("anonymous is invalid.");
}
if($title === "") {
	die("title is invalid.");
}
if($incharge === "") {
	die("incharge is invalid.");
}
if($tags === "") {
	die("tags is invalid.");
}
if($desc === "") {
	die("desc is invalid.");
}
if($rank === "" || $rank > 20 || $rank < 0) {
	die("rank is invalid.");
}
$report_obj = new zReport();
if($report_obj->isExistOriTitle($title)){
	die("已有相同标题的报告存在.");
}
if($report_obj->add(z_get_uid(), $title, $incharge, $tags, $desc, $comment, $rank, $anonymous)){
	echo "提交成功";
}else{
	die("提交失败.");
}