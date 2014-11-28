<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
z_get_header ( "我的资料" );
z_get_left ();

$detail = (new zUser())->getDetail(z_get_uid());
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
			<a href="<?php echo esc_html(z_get_register_url());?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">注册</span></a>
		</div>
<?php }?>
		<div class="main-tabs-item active">
			<a href="<?php echo esc_html(z_get_profile_url());?>"><span
				class="submit-report-icon"></span><span class="main-tabs-item-text">我的资料</span></a>
		</div>
	</div>
	<div class="main-profile">
		<div class="baseinfo pull-left">
			<form role="form" id="baseinfoform" method="POST" action="<?php echo esc_html(z_get_action_profile_url());?>">
				<div class="form-group">
					<label for="inputURL">网址</label> <input type="text"
						class="form-control" name = "url" id="inputURL" placeholder="你的个人网站" value="<?php echo esc_html($detail["url"]);?>">
				</div>
				<div class="form-group">
					<label for="inputOrg">组织</label> <input type="text"
						class="form-control" name = "org" id="inputOrg" placeholder="组织/部门/学院/学校/班级等" value="<?php echo esc_html($detail["org"]);?>">
					<p class="help-block">username@organization.</p>
				</div>
				<hr>
				<div class="form-group">
					<label for="inputPassword">输入密码</label> <input type="password"
						class="form-control" name = "password" id="inputPassword"
						placeholder="Enter password">
				</div>
				<div class="form-group">
					<label for="inputPassword2">确认密码</label> <input type="password"
						class="form-control" name = "password2" id="inputPassword2"
						placeholder="Confirm password">
					<p class="help-block">留空不修改.</p>
				</div>
				<hr>
				<div class="form-group">
					<label for="inputLabel">个人标签</label> <input type="text"
						class="form-control" name = "label" id="inputLabel" placeholder="Label" value="<?php echo esc_html($detail["label"]);?>">
				</div>
				<div class="form-group">
					<label for="inputDesc">个人简介</label>
					<textarea class="form-control" name = "desc" id="inputDesc"
						placeholder="Description"><?php echo esc_html($detail["desc"]);?></textarea>
				</div>
				<hr>
				<div class="form-group">
					<label for="inputPhone">手机</label> <input type="text"
						class="form-control" name = "phone" id="inputPhone" placeholder="长号" value="<?php echo esc_html($detail["phone"]);?>">
					<p class="help-block">我们可能联系你发送礼物.</p>
				</div>
				<div class="form-group">
					<label for="inputQQ">QQ</label> <input type="text"
						class="form-control" name = "qq" id="inputQQ" placeholder="QQ" value="<?php echo esc_html($detail["qq"]);?>">
				</div>
				<hr>
				<input type="hidden" name = "avatar" value="<?php echo esc_html($detail["avatar"]);?>"" id="inputAvatar" >
				<input type="hidden" name = "token" value="<?php echo esc_html(z_get_token());?>"" id="inputToken" >
				<button type="submit" class="btn btn-primary">保存资料</button>
			</form>
		</div>
		<div class="avatarinfo pull-left">
			<form role="form" id="uploadAvatarForm" method="POST" enctype="multipart/form-data" action="<?php echo esc_html(z_get_action_upload_url(z_get_token()));?>">
			<div class="avatar"><img src="<?php echo esc_html(z_get_avatar());?>"></div>
			<div class="form-group">
				<input type="file" name="image" id="inputFile">
				<button type="button" id="uploadAvatarBtn" class="btn btn-default btn-xs pull-right">上传</button>
				<p class="help-block">只支持png,jpg,jpeg,gif格式图片.</p>
			</div>
			</form>
		</div>
	</div>
</div>
<?php z_get_footer();?>