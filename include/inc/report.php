<?php 

function z_get_report_status($statuscode) {
	switch ($statuscode) {
		case 0:{
			return "未处理";
			break;
		}
		case 1:{
			return "已确认";
			break;
		}
		case 2:{
			return "未能复现";
			break;
		}
		case 3:{
			return "BUG/危害太小";
			break;
		}
		case 4:{
			return "未在处理范围内";
			break;
		}
		case 5:{
			return "重复提交";
			break;
		}
		default:{
			return "未知状态";
		}
	}
}

function z_get_report_level($code) {
	switch ($code){
		case 1:{
			return 1;
			break;
		}
		case 2:{
			return 2;
			break;
		}
		case 3:{
			return 3;
			break;
		}
		default:{
			return 0;
		}
	}
}

function z_get_report_strlevel($code) {
	switch ($code){
		case 1:{
			return "低危";
			break;
		}
		case 2:{
			return "中危";
			break;
		}
		case 3:{
			return "高危";
			break;
		}
		default:{
			return "未评级";
		}
	}
}

function z_is_canpublic($time) {
	$expiretime = (new zConfig())->getExpireTime();
	if(((get_time() - strtotime($time))/(60*60*24)) >= $expiretime)
		return TRUE;
	else 
		return FALSE;
}