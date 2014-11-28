<?php
/**
 * 标签操作类
 * @author Ambulong
 *
 */
class zTag {
	private $dbh = NULL;
	private $id = NULL;
	public function __construct() {
		$this->dbh = $GLOBALS ['z_dbh'];
	}
	
	/**
	 * 添加标签
	 * 
	 * @param string $name        	
	 * @return boolean
	 */
	public function add($name) {
		global $table_prefix;
		$name = trim ( $name );
		$sid = $this->newSaltID ( 8 );
		if ($this->isExistName ( $name )) {
			return FALSE;
		}
		while ( $this->isExistSID ( $sid ) ) {
			$sid = $this->newSaltID ( 8 );
		}
		
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}tags(`sid`,`name`) VALUES(:sid, :name)" );
			$sth->bindParam ( ':sid', $this->sid );
			$sth->bindParam ( ':name', $this->name );
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
	
	/**
	 * 删除标签
	 *
	 * @param int|string $value        	
	 * @param int|string $type
	 *        	id|sid|name
	 * @return boolean|int
	 */
	public function del($value, $type = "id") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid" && $type != "name")
			return false;
		if ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}tags WHERE `id` = :id " );
				$sth->bindParam ( ':id', $value );
				$sth->execute ();
				$row = $sth->rowCount ();
				if ($row > 0) {
					return $row;
				} else {
					return FALSE;
				}
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "sid") {
			if ($this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}tags WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$row = $sth->rowCount ();
				if ($row > 0) {
					return $row;
				} else {
					return FALSE;
				}
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "name") {
			if ($this->isExistName ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}tags WHERE `name` = :name " );
				$sth->bindParam ( ':name', $value );
				$sth->execute ();
				$row = $sth->rowCount ();
				if ($row > 0) {
					return $row;
				} else {
					return FALSE;
				}
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * 获取SID
	 *
	 * @param int|string $value        	
	 * @param string $type
	 *        	id|name
	 * @return boolean|string
	 */
	public function getSID($value, $type = "id") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "name")
			return false;
		if ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `id` = :id " );
				$sth->bindParam ( ':id', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['sid'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "name") {
			if ($this->isExistName ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `name` = :name " );
				$sth->bindParam ( ':name', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['sid'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * 获取ID
	 *
	 * @param int|string $value        	
	 * @param string $type
	 *        	sid|name
	 * @return boolean|string
	 */
	public function getID($value, $type = "name") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "sid" && $type != "name")
			return false;
		if ($type === "sid") {
			if (! $this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['id'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "name") {
			if ($this->isExistName ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `name` = :name " );
				$sth->bindParam ( ':name', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['id'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * 获取标签名
	 *
	 * @param int|string $value        	
	 * @param string $type
	 *        	id|sid
	 * @return boolean|string
	 */
	public function getName($value, $type = "id") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "sid" && $type != "name")
			return false;
		if ($type === "sid") {
			if (! $this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['name'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `id` = :id " );
				$sth->bindParam ( ':id', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result ['id'];
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * 获取详细内容
	 *
	 * @param int|string $value        	
	 * @param string $type
	 *        	id|sid|name
	 * @return boolean|string
	 */
	public function getDetail($value, $type = "id") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "sid" && $type != "name" && $type != "id")
			return false;
		if ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `id` = :id " );
				$sth->bindParam ( ':id', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "sid") {
			if (! $this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "name") {
			if ($this->isExistName ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}tags WHERE `name` = :name " );
				$sth->bindParam ( ':name', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * 更新标签名
	 * @param string $name
	 * @param int $id
	 * @return boolean
	 */
	public function updateName($name, $id) {
		global $table_prefix;
		$name = trim ( $name );
		$id = intval ( $id );
		if (! $this->isExistID ( $id ) || $this->isExistName ( $name )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}tags SET `name`= :name WHERE `id` = :id" );
			$sth->bindParam ( ':name', $name );
			$sth->bindParam ( ':id', $id );
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
	 * 项目ID是否存在
	 *
	 * @param int $id        	
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}tags WHERE `id` = :id " );
			$sth->bindParam ( ':id', $id );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * SID是否存在
	 *
	 * @param String $sid
	 *        	要查询的字符串ID
	 * @return boolean
	 */
	public function isExistSID($sid) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}tags WHERE `sid` = :sid" );
			$sth->bindParam ( ':sid', $sid );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 标签名是否存在
	 *
	 * @param String $name
	 *        	要查询的标签名
	 * @return boolean
	 */
	public function isExistName($name) {
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}tags WHERE `name` = :name " );
			$sth->bindParam ( ':name', $name );
			$sth->execute ();
			$row = $sth->fetch ();
			if ($row [0] > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 生成随机字符串
	 *
	 * @param int $length
	 *        	要生成的字符串长度
	 * @return string
	 */
	public function newSaltID($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$salt = '';
		for($i = 0; $i < $length; $i ++) {
			$salt .= $chars [mt_rand ( 0, strlen ( $chars ) - 1 )];
		}
		return $salt;
	}
}