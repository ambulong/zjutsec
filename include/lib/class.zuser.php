<?php
/**
 * 用户操作类
 * @author Ambulong
 *
 */
class zUser {
	private $dbh = NULL;
	private $hasher = NULL;
	public function __construct() {
		$this->dbh = $GLOBALS ['z_dbh'];
		$this->hasher = new PasswordHash ( 8, FALSE );
	}
	
	/**
	 * 添加用户
	 *
	 * @param unknown $username        	
	 * @param unknown $email        	
	 * @param unknown $password        	
	 * @param string $avatar
	 *        	头像（base64）
	 * @param string $label        	
	 * @param string $desc        	
	 * @param string $url        	
	 * @param string $org        	
	 * @param string $phone        	
	 * @param string $qq        	
	 * @param number $role        	
	 *
	 * @return boolean
	 */
	public function add($username, $email, $password, $avatar = "", $label = "", $desc = "", $url = "", $org = "", $phone = "", $qq = "", $role = 0) {
		global $table_prefix;
		$sid = $this->newSaltID ( 8 );
		$username = trim ( $username );	//用来显示的
		$name = strtolower($username);	//全部小写，校验是否已经存在
		$email = strtolower(trim ( $email ));
		$hash = $this->hasher->HashPassword ( $password );
		$label = trim ( $label );
		$desc = trim ( $desc );
		$url = trim ( $url );
		$org = trim ( $org );
		$phone = trim ( $phone );
		$qq = trim ( $qq );
		$time = get_time ();
		$mgmt_time = get_time ();
		$ext = json_encode ( get_user_info () );
		
		if ($this->isExistName ( $username )) {
			return FALSE;
		}
		if ($this->isExistEmail ( $email )) {
			return FALSE;
		}
		while ( $this->isExistSID ( $sid ) ) {
			$sid = $this->newSaltID ( 8 );
		}
		
		try {
			$sth = $this->dbh->prepare ( "INSERT INTO {$table_prefix}users(`sid`,`role`,`name`,`username`,`email`,`password`,`avatar`,`label`,`desc`,`url`,`org`,`phone`,`qq`,`time`,`mgmt_time`,`ext`) VALUES(:sid, :role, :name, :username, :email, :password, :avatar, :label, :desc, :url, :org, :phone, :qq, :time, :mgmt_time, :ext)" );
			$sth->bindParam ( ':sid', $sid );
			$sth->bindParam ( ':role', $role );
			$sth->bindParam ( ':name', $name );
			$sth->bindParam ( ':username', $username );
			$sth->bindParam ( ':email', $email );
			$sth->bindParam ( ':password', $hash );
			$sth->bindParam ( ':avatar', $avatar );
			$sth->bindParam ( ':label', $label );
			$sth->bindParam ( ':desc', $desc );
			$sth->bindParam ( ':url', $url );
			$sth->bindParam ( ':org', $org );
			$sth->bindParam ( ':phone', $phone );
			$sth->bindParam ( ':qq', $qq );
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
	 * 删除用户
	 *
	 * @param unknown $value        	
	 * @param string $type
	 *        	id|sid|email
	 * @return boolean|unknown
	 */
	public function del($value, $type = "id") {
		global $table_prefix;
		$type = strtolower ( trim ( $type ) );
		if ($type != "id" && $type != "sid" && $type != "email")
			return false;
		if ($type === "id") {
			if ($this->isExistID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}users WHERE `id` = :id " );
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
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}users WHERE `sid` = :sid " );
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
		} elseif ($type === "email") {
			if ($this->isExistEmail ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "DELETE FROM {$table_prefix}users WHERE `email` = :email " );
				$sth->bindParam ( ':email', $value );
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
		} else {
			return FALSE;
		}
	}
	
	/**
	 * 校验密码
	 * 
	 * @param string $email        	
	 * @param string $password        	
	 * @return boolean
	 */
	public function validatePassword($email, $password) {
		$email = strtolower(trim ( $email ));
		$hash = $this->getPassword ( $email );
		//var_dump($hash);
		if (! $this->isExistEmail ( $email ))
			return FALSE;
		if ($this->hasher->CheckPassword ( $password, $hash ))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * 登录
	 * @param string $email
	 * @return boolean
	 */
	public function login($email) {
		$email = strtolower(trim($email));
		if(!$this->isExistEmail($email))
			return FALSE;
		$detail = $this->getDetail($email, "email");
		$_SESSION["user"] = array(
				"status" => TRUE,	//判断是否登录
				"name"	=> $detail["username"],
				"email"	=> $detail["email"],
				"role"	=> $detail["role"],
				"id"	=> $detail["id"],
				"sid"	=> $detail["sid"],
				"token"	=> $this->newSaltID(32)
		);
		return TRUE;
	}
	
	/**
	 * 获取ID
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getPassword($value, $type = "email") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "sid" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['password'];
	}
	
	/**
	 * 获取用户详情
	 * @param unknown $value
	 * @param string $type username|sid|email|id
	 * @return boolean|unknown
	 */
	public function getDetail($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "sid" && $type != "email" && $type != "id")
			return false;
		if ($type === "username") {
			if (!$this->isExistName ( $value )) {
				return FALSE;
			}
			$value = strtolower(trim($value));
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}users WHERE `name` = :username " );
				$sth->bindParam ( ':username', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "sid") {
			if ($this->isExistSID ( $value )) {
				return FALSE;
			}
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}users WHERE `sid` = :sid " );
				$sth->bindParam ( ':sid', $value );
				$sth->execute ();
				$result = $sth->fetch ( PDO::FETCH_ASSOC );
				return $result;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		} elseif ($type === "email") {
			if (!$this->isExistEmail ( $value )) {
				return FALSE;
			}
			$value = strtolower(trim($value));
			try {
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}users WHERE `email` = :email " );
				$sth->bindParam ( ':email', $value );
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
				$sth = $this->dbh->prepare ( "SELECT * FROM {$table_prefix}users WHERE `id` = :id " );
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
	 * 获取ID
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getID($value, $type = "email") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "sid" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['id'];
	}
	
	/**
	 * 获取SID
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getSID($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['sid'];
	}
	
	/**
	 * 获取头像
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getAvatar($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['avatar'];
	}
	
	/**
	 * 获取Label
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getLabel($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['label'];
	}
	
	/**
	 * 获取个人简介
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getDesc($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['desc'];
	}
	
	/**
	 * 获取个人网站
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getURL($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['url'];
	}
	
	/**
	 * 获取组织
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getOrg($value, $type = "idl") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['org'];
	}
	
	/**
	 * 获取手机
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getPhone($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['phone'];
	}
	
	/**
	 * 获取QQ
	 * @param unknown $value
	 * @param string $type
	 * @return boolean|Ambigous <>
	 */
	public function getQQ($value, $type = "id") {
		global $table_prefix;
		$value = trim ( $value );
		$type = strtolower ( trim ( $type ) );
		if ($type != "username" && $type != "id" && $type != "email")
			return false;
		$result = $this->getDetail ( $value, $type );
		return $result ['qq'];
	}
	
	/**
	 * 获取报告数量
	 * @param string $type all|pub|confirmed
	 * @param int $id
	 * @return number
	 */
	public function getReportNum($id, $type = "pub") {
		global $table_prefix;
		if($type != "all" && $type != "pub" && $type != "confirmed")
			return FALSE;
		if($type === "all") {
			try {
				$sth = $this->dbh->prepare ( "SELECT `id` FROM {$table_prefix}reports WHERE `uid` = :id" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				return count ( $result );
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}elseif($type === "pub") {
			try {
				$sth = $this->dbh->prepare ( "SELECT `id` FROM {$table_prefix}reports WHERE `uid` = :id AND `status` = 1 AND `canbepub` = 1" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				return count ( $result );
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}elseif($type === "confirmed"){
			try {
				$sth = $this->dbh->prepare ( "SELECT `id` FROM {$table_prefix}reports WHERE `uid` = :id AND `status` = 1" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				return count ( $result );
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}else{
			return 0;
		}
	}
	
	/**
	 * 获取rank
	 * @param int $id
	 * @param string $type
	 * @return number
	 */
	public function getRank($id, $type = "pub") {
		global $table_prefix;
		if($type != "all" && $type != "pub" && $type != "confirmed")
			return FALSE;
		if($type === "all") {
			try {
				$sth = $this->dbh->prepare ( "SELECT `rank` FROM {$table_prefix}reports WHERE `uid` = :id" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				$total = 0;
				foreach ($result as $item)
					$total += $item["rank"];
				return $total;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}elseif($type === "pub") {
			try {
				$sth = $this->dbh->prepare ( "SELECT `rank` FROM {$table_prefix}reports WHERE `uid` = :id AND `status` = 1 AND `canbepub` = 1" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				$total = 0;
				foreach ($result as $item)
					$total += $item["rank"];
				return $total;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}elseif($type === "confirmed"){
			try {
				$sth = $this->dbh->prepare ( "SELECT `rank` FROM {$table_prefix}reports WHERE `uid` = :id AND `status` = 1" );
				$sth->bindParam ( ':id', $id );
				$sth->execute ();
				$result = $sth->fetchAll ( PDO::FETCH_ASSOC );
				// var_dump($result);
				$total = 0;
				foreach ($result as $item)
					$total += $item["rank"];
				return $total;
			} catch ( PDOExecption $e ) {
				echo "<br>Error: " . $e->getMessage ();
			}
		}else{
			return 0;
		}
	}
	
	/**
	 * 获取使用过的标签
	 * @param int $id
	 * @param string $type
	 * @return multitype:string 
	 */
	public function getTags($id, $type = "pub") {
		return array("tag1", "tag2");
	}
	
	/**
	 * 更改密码
	 * @param string $password
	 * @param int $id
	 * @return boolean
	 */
	public function updatePassword($password, $id) {
		global $table_prefix;
		$hash = $this->hasher->HashPassword ( $password );
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `password`= :password, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':password', $hash );
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
	
	/**
	 * 更改头像
	 * @param string $avatar
	 * @param int $id
	 * @return boolean
	 */
	public function updateAvatar($avatar, $id) {
		global $table_prefix;
		$id = intval ( $id );
		$mgmt_time = get_time ();
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `avatar`= :avatar, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':avatar', $avatar );
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
	
	/**
	 * 更新Lable
	 * @param string $label
	 * @param int $id
	 * @return boolean
	 */
	public function updateLabel($label, $id) {
		global $table_prefix;
		$label = trim($label);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `label`= :label, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':label', $label );
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
	
	/**
	 * 更改简介
	 * @param string $desc
	 * @param int $id
	 * @return boolean
	 */
	public function updateDesc($desc, $id) {
		global $table_prefix;
		$desc = trim($desc);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `desc`= :desc, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':desc', $desc );
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
	
	/**
	 * 更新网址
	 * @param string $url
	 * @param int $id
	 * @return boolean
	 */
	public function updateURL($url, $id) {
		global $table_prefix;
		$url = trim($url);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `url`= :url, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':url', $url );
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
	
	/**
	 * 更改组织
	 * @param string $org
	 * @param int $id
	 * @return boolean
	 */
	public function updateOrg($org, $id) {
		global $table_prefix;
		$org = trim($org);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `org`= :org, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':org', $org );
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
	
	/**
	 * 更改手机
	 * @param string $phone
	 * @param int $id
	 * @return boolean
	 */
	public function updatePhone($phone, $id) {
		global $table_prefix;
		$phone = trim($phone);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `phone`= :phone, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':phone', $phone );
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
	
	/**
	 * 更改QQ
	 * @param string $qq
	 * @param int $id
	 * @return boolean
	 */
	public function updateQQ($qq, $id) {
		global $table_prefix;
		$qq = trim($qq);
		$mgmt_time = get_time ();
		$id = intval ( $id );
		if (! $this->isExistID ( $id )) {
			return FALSE;
		}
		try {
			$sth = $this->dbh->prepare ( "UPDATE {$table_prefix}users SET `qq`= :qq, `mgmt_time` = :mgmt_time WHERE `id` = :id" );
			$sth->bindParam ( ':qq', $qq );
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
	
	/**
	 * 用户ID是否存在
	 *
	 * @param int $id        	
	 * @return boolean
	 */
	public function isExistID($id) {
		$id = intval ( $id );
		global $table_prefix;
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}users WHERE `id` = :id " );
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
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}users WHERE `sid` = :sid" );
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
	 * 用户名是否存在
	 *
	 * @param String $name
	 *        	要查询的用户名
	 * @return boolean
	 */
	public function isExistName($name) {
		global $table_prefix;
		$name = strtolower(trim($name));
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}users WHERE `name` = :name " );
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
	 * 邮箱是否存在
	 *
	 * @param String $email
	 *        	要查询的邮箱
	 * @return boolean
	 */
	public function isExistEmail($email) {
		global $table_prefix;
		$email = strtolower(trim($email));
		try {
			$sth = $this->dbh->prepare ( "SELECT count(*) FROM {$table_prefix}users WHERE `email` = :email " );
			$sth->bindParam ( ':email', $email );
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
	
	/**
	 * 销毁hash
	 */
	public function __destruct() {
		if (isset ( $this->hasher ))
			unset ( $this->hasher );
	}
}