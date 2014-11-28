<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$current_url = strtolower ( get_url () );
$current_url = explode ( '?', $current_url )[0];
$page_url = strtolower ( z_gen_url ( "view", "user" ) );
if (strlen ( $current_url ) <= strlen ( $page_url )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$username = urldecode(substr ( $current_url, strlen ( $page_url ), strlen ( $current_url ) - strlen ( $page_url ) ));

$user_obj = new zUser ();
if (! $user_obj->isExistName ( $username )) {
	echo "user is non-existent";
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
$detail = $user_obj->getDetail ( $username, "username" );
z_get_header ( $detail ["username"] . "的报告" );
?>
<div class="content-left pull-left">
	<div class="userinfo">
		<div class="avatar">
			<img src="<?php echo esc_html(z_get_avatar($detail["id"]));?>">
		</div>
		<div class="username"><?php echo esc_html($detail["username"]);?></div>
		<div class="organise">@<?php echo esc_html(($detail["org"] != "")?$detail["org"]:"*");?></div>
		<div class="ulabel"><?php echo esc_html(($detail["label"] != "")?$detail["label"]:"none");?></div>
		<hr>
		<div class="link">
			<a target="_blank" href="<?php echo esc_html(($detail["url"] != "")?$detail["url"]:z_get_user_url($detail["username"]));?>"><?php echo esc_html(($detail["url"] != "")?$detail["url"]:z_get_user_url($detail["username"]));?></a>
		</div>
		<div class="email">
			<a href="mailto:<?php echo esc_html(($detail["email"] != "")?$detail["email"]:"none");?>"><?php echo esc_html(($detail["email"] != "")?$detail["email"]:"none");?></a>
		</div>
		<div class="amount">
			Report：<span><?php echo esc_html(z_get_report_num($detail["id"]));?></span>
		</div>
		<div class="rank">
			Rank：<span><?php echo esc_html(z_get_rank($detail["id"]));?></span>
		</div>
		<br>
		<hr>

	</div>
	<?php /*
	<div class="tags pull-left">
		<span class="tags-head">TAGS</span> <span class="tags-item"><a
			href="#">XSS</a></span> <span class="tags-item"><a href="#">SQL注入</a></span>
		<span class="tags-item"><a href="#">命令执行</a></span> <span
			class="tags-item"><a href="#">APT</a></span> <span class="tags-item"><a
			href="#">敏感信息泄露</a></span> <span class="tags-item"><a href="#">白盒测试</a></span>
		<span class="tags-item"><a href="#">安全意识不足</a></span> <span
			class="tags-item"><a href="#">CSRF</a></span> <span class="tags-item"><a
			href="#">逻辑错误</a></span> <span class="tags-item"><a href="#">任意文件下载</a></span>
		<span class="tags-item"><a href="#">代码执行</a></span> <span
			class="tags-item"><a href="#">文件包含</a></span> <span class="tags-item"><a
			href="#">配置错误</a></span> <span class="tags-item"><a href="#">后台弱口令</a></span>
		<span class="tags-item"><a href="#">入侵事件</a></span> <span
			class="tags-more"><a href="#">view more</a></span>
	</div>
	*/?>
</div>
<div class="content-main pull-left">
	<div class="main-tabs">
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_home_url());?>"><span
				class="report-list-icon"></span><span class="main-tabs-item-text">报告中心</span></a>
		</div>
<?php if(z_is_login()){?>
		<div class="main-tabs-item <?php if(strcasecmp(z_get_username(), $username) === 0 ) echo "active";?>">
			<a href="<?php echo esc_html(z_get_user_url(z_get_username()));?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">我的报告</span></a>
		</div>
<?php }?>
<?php if(strcasecmp(z_get_username(), $username) != 0 ){?>
		<div class="main-tabs-item active">
			<a href="<?php echo esc_html(z_get_user_url($detail["username"])); ?>"><span class="report-list-icon"></span><span
				class="main-tabs-item-text">他/她的报告</span></a>
		</div>
<?php }?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_report_url());?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">提交报告</span></a>
		</div>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_notic_url());?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">公告</span></a>
		</div>
<?php if(!z_is_login()){?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_register_url());?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">注册</span></a>
		</div>
<?php }?>
	</div>
<?php 
$reportList = z_get_user_report_list($detail["id"]);
//var_dump($reportList);
foreach ($reportList as $reportListItem){
?>
	<?php if(z_is_login() && strcasecmp(z_get_username(), $username) === 0){?>
	<div class="my-report-item">
		<div class="report-info pull-right">
			<span><?php echo esc_html(z_get_report_status($reportListItem["status"]))?></span>
		</div>
		<div class="report-title">
			<a href="<?php echo esc_html(z_get_report_detail_url($reportListItem["sid"]));?>"><div class="level lv<?php echo z_get_report_level($reportListItem["level"]);?>"></div><?php echo esc_html($reportListItem["ori_title"]);?></a>
		</div>
	</div>
	<?php
	 }else{
	if($reportListItem["status"] == 1 && $reportListItem["canbepub"] == 1){
	?>
	<div class="my-report-item">
		<div class="report-title">
			<a href="<?php echo esc_html(z_get_report_detail_url($reportListItem["sid"]));?>"><div class="level lv<?php echo z_get_report_level($reportListItem["level"]);?>"></div><?php echo esc_html($reportListItem["ori_title"]);?></a>
		</div>
	</div>
	<?php }}?>
<?php }?>
</div>
<?php z_get_footer();?>