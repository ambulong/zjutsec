<?php
/**
 * 报告操作类
 * @author Ambulong
 *
 */
class zReport {
	private $dbh = NULL;
	private $id = NULL;
	
	public function __construct() {
		$this->dbh = $GLOBALS ['z_dbh'];
	}
	
	/**
	 * 添加报告
	 * @param int $uid 用户ID
	 * @param string $ori_title
	 * @param string $ori_incharge
	 * @param string $ori_tags
	 * @param string $ori_desc
	 * @param string $ori_comment
	 * @param number $ori_rank
	 * @param number $anonymous
	 * @return boolean
	 */
	public function add($uid, $ori_title, $ori_incharge = "", $ori_tags = "", $ori_desc ="", $ori_comment = "", $ori_rank = 0, $anonymous = 0) {
		global $table_prefix;
		$uid = intval($uid);
		$sid = $this->newSaltID ( 32 );
		$ext = json_encode(get_user_info());
		$ori_title = trim($ori_title);
		$ori_incharge = trim($ori_incharge);
		$ori_tags = trim($ori_tags);
		$ori_desc = trim($ori_desc);
		$ori_comment = trim($ori_comment);
		$ori_rank = trim($ori_rank);
		$time = get_time();
		$mgmt_time = get_time();
		if($anonymous != 0 && $anonymous != 1){
			$anonymous = 0;
		}
		if(!(new zUser())->isExistID($uid))
			return FALSE;
		if($this->isExistOriTitle($ori_title)){
			return FALSE;
		}
		while ( $this->isExistSID ( $sid ) ) {
			$sid = $this->newSaltID ( 32 );
		}
		
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}reports(`sid`,`uid`,`anonymous`,`ori_title`,`ori_incharge`,`ori_tags`,`ori_desc`,`ori_comment`,`ori_rank`,`time`,`mgmt_time`,`ext`) VALUES(:sid, :uid, :anonymous, :ori_title, :ori_incharge, :ori_tags, :ori_desc, :ori_comment, :ori_rank, :time, :mgmt_time, :ext)" );
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':uid', $uid );
			$sth->bindParam ( ':anonymous', $anonymous );
			$sth->bindParam ( ':ori_title', $ori_title );
			$sth->bindParam ( ':ori_incharge', $ori_incharge );
			$sth->bindParam ( ':ori_tags', $ori_tags );
			$sth->bindParam ( ':ori_desc', $ori_desc );
			$sth->bindParam ( ':ori_comment', $ori_comment );
			$sth->bindParam ( ':ori_rank', $ori_rank );
			$sth->bindParam ( ':time', $time );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
			$sth->bindParam ( ':ext', $ext );
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
	 * 删除报告 
	 * @param unknown $value
	 * @param string $type
	 * @param number $uid
	 * @return boolean|unknown
	 */
	public function del($value, $type = "id", $uid = 0) {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		
		//回收站存档
		$detail = $this->getDetail($value, $type);
		(new zBin())->add($detail, $uid);
		
		if ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}reports WHERE `id` = :id " );
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
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}reports WHERE `sid` = :sid " );
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
		}
	}
	
	/**
	 * 获取报告详情
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|unknown
	 */
	public function getDetail($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "sid" && $type != "id")
			return false;
		if ($type === "sid") {
			if (!$this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "id") {
			if (!$this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `id` = :id " );
				$sth->bindParam ( ':id', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * 更新报告
	 * @param unknown $id
	 * @param number $status
	 * @param number $level
	 * @param number $rank
	 * @param string $title
	 * @param string $incharge
	 * @param string $tags
	 * @param string $summary
	 * @param string $desc
	 * @param string $comment
	 * @param string $resp
	 * @param string $note
	 * @param number $canbepub
	 * @return boolean
	 */
	public function update($id, $status = 0, $level = 1, $rank = 0, $title = "", $incharge = "", $tags = "", $summary = "", $desc = "", $comment = "", $resp = "", $note = "", $canbepub = 1) {
		global $table_prefix;
		$id = intval ( $id );
		$title = trim($title);
		$incharge = trim($incharge);
		$tags = trim($tags);
		$summary = trim($summary);
		$desc = trim($desc);
		$comment = trim($comment);
		$resp = trim($resp);
		$note = trim($note);
		$mgmt_time = get_time();
		
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}reports SET `status`= :status, `level` = :level, `rank` = :rank, `title` = :title, `incharge` = :incharge, `tags` = :tags, `summary` = :summary, `desc` = :desc, `comment` = :comment, `resp` = :resp, `note` = :note, `canbepub` = :canbepub, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':status', $status );
			$sth->bindParam ( ':level', $level );
			$sth->bindParam ( ':rank', $rank );
			$sth->bindParam ( ':title', $title );
			$sth->bindParam ( ':incharge', $incharge );
			$sth->bindParam ( ':tags', $tags );
			$sth->bindParam ( ':summary', $summary );
			$sth->bindParam ( ':desc', $desc );
			$sth->bindParam ( ':comment', $comment );
			$sth->bindParam ( ':resp', $resp );
			$sth->bindParam ( ':note', $note );
			$sth->bindParam ( ':canbepub', $canbepub );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateStatus($status, $id) {
		global $table_prefix;
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `status`= :status, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':status', $status );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateLevel($level, $id) {
		global $table_prefix;
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `level`= :level, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':level', $level );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateRank($rank, $id) {
		global $table_prefix;
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `rank`= :rank, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':rank', $rank );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateTitle($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `title`= :title, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':title', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateIncharge($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `incharge`= :incharge, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':incharge', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateTags($tags, $id) {
		global $table_prefix;
		$tags = json_encode($tags);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `tags`= :tags, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':tags', $tags );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateSummary($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `summary`= :summary, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':summary', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateDesc($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `desc`= :desc, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':desc', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateComment($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `comment`= :comment, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':comment', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateResp($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `resp`= :resp, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':resp', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateNote($str, $id) {
		global $table_prefix;
		$str = trim($str);
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `note`= :note, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':note', $str );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function updateCanbepub($iscan, $id) {
		global $table_prefix;
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `canbepub`= :canbepub, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':canbepub', $iscan );
			$sth->bindParam ( ':mgmt_time', $mgmt_time );
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
	
	public function getLevel($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['level'];
	}
	
	public function getRank($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['rank'];
	}
	
	public function getTitle($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['title'];
	}
	
	public function getIncharge($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['incharge'];
	}
	
	public function getTags($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		$tags = $result ['tags'];
		if(!is_json($tags))
			return "";
		$tags = json_decode($tags, true);
		$tags_temp = array();
		$tag_obj = new zTag();
		foreach($tags as $tag) {
			$tags_temp[] = $tag_obj->getDetail($tag);
		}
		return $tags_temp;
	}
	
	public function getSummary($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['summary'];
	}
	
	public function getDesc($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['desc'];
	}
	
	public function getComment($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['comment'];
	}
	
	public function getResp($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['resp'];
	}
	
	public function getNote($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['note'];
	}
	
	public function getTime($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['time'];
	}
	
	public function getCanbepub($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['canbepub'];
	}
	
	public function getMgmtTime($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['mgmt_time'];
	}
	
	public function getExt($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['ext'];
	}
	
	/**
	 * 获取列表
	 * @param string $type all|pub|confirmed
	 * @param string $value
	 * @param string $class %|tagid|tag|level|uid|uname|email|keyintitle|keyintext
	 * @param number $offset
	 * @param number $row
	 * @return boolean|multitype:
	 */
	public function getList($type = "all", $value = "", $class = "%", $offset = 0, $row = -1) {
		global $table_prefix;
		$allow_type = array("all", "pub", "confirmed");
		$allow_class = array("%", "tagid", "tag", "level", "uid", "uname", "email", "keyintitle", "keyintext");
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if (!in_array($type, $allow_type) && !in_array($class, $allow_class))
			return false;
		
		return array();
	}
	
	/**
	 * 获取用户报告列表
	 * @param number $uid
	 * @param number $offset
	 * @param number $rows
	 * @return boolean|array
	 */
	public function getUserReports($uid, $offset = 0, $rows = 13) {
		global $table_prefix;
		if(!(new zUser())->isExistID($uid)) {
			return FALSE;
		}
		$offset = intval($offset);
		$rows = intval($rows);
		try {
			if($rows == -1)
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `uid` = :uid ORDER BY `id` DESC" );
			else 
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `uid` = :uid ORDER BY `id` DESC LIMIT {$offset},{$rows}" );
			$sth->bindParam ( ':uid', $uid );
			$sth->execute ();
			$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
			if (count ( $result ) <= 0) {
				$result = array ();
			}
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取报告列表
	 * @param number $offset
	 * @param number $rows
	 * @return multitype:
	 */
	public function getReports($offset = 0, $rows = 13) {
		global $table_prefix;
		$offset = intval($offset);
		$rows = intval($rows);
		try {
			if($rows == -1)
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports ORDER BY `id` DESC" );
			else 
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports ORDER BY `id` DESC LIMIT {$offset},{$rows}" );
			$sth->execute ();
			$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
			if (count ( $result ) <= 0) {
				$result = array ();
			}
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 获取报告列表
	 * @param number $offset
	 * @param number $rows
	 * @return multitype:
	 */
	public function getPubReports($offset = 0, $rows = 13) {
		global $table_prefix;
		$offset = intval($offset);
		$rows = intval($rows);
		try {
			if($rows == -1)
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `status` = 1 AND `canbepub` = 1 ORDER BY `id` DESC" );
			else
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}reports WHERE `status` = 1 AND `canbepub` = 1 ORDER BY `id` DESC LIMIT {$offset},{$rows}" );
			$sth->execute ();
			$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
			if (count ( $result ) <= 0) {
				$result = array ();
			}
			return $result;
		} catch ( PDOExecption $e ) {
			echo "<br>Error: " . $e->getMessage ();
		}
	}
	
	/**
	 * 帖子ID是否存在
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}reports WHERE `id` = :id " );
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
	 * 帖子标题是否存在
	 *
	 * @param string $title
	 * @return boolean
	 */
	public function isExistOriTitle($title) {
		global $table_prefix;
		$title = trim($title);
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}reports WHERE `ori_title` = :title " );
			$sth->bindParam ( ':title', $title );
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
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}reports WHERE `sid` = :sid" );
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