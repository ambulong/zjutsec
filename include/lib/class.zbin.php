<?php
/**
 * 垃圾箱操作类（存放已删除东西）
 * @author Ambulong
 *
 */
class zBin {
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
	 * 添加信息
	 * 
	 * @param array $data
	 * @param array $operator
	 * @return boolean
	 */
	public function add($data, $operator) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}logs(`data`,`operator`,`time`,`ext`) VALUES( :data, :operator, :time, :ext)" );
			$sth->bindParam ( ':data', json_encode($data) );
			$sth->bindParam ( ':operator', json_encode($operator) );
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