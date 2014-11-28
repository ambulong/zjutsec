<?php
/**
 * 日志操作类
 * @author Ambulong
 *
 */
class zLog {
	private $dbh = NULL;
	private $ext = NULL;
	/**
	 * 初始化
	 */
	public function __construct() {
		$this->dbh = $GLOBALS ['z_dbh'];
		$this->ext = get_user_info();
	}
	
	/**
	 * 添加记录
	 * 
	 * @param array $data 要插入的数据
	 * @return boolean
	 */
	public function add($data) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}logs(`data`,`time`,`ext`) VALUES( :data, :time, :ext)" );
			$sth->bindParam ( ':data', json_encode($data) );
			$sth->bindParam ( ':time', get_time() );
			$sth->bindParam ( ':ext', json_encode($this->ext) );
			$sth->execute ();
			if (! ($sth->rowCount () > 0)) {
				return FALSE;
			}
			$this->id = $this->dbh->lastInsertId ();
			return TRUE;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
}