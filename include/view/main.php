<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
z_get_header ( "首页" );
z_get_left ();
?>
<div class="content-main pull-left">
	<div class="main-tabs">
		<div class="main-tabs-item active">
			<a href="<?php echo esc_html(z_get_home_url());?>"><span class="report-list-icon"></span><span
				class="main-tabs-item-text">报告中心</span></a>
		</div>
<?php if(z_is_login()){?>
		<div class="main-tabs-item">
			<a href="<?php echo esc_html(z_get_user_url(z_get_username()));?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">我的报告</span></a>
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
			<a href="<?php echo esc_html(z_get_register_url());?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">注册</span></a>
		</div>
<?php }?>
	</div>
<?php 
$pubReportList = z_get_pub_report_list();
foreach ($pubReportList as $pubReportListItem){
$title = ($pubReportListItem["title"] != "")?$pubReportListItem["title"]:$pubReportListItem["ori_title"];
$time = $pubReportListItem["time"];
$userDetail = (new zUser())->getDetail($pubReportListItem["uid"]);
$uavatar = z_get_avatar($pubReportListItem["uid"]);
$uname = $userDetail["username"];
$uorg = ($userDetail["org"]!="")?$userDetail["org"]:"*";
?>
	<div class="report-list-item">
		<div class="user-avatar">
			<img src="<?php echo esc_html($uavatar);?>">
		</div>
		<div class="user">
			<a href="<?php echo esc_html(z_get_user_url($uname));?>"><span class="name"><?php echo esc_html($uname);?></span></a>@ <a href="#"><span
				class="org"><?php echo esc_html($uorg);?></span></a> | <span class="time"><?php echo $time;?></span>
		</div>
		<div class="report-title">
			<a href="<?php echo esc_html(z_get_report_detail_url($pubReportListItem["sid"]));?>"><div class="level lv<?php echo esc_html($pubReportListItem["level"]);?>"></div><?php echo esc_html($title);?></a>
		</div>
	</div>
<?php }?>
	<?php /*
	<div class="page-nav">
		<nav>
			<ul class="pagination pull-right">
				<li><a href="#">«</a></li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">»</a></li>
			</ul>
		</nav>
	</div>
	*/ ?>
</div>
<?php z_get_footer();?>