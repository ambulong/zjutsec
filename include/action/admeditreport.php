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

$id = isset ( $_POST ["id"] ) ? trim($_POST ["id"]) : "";
$status = isset ( $_POST ["status"] ) ? trim($_POST ["status"]) : 0;
$level = isset ( $_POST ["level"] ) ? trim($_POST ["level"]) : 0;
$rank = isset ( $_POST ["rank"] ) ? trim($_POST ["rank"]) : 0;
$title = isset ( $_POST ["title"] ) ? trim($_POST ["title"]) : "";
$incharge = isset ( $_POST ["incharge"] ) ? trim($_POST ["incharge"]) : "";
$tags = isset ( $_POST ["tags"] ) ? trim($_POST ["tags"]) : "";
$summary = isset ( $_POST ["summary"] ) ? trim($_POST ["summary"]) : "";
$desc = isset ( $_POST ["desc"] ) ? trim($_POST ["desc"]) : "";
$resp = isset ( $_POST ["resp"] ) ? trim($_POST ["resp"]) : "";
$note = isset ( $_POST ["note"] ) ? trim($_POST ["note"]) : "";
$canbepub = isset ( $_POST ["canbepub"] ) ? trim($_POST ["canbepub"]) : 1;

$report_obj = new zReport();
if(!$report_obj->isExistID($id)){
	die("id is incorrect.");
}
if($report_obj->update($id, $status, $level, $rank, $title, $incharge, $tags, $summary, $desc, $resp, $note, $canbepub)){
	echo "更新成功";
}else{
	echo "更新失败";
}