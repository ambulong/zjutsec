
<div class="content-left pull-left">
<?php if(z_is_login()) {?>
<?php 
$user_obj = new zUser();
$detail = $user_obj->getDetail($_SESSION["user"]["id"]);
?>
	<div class="userinfo">
		<div class="avatar">
			<img src="<?php echo z_get_avatar();?>">
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
			Report：<span><?php echo z_get_report_num();?></span>
		</div>
		<div class="rank">
			Rank：<span><?php echo z_get_rank();?></span>
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
<?php }else{?>
	<div class="userlogin">
		<form role="form" method="post" action="<?php echo esc_html(z_get_action_login_url());?>">
			<div class="form-group">
				<label for="InputEmail">邮箱</label> <input type="email"
					class="form-control" name="email" id="InputEmail" placeholder="Enter email">
			</div>
			<div class="form-group">
				<label for="InputPassword">密码</label> <input type="password"
					class="form-control" name="password" id="InputPassword" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-primary btn-block">登录</button>
			<a href="<?php echo esc_html(z_get_register_url());?>" type="button" class="btn btn-default btn-block">注册</a>
			<hr>
		</form>
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
<?php }?>
</div>