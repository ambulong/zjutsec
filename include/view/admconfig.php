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
z_get_header ( "网站配置" );
z_get_left ();
?>
<div class="content-main pull-left">
</div>
<?php z_get_footer();?>