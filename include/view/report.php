<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
if(!z_is_login()) {
	header ( 'Content-Type: text/html; charset=utf-8' );
	die("请先登录.");
}
z_get_header ( "提交报告" );
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
		<div class="main-tabs-item active">
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
	<form action="<?php echo z_get_action_report_url();?>" method="POST" class="form-horizontal" role="form" style="padding-top:40px;">
            <div class="form-group">
                <label for="inputTitle" class="col-sm-2 control-label">漏洞标题</label>
                <div class="col-sm-8">
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Title"/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDepartment" class="col-sm-2 control-label">负责人/组织</label>
                <div class="col-sm-8">
                <input type="text" name="incharge" class="form-control" id="inputDepartment" placeholder="学院/个人/部门/组织等"/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputRank" class="col-sm-2 control-label">自评Rank</label>
                <div class="col-sm-3">
                <input type="text" name="rank" class="form-control" id="inputRank" placeholder="0～20"/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputTag" class="col-sm-2 control-label">标签</label>
                <div class="col-sm-8">
                <input type="text" name="tags" class="form-control" id="inputTag" placeholder="用空格隔开（如：XSS CSRF）"/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDesc" class="col-sm-2 control-label">报告内容</label>
                <div class="col-sm-8">
                <div role="form" id="uploadImgForm" method="POST" enctype="multipart/form-data" action="<?php echo esc_html(z_get_action_upload_url(z_get_token(), 1));?>">
               		<input type="file" id="inputFile" class="pull-left">
					<button type="button" id="uploadImgBtn" class="btn btn-default btn-xs pull-left">上 传</button>
					<p class="help-block pull-right">只支持png,jpg,jpeg,gif格式图片.</p>
                </div>
                <textarea name="desc" id="inputDesc" class="form-control" rows="4" placeholder="问题描述"></textarea>
                <p class="help-block">支持HTML标签，我们可能对内容进行重新编辑.</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputComment" class="col-sm-2 control-label">备注</label>
                <div class="col-sm-8">
                <input type="text" name="comment" class="form-control" id="inputComment" placeholder="可以要求我们帮忙索要礼品等"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-7"></div>
                <div class="col-sm-3">
                	<input type="hidden" name="token" value="<?php echo z_get_token();?>">
                    <button type="submit" class="btn btn-default" style="width:100%;">提交</button>
                </div>

            </div>
        </form>
</div>
<?php z_get_footer();?>