<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo isset($title)?esc_html($title):"";?> - <?php echo esc_html(z_get_sitename());?></title>
<script src="<?php echo esc_html(z_get_static_url());?>/js/jquery-1.11.0.min.js"></script>
<script
	src="<?php echo esc_html(z_get_static_url());?>/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link
	href='http://fonts.googleapis.com/css?family=Roboto:500,400,900italic,100,300,400,700,100italic,300italic,400'
	rel='stylesheet' type='text/css'>

<link rel="stylesheet"
	href="<?php echo esc_html(z_get_static_url());?>/css/custum.css">
<script src="<?php echo esc_html(z_get_static_url());?>/js/custum.js"></script>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>
<div class="nav-top">
	<div class="nav-content">
		<div class="nav-item nav-icon pull-left">
			<span class="icon"></span>
			<div class="nav-panel">
			<?php if(z_is_login()){?>
			<ul>
				<li><a href="<?php echo esc_html(z_get_home_url());?>">我的报告</a></li>
				<li><a href="<?php echo esc_html(z_get_report_url());?>">提交报告</a></li>
				<li><a href="<?php echo esc_html(z_get_profile_url());?>">修改资料</a></li>
				<li><a href="<?php echo esc_html(z_get_logout_url());?>">退出</a></li>
			</ul>
			<?php if(z_is_admin()){?>
			<hr>
			<ul>
				<li><a href="<?php echo esc_html(z_get_admConfig_url());?>">网站配置</a></li>
				<li><a href="<?php echo esc_html(z_get_admReportList_url());?>">报告管理</a></li>
				<li><a href="<?php echo esc_html(z_get_admUsers_url());?>">用户管理</a></li>
			</ul>
			<?php }?>
			<?php }else{?>
			<ul>
				<li><a href="<?php echo esc_html(z_get_register_url());?>">注册</a></li>
			</ul>
			<?php }?>
			<hr>
			<ul>
				<li><a href="<?php echo esc_html(z_get_home_url());?>">报告中心</a></li>
				<li><a href="<?php echo esc_html(z_get_notic_url());?>">公告</a></li>
			</ul>
			<?php /*
			<ul>
				<li><a href="#">用户列表</a></li>
				<li><a href="#">用户排名</a></li>
			</ul>
			<hr>
			<ul>
				<li><a href="#">已公开</a></li>
				<li><a href="#">高危</a></li>
				<li><a href="#">中危</a></li>
				<li><a href="#">低危</a></li>
			</ul>
			<hr>
			<ul>
				<li><a href="#">管理员管理</a></li>
				<li><a href="#">用户管理</a></li>
			</ul>
			<hr>
			<ul>
				<li><a href="#">未处理</a></li>
				<li><a href="#">已公布</a></li>
				<li><a href="#">已确认</a></li>
			</ul>
			<hr>
			<ul>
				<li><a href="#">未复现</a></li>
				<li><a href="#">BUG/危害太小</a></li>
				<li><a href="#">超出处理范围</a></li>
				<li><a href="#">重复</a></li>
			</ul>
			*/ ?>
		</div>
		</div>
		<div class="nav-item nav-title pull-left"><a href="<?php echo z_get_home_url();?>"><?php echo esc_html(z_get_sitename());?></a></div>
		<div class="nav-item nav-search pull-left">
			<form class="navbar-form" role="search" method="GET" action="<?php echo esc_html(z_get_search_url());?>">
				<div class="form-group">
					<input type="text" name="q" class="form-control"
						placeholder="Search">
					<button type="submit" class="btn btn-default">&nbsp;</button>
				</div>

			</form>
		</div>
		<div class="nav-item nav-user pull-right">
			<img src="<?php echo esc_html(z_get_avatar());?>">
			<span class="icon"></span>
			<div class="nav-user-panel">
<?php if(!z_is_login()){?>
			<ul>
				<li><a href="<?php echo esc_html(z_get_register_url());?>">注册</a></li>
			</ul>
<?php }else{?>
			<ul>
				<li><a href="<?php echo esc_html(z_get_profile_url());?>">资料</a></li>
				<li><a href="<?php echo esc_html(z_get_logout_url());?>">退出</a></li>
			</ul>
<?php }?>
			</div>
		</div>
	</div>
</div>

<div class="content">