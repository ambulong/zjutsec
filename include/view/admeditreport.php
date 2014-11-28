<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if (! z_is_login ()) {
	die ( "请先登录." );
}
if (! z_is_admin ()) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}

$current_url = get_url ();
$current_url = explode ( '?', $current_url )[0];
$page_url = z_gen_url ( "view", "admEditReport" );
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

if ($detail ["title"] == "")
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
			<a href="<?php echo esc_html(z_get_register_url());?>"> <span
				class="submit-report-icon"></span><span class="main-tabs-item-text">注册</span>
			</a>
		</div>
<?php }?>
	</div>
	<form action="<?php echo z_get_action_admEditReport_url();?>"
		method="POST" class="form-horizontal" role="form"
		style="padding-top: 40px;">
		<div class="form-group">
			<label for="inputTitle" class="col-sm-2 control-label">漏洞标题</label>
			<div class="col-sm-8">
				<input type="text" name="title" class="form-control" id="inputTitle"
					placeholder="Title" value="<?php echo esc_html($detail ["title"]);?>">
			</div>
		</div>
		<div class="form-group">
			<label for="inputDepartment" class="col-sm-2 control-label">负责人/组织</label>
			<div class="col-sm-8">
				<input type="text" name="incharge" class="form-control"
					id="inputDepartment" placeholder="学院/个人/部门/组织等"  value="<?php echo esc_html($detail ["incharge"]);?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputLevel" class="col-sm-2 control-label">Level</label>
			<div class="col-sm-3">
				<input type="text" name="level" class="form-control" id="inputLevel"
					placeholder="0～3"  value="<?php echo esc_html($detail ["level"]);?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputRank" class="col-sm-2 control-label">Rank</label>
			<div class="col-sm-3">
				<input type="text" name="rank" class="form-control" id="inputRank"
					placeholder="0～20"  value="<?php echo esc_html($detail ["rank"]);?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputCanbupub" class="col-sm-2 control-label">公开</label>
			<div class="col-sm-9">
				<div class="checkbox">
					<label> <input type="checkbox" name="canbepub" value="0" <?php echo ($detail ["canbepub"] == 0)?'checked="checked"':"";?>>
					<p class="text-muted">禁止</p>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputStatus" class="col-sm-2 control-label">状态</label>
			<div class="col-sm-9">
				<label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio1" value="0" <?php echo ($detail ["status"] == 0)?'checked="checked"':"";?>> 未处理
				</label> <label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio2" value="1" <?php echo ($detail ["status"] == 1)?'checked="checked"':"";?>> 已确认
				</label> <label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio3" value="2" <?php echo ($detail ["status"] == 2)?'checked="checked"':"";?>> 未能复现
				</label><label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio4" value="3" <?php echo ($detail ["status"] == 3)?'checked="checked"':"";?>> BUG/危害太小
				</label><label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio5" value="4" <?php echo ($detail ["status"] == 4)?'checked="checked"':"";?>> 未在处理范围内
				</label><label class="radio-inline"> <input type="radio"
					name="status" id="inlineRadio6" value="5" <?php echo ($detail ["status"] == 5)?'checked="checked"':"";?>> 重复提交
				</label>

			</div>
		</div>
		<div class="form-group">
			<label for="inputTag" class="col-sm-2 control-label">标签</label>
			<div class="col-sm-8">
				<input type="text" name="tags" class="form-control" id="inputTag"
					placeholder="用空格隔开（如：XSS CSRF）"   value="<?php echo esc_html($detail ["tags"]);?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputSummary" class="col-sm-2 control-label">报告摘要</label>
			<div class="col-sm-8">
				<textarea name="summary" class="form-control" id="inputSummary"
					rows="4" placeholder="摘要"><?php echo esc_html($detail ["summary"]);?></textarea>
				<p class="help-block">支持HTML标签</p>
			</div>
		</div>
		<div class="form-group">
			<label for="inputDesc" class="col-sm-2 control-label">报告内容</label>
			<div class="col-sm-8">
				<div role="form" id="uploadImgForm" method="POST"
					enctype="multipart/form-data"
					action="<?php echo esc_html(z_get_action_upload_url(z_get_token(), 1));?>">
					<input type="file" id="inputFile" class="pull-left">
					<button type="button" id="uploadImgBtn"
						class="btn btn-default btn-xs pull-left">上 传</button>
					<p class="help-block pull-right">只支持png,jpg,jpeg,gif格式图片.</p>
				</div>
				<textarea name="desc" class="form-control" id="inputDesc" rows="4"
					placeholder="问题描述"><?php echo esc_html($detail ["desc"]);?></textarea>
				<p class="help-block">支持HTML标签</p>
			</div>
		</div>
		<div class="form-group">
			<label for="inputNote" class="col-sm-2 control-label">管理留言</label>
			<div class="col-sm-8">
				<input type="text" name="note" class="form-control" id="inputNote"
					placeholder="只有提交者可见" value="<?php echo esc_html($detail ["note"]);?>"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-7"></div>
			<div class="col-sm-3">
				<input type="hidden" name="id"
					value="<?php echo esc_html($detail ["id"]);?>"> <input
					type="hidden" name="token" value="<?php echo z_get_token();?>">
				<button type="submit" class="btn btn-default" style="width: 100%;">提交</button>
			</div>

		</div>
	</form>
	<div class="report-ori-content">
		<div class="item title">
			<span class="head">标题：</span> <span class="text"><?php echo esc_html($detail["ori_title"]);?></span>
		</div>
		<div class="item author">
			<span class="head">提交者：</span> <span class="text"><?php echo esc_html(z_get_name($detail["uid"]));?></span>
		</div>
		<div class="item time">
			<span class="head">提交时间：</span> <span class="text"><?php echo esc_html($detail["time"]);?></span>
		</div>
		<div class="item rank">
			<span class="head">Rank：</span> <span class="text"><?php echo esc_html($detail["ori_rank"]);?></span>
		</div>
		<div class="item incharge">
			<span class="head">负责人/组织：</span> <span class="text"><?php echo esc_html($detail["ori_incharge"]);?></span>
		</div>
		<div class="item tags">
			<span class="head">标签：</span> <span class="text"><?php echo esc_html($detail["ori_tags"]);?></span>
		</div>
		<div class="item desc">
			<span class="head">描述：</span>
			<div class="text">
				<textarea readonly="readonly"><?php echo esc_html($detail["ori_desc"]);?></textarea>
			</div>
		</div>
		<div class="item comment">
			<span class="head">备注：</span>
			<div class="text">
				<textarea readonly="readonly"><?php echo esc_html($detail["ori_comment"]);?></textarea>
			</div>
		</div>
	</div>
</div>
<?php z_get_footer();?>