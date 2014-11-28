<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(z_is_login()) {
	header ( 'Content-Type: text/html; charset=utf-8' );
	die("你已经登录.");
}
z_get_header ( "注册" );
z_get_left ();
?>
<div class="content-main pull-left">
	<div class="main-tabs">
		<div class="main-tabs-item">
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
		<div class="main-tabs-item active">
			<a href="<?php echo esc_html(z_get_register_url());?>"><span class="submit-report-icon"></span><span
				class="main-tabs-item-text">注册</span></a>
		</div>
<?php }?>
	</div>
	<form action="<?php echo z_get_action_register_url();?>" method="POST" class="form-horizontal" role="form" style="padding-top:80px;">
            <div class="form-group">
                <label for="inputUsername" class="col-sm-3 control-label">用户名</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-sm-3 control-label">邮箱</label>
                <div class="col-sm-6">
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="邮箱">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPwd" class="col-sm-3 control-label">设置密码</label>
                <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPwd" name="password" placeholder="设置密码">
                </div>
            </div>
            <div class="form-group">
                <label for="inputRepwd" class="col-sm-3 control-label">重复密码</label>
                <div class="col-sm-6">
                <input type="password" class="form-control" id="inputRepwd" name="password2" placeholder="重复密码">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="liscence" value="1"><p class="text-muted">我已阅读并同意《精弘网络漏洞发布平台用户协议》</p>
                        </label>
                    </div>

                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-default" style="width:100%;">注册</button>
                </div>

            </div>
        </form>
</div>
<?php z_get_footer();?>