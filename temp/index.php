<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>首页 - 精弘网络安全实验室</title>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link
	href='http://fonts.googleapis.com/css?family=Roboto:500,400,900italic,100,300,400,700,100italic,300italic,400'
	rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="./custum.css">
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>
<div class="nav-top">
	<div class="nav-content">
		<div class="nav-item nav-icon pull-left">
			<span class="icon"></span>
		</div>
		<div class="nav-item nav-title pull-left">ZJUT SEC</div>
		<div class="nav-item nav-search pull-left">
			<form class="navbar-form" role="search" method="GET" action="/search">
				<div class="form-group">
					<input type="text" name="search-text" class="form-control"
						placeholder="Search">
					<button type="submit" class="btn btn-default">&nbsp;</button>
				</div>

			</form>
		</div>
		<div class="nav-item nav-user pull-right">
			<img src="./User-Login-128.png"> <span class="icon"></span>
		</div>
	</div>
</div>

<div class="content">
	<div class="content-left pull-left">
		<div class="userinfo">
			<div class="avatar">
				<img src="User-Login-128.png">
			</div>
			<div class="username">Ambulong</div>
			<div class="organise">@ZJUT Labs</div>
			<div class="ulabel">精弘网络安全实验室</div>
			<hr>
			<div class="link">
				<a href="#">https://github.com/Ambulong</a>
			</div>
			<div class="email">
				<a href="#">zeng.ambulong@gmail.com</a>
			</div>
			<div class="amount">
				Report：<span>100</span>
			</div>
			<div class="rank">
				Rank：<span>65490</span>
			</div>
			<br>
			<hr>

		</div>
		<div class="tags pull-left">
			<span class="tags-head">TAGS</span> <span class="tags-item"><a
				href="#">XSS</a></span> <span class="tags-item"><a href="#">SQL注入</a></span>
			<span class="tags-item"><a href="#">命令执行</a></span> <span
				class="tags-item"><a href="#">APT</a></span> <span class="tags-item"><a
				href="#">敏感信息泄露</a></span> <span class="tags-item"><a href="#">白盒测试</a></span>
			<span class="tags-item"><a href="#">安全意识不足</a></span> <span
				class="tags-item"><a href="#">CSRF</a></span> <span
				class="tags-item"><a href="#">逻辑错误</a></span> <span
				class="tags-item"><a href="#">任意文件下载</a></span> <span
				class="tags-item"><a href="#">代码执行</a></span> <span
				class="tags-item"><a href="#">文件包含</a></span> <span
				class="tags-item"><a href="#">配置错误</a></span> <span
				class="tags-item"><a href="#">后台弱口令</a></span> <span
				class="tags-item"><a href="#">入侵事件</a></span> <span
				class="tags-more"><a href="#">view more</a></span>
		</div>
	</div>

	<div class="content-main pull-left">
		<!-- 		<div class="submit-report"> -->
		<!-- 			<div class="submit-report-head">提交报告</div> -->
		<!-- 			<form class="report-form" role="search" method="POST" action="/submit"> -->
		<!-- 				<div class="form-group"> -->
		<!-- 					<input type="text" name="report-title" class="form-control" -->
		<!-- 						placeholder="漏洞/缺陷标题"> -->
		<!-- 					<button type="buttn" class="btn btn-default" title="Report Next"></button> -->
		<!-- 				</div> -->
		<!-- 			</form> -->
		<!-- 		</div> -->
		<div class="main-tabs">
			<div class="main-tabs-item active">
				<span class="report-list-icon"></span><span
					class="main-tabs-item-text">报告中心</span>
			</div>
			<div class="main-tabs-item">
				<span class="my-report-icon"></span><span
					class="main-tabs-item-text">他/她的报告</span>
			</div>
			<div class="main-tabs-item">
				<span class="submit-report-icon"></span><span
					class="main-tabs-item-text">提交报告</span>
			</div>
			<div class="main-tabs-item"><?php //跳转到安全实验室blog公告分类?>
				<span class="submit-report-icon"></span><span
					class="main-tabs-item-text">公告</span>
			</div>
			<div class="main-tabs-item">
				<span class="submit-report-icon"></span><span
					class="main-tabs-item-text">登录</span>
			</div>
		</div>
		<div class="report-list-item">
			<div class="user-avatar">
				<img src="./u4019719-3.jpg">
			</div>
			<div class="user">
				<a href="#"><span class="name">Ambulong</span></a>@ <a href="#"><span
					class="org">ZJUT Labs</span></a>| <span class="time">1min ago</span>
			</div>
			<div class="report-title">
				<a href="#"><div class="level"></div>教师数据库后台弱口令，可获取该校所有教师数据资料</a>
			</div>
		</div>
		<div class="report-list-item">
			<div class="user-avatar">
				<img src="./p8404456.jpg">
			</div>
			<div class="user">
				<a href="#"><span class="name">iDalek</span></a>@ <a href="#"><span
					class="org">ZJUT Labs</span></a>| <span class="time">1min ago</span>
			</div>
			<div class="report-title">
				<a href="#"><div class="level lv1"></div>浙江工业大学内网私有云服务Web管理存在弱口令</a>
			</div>
		</div>
		<div class="my-report-item">
			<div class="report-title">
				<a href="#"><div class="level lv2"></div>浙江工业大学S2漏洞导致全校院系沦陷已提权</a>
			</div>
		</div>
		<div class="my-report-item">
			<div class="report-title">
				<a href="#"><div class="level lv3"></div>浙江工业大学公寓管理系统漏洞可导致信息被修改</a>
			</div>
		</div>
		<div class="my-report-item">
			<div class="report-title">
				<a href="#"><div class="level"></div>浙江工业大学大数据可管理学籍助学金</a>
			</div>
		</div>
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
	</div>
</div>
</body>
</html>
