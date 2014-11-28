<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$current_url = get_url ();
$current_url = explode ( '?', $current_url )[0];
$page_url = z_gen_url ( "view", "detail" );
if (strlen ( $current_url ) <= strlen ( $page_url )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$sid = substr ( $current_url, strlen ( $page_url ), strlen ( $current_url ) - strlen ( $page_url ) );
$report_obj = new zReport ();
if (! $report_obj->isExistSID ( $sid )) {
	echo "report is non-existent";
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$detail = $report_obj->getDetail ( $sid, "sid" );
// var_dump($detail);
if ($detail ["canbepub"] != 1 && $detail ["uid"] != z_get_uid ()) {
	echo "你没有权限查看此报告";
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if($detail["status"] != 1 && $detail ["uid"] != z_get_uid ()) {
	echo "你没有权限查看此报告";
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if($detail ["title"] == "")
	z_get_header ( "报告：" . $detail ["ori_title"] );
else 
	z_get_header ( "报告：" . $detail ["title"] );
z_get_left ();
?>
<div class="content-main pull-left">
	<div class="main-tabs">
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_home_url());?>"><span
				class="report-list-icon"></span><span class="main-tabs-item-text">报告中心</span></a>
		</div>
<?php if(z_is_login()){?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_user_url(z_get_username()));?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">我的报告</span></a>
		</div>
<?php }?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_report_url());?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">提交报告</span></a>
		</div>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_notic_url());?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">公告</span></a>
		</div>
<?php if(!z_is_login()){?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_register_url());?>">
			<span class="submit-report-icon"></span><span class="main-tabs-item-text">注册</span>
			</a>
		</div>
<?php }?>
	</div>
	<div class="report-content">
		<div class="item title">
			<span class="head">标题：</span>
			<span class="text"><?php echo esc_html($detail["title"]);?></span>
		</div>
		<div class="item level">
			<span class="head">报告等级：</span>
			<span class="text"><?php echo esc_html(z_get_report_strlevel($detail["level"]));?></span>
		</div>
		<div class="item rank">
			<span class="head">Rank：</span>
			<span class="text"><?php echo esc_html($detail["rank"]);?></span>
		</div>
		<div class="item author">
			<span class="head">提交者：</span>
			<span class="text"><?php echo esc_html(z_get_name($detail["uid"]));?></span>
		</div>
		<div class="item time">
			<span class="head">提交时间：</span>
			<span class="text"><?php echo esc_html($detail["time"]);?></span>
		</div>
		<div class="item incharge">
			<span class="head">负责人/组织：</span>
			<span class="text"><?php echo esc_html($detail["incharge"]);?></span>
		</div>
		<div class="item tags">
			<span class="head">标签：</span>
			<span class="text"><?php echo esc_html($detail["tags"]);?></span>
		</div>
		<div class="item summary">
			<span class="head">简要描述：</span>
			<div class="text"><?php echo $detail["summary"];?></div>
		</div>
		<div class="item desc">
			<span class="head">详细描述：</span>
<?php if($detail["status"] == 1 && z_is_canpublic($detail["time"])){?>
			<div class="text"><?php echo $detail["desc"];?></div>
<?php }else{?>
			<div class="text">漏洞未公开</div>
<?php }?>
		</div>
<?php if($detail["resp"] != ""){?>
		<div class="item resp">
			<span class="head">负责人/组织回复：</span>
			<div class="text"><?php echo $detail["resp"];?></div>
		</div>
<?php }?>
<?php if($detail["note"] != "" && (z_is_login() && z_get_uid() === $detail["uid"])){?>
		<div class="item note">
			<span class="head">管理留言：</span>
			<div class="text"><?php echo $detail["note"];?></div>
		</div>
<?php }?>
	</div>
<?php if(z_is_login() && z_get_uid() === $detail["uid"]){?>
	<div class="report-ori-content">
		<div class="item title">
			<span class="head">标题：</span>
			<span class="text"><?php echo esc_html($detail["ori_title"]);?></span>
		</div>
		<div class="item rank">
			<span class="head">Rank：</span>
			<span class="text"><?php echo esc_html($detail["ori_rank"]);?></span>
		</div>
		<div class="item incharge">
			<span class="head">负责人/组织：</span>
			<span class="text"><?php echo esc_html($detail["ori_incharge"]);?></span>
		</div>
		<div class="item tags">
			<span class="head">标签：</span>
			<span class="text"><?php echo esc_html($detail["ori_tags"]);?></span>
		</div>
		<div class="item desc">
			<span class="head">描述：</span>
			<div class="text"><textarea readonly="readonly" ><?php echo esc_html($detail["ori_desc"]);?></textarea></div>
		</div>
		<div class="item comment">
			<span class="head">备注：</span>
			<div class="text"><textarea readonly="readonly" ><?php echo esc_html($detail["ori_comment"]);?></textarea></div>
		</div>
	</div>
<?php }?>
</div>
<?php z_get_footer();?>