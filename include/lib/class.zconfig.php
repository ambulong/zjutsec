<?php
/**
 * 网站配置操作类
 * @author Ambulong
 *
 */
class zConfig {
	private $dbh = NULL;
	
	public function __construct() {
		$this->dbh = $GLOBALS ['z_dbh'];
	}
	
	/**
	 * 获取网站设置
	 * 
	 * @return array
	 */
	public function getDetail() {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}config limit 0,1 " );
			$sth->execute ();
			$result = $sth->fetch ( PDO::FETCH_ASSOC );
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取网站名
	 * @return string
	 */
	public function getName() {
		$detail = $this->getDetail();
		return $detail['name'];
	}
	
	/**
	 * 更改网站名
	 * @return bool
	 */
	public function updateName($name) {
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `name`= :name WHERE 1" );
			$sth->bindParam ( ':name', $name );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取网站网址
	 * @return string
	 */
	public function getURL() {
		$detail = $this->getDetail();
		return $detail['url'];
	}
	
	/**
	 * 更改网站网址
	 * @return bool
	 */
	public function updateURL($url) {
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `url`= :url WHERE 1" );
			$sth->bindParam ( ':url', $url );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取LABEL
	 * @return string
	 */
	public function getLabel() {
		$detail = $this->getDetail();
		return $detail['label'];
	}
	
	/**
	 * 更改LABEL
	 * @return bool
	 */
	public function updateLabel($label) {
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `label`= :label WHERE 1" );
			$sth->bindParam ( ':label', $label );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取公开时间差
	 * @return string
	 */
	public function getExpireTime() {
		$detail = $this->getDetail();
		return $detail['expiretime'];
	}
	
	/**
	 * 更改公开时间差
	 * @return bool
	 */
	public function updateExpireTime($time) {
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `expiretime`= :expiretime WHERE 1" );
			$sth->bindParam ( ':expiretime', $time );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 是否开启新报告提醒
	 * @return bool
	 */
	public function isAlert() {
		$detail = $this->getDetail();
		if($detail['alert'] == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * 更改提醒
	 * @return bool
	 */
	public function updateAlert($isAlert) {
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `alert`= :alert WHERE 1" );
			$sth->bindParam ( ':alert', $isAlert );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取接收提醒的邮箱
	 * @return string
	 */
	public function getAlertMails() {
		$detail = $this->getDetail();
		return $detail['alertmails'];
	}
	
	/**
	 * 更改接收提醒的邮箱
	 * @return bool
	 */
	public function updateAlertMails($mails) {
		if(is_array($mails))
			json_encode($mails);
		
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}config SET `alertmails`= :alertmails WHERE 1" );
			$sth->bindParam ( ':alertmails', $mails );
			$sth->execute ();
			if (! ($sth->rowCount () > 0))
				return FALSE;
			else
				return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}