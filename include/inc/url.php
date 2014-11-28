<?php
function z_gen_url($mod, $f, $ext = "") {
	return (new zConfig())->getURL() . "/index.php/{$mod}/{$f}/{$ext}";
}

function z_get_static_url($file = "") {
	if($file != "")
		$file = "/".$file;
	return (new zConfig())->getURL() . "/static{$file}";
}

function z_get_home_url() {
	return z_gen_url("view", "main");
}

function z_get_notic_url() {
	return "http://blog.zjut.com/";
}

function z_get_action_login_url() {
	return z_gen_url("action", "login");
}

function z_get_register_url() {
	return z_gen_url("view", "register");
}

function z_get_report_url() {
	return z_gen_url("view", "report");
}

function z_get_report_detail_url($sid) {
	return z_gen_url("view", "detail", $sid);
}

function z_get_user_url($user = "") {
	return z_gen_url("view", "user", $user);
}

function z_get_logout_url() {
	return z_gen_url("action", "logout", "?token=".$_SESSION["user"]["token"]);
}

function z_get_search_url() {
	return z_gen_url("view", "search");
}

function z_get_profile_url() {
	return z_gen_url("view", "profile");
}

function z_get_action_profile_url() {
	return z_gen_url("action", "profile");
}

function z_get_action_register_url() {
	return z_gen_url("action", "register");
}

function z_get_action_report_url() {
	return z_gen_url("action", "report");
}

function z_get_action_upload_url($token="", $type=0) {
	return z_gen_url("action", "upload", "?token={$token}&type={$type}");
}

function z_get_admConfig_url() {
	return z_gen_url("view", "admConfig");
}

function z_get_action_admConfig_url() {
	return z_gen_url("action", "admConfig");
}

function z_get_admEditReport_url($sid) {
	return z_gen_url("view", "admEditReport", $sid);
}

function z_get_action_admEditReport_url() {
	return z_gen_url("action", "admEditReport");
}

function z_get_admReportList_url() {
	return z_gen_url("view", "admReportList");
}

function z_get_admUsers_url() {
	return z_gen_url("view", "admUsers");
}

function z_get_admEditUser_url() {
	return z_gen_url("view", "admEditUser");
}

function z_get_action_admEditUser_url() {
	return z_gen_url("action", "admEditUser");
}