<?php
$perpage = 13;
function z_get_user_report_list($uid, $offset = 0, $rows = -1) {
	global $perpage;
	if($rows == -2)
		$rows = $perpage;
	return (new zReport())->getUserReports($uid, $offset, $rows);
}

function z_get_report_list($offset = 0, $rows = -1) {
	global $perpage;
	if($rows == -2)
		$rows = $perpage;
	return  (new zReport())->getReports($offset, $rows);
}

function z_get_pub_report_list($offset = 0, $rows = -1) {
	global $perpage;
	if($rows == -2)
		$rows = $perpage;
	return  (new zReport())->getPubReports($offset, $rows);
}