<?php
/**
 * 程序路由处理类
 * @author ambulong
 *
 */
class zRouter {
	private $URI = NULL;
	private $MODULE = array (
			"view",
			"action",
			"api" 
	);
	private $FILE = array (
			"main",
			"login",
			"user",
			"register",
			"logout",
			"report",
			"detail",
			"profile",
			"upload",
			"admconfig",
			"admedituser",
			"admreportlist",
			"admeditreport"
	);

	
	/**
	 * 获取并简单处理URL
	 */
	public function __construct() {
		$current_url = strtolower ( get_url () );
		$this->URI = substr ( $current_url, strlen ( ZSEC_SITEURL ), strlen ( $current_url ) - strlen ( ZSEC_SITEURL ) );
		$this->URI = explode ( '?', $this->URI )[0];
	}
	
	/**
	 * 初始化路由
	 */
	public function init() {
		//echo get_url ();
		$uri = explode ( '/', $this->URI );
		if($this->URI === "index.php" || $uri [0] != "index.php") {
			gotourl(z_get_home_url());
			exit;
		}
		// validate uri
		if (!in_array ( $uri [1], $this->MODULE )) {
			//gotourl(z_get_home_url())；
			header ( "HTTP/1.0 404 Not Found" );
			exit ();
		}
		//$module = (count ( $uri ) > 2) ? $uri [1] : "view";
		//$file = (count ( $uri ) > 3) ? $uri [2] : "main";
		$module = (isset($uri [1])) ? $uri [1] : "";
		$file = (isset($uri [2])) ? $uri [2] : "";
		if (!in_array ( $file, $this->FILE )) {
			//gotourl(z_get_home_url())；
			header ( "HTTP/1.0 404 Not Found" );
			exit ();
		}
		$module = (in_array ( $module, $this->MODULE )) ? $module : "view";
		$file = (in_array ( $file, $this->FILE )) ? $file : "main";
		
		$filename = ZSEC_ABSPATH . ZSEC_INC . $module . "/" . $file . ".php";
		
		if (is_readable ( $filename )) {
			require_once ($filename);
		} else {
			header ( 'Content-Type: text/plain; charset=utf-8' );
			die ( "ERROR: File  ./" . ZSEC_INC . $module . "/" . $file . ".php" . " is unreadable." );
		}
	}
}