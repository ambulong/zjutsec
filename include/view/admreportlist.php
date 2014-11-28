<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(!z_is_login()){
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(!z_is_admin()){
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}


z_get_header ( "报告管理" );
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
<?php 
$reportList = z_get_report_list();
//var_dump($reportList);
foreach ($reportList as $reportListItem){
?>
	<div class="my-report-item">
		<div class="report-info pull-right">
			<span><?php echo esc_html(z_get_report_status($reportListItem["status"]))?></span>
		</div>
		<div class="report-title">
			<a href="<?php echo esc_html(z_get_admEditReport_url($reportListItem["sid"]));?>"><div class="level lv<?php echo esc_html(z_get_report_level($reportListItem["level"]));?>"></div><?php echo esc_html($reportListItem["ori_title"]);?></a>
		</div>
	</div>
<?php }?>
</div>
<?php z_get_footer();?>