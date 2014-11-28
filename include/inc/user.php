<?php
function z_is_login() {
	if (isset ( $_SESSION ["user"] )) {
		if ($_SESSION ["user"]["status"] == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function  z_validate_token() {
	if (! isset ( $_REQUEST ['token'] )) {
		return FALSE;
	}
	$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : "";
	if (md5 ( $_SESSION ["user"]["token"] ) == md5 ( $token )) {
		return TRUE;
	}
	return FALSE;
}

function z_get_username() {
	return isset($_SESSION ["user"]["name"])?$_SESSION ["user"]["name"]:"";
}

function z_get_email() {
	return isset($_SESSION ["user"]["email"])?$_SESSION ["user"]["email"]:"";
}

function z_get_token() {
	return isset($_SESSION ["user"]["token"])?$_SESSION ["user"]["token"]:"";
}

function z_get_uid() {
	return $_SESSION ["user"]["id"];
}

function z_get_avatar($uid = "") {
	if(z_is_login() && $uid == ""){
		$avatar = (new zUser())->getAvatar(z_get_uid());
		if($avatar != "")
			return $avatar;
		else
			//return z_get_static_url()."/images/User-Login-128.png";
			return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH4AAAB+CAYAAADiI6WIAAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAZ25vbWUtc2NyZWVuc2hvdO8Dvz4AAAQMSURBVHic7Z3dUqQwEEabnxLKEX3/h/MdFDIUKEP2wmKd3drSVQPdne87V5ZVAz0ckjSdTCgeHx+jEDhK7QCIDhQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgwIiP8e23odM0SV3XsiyLhBCkrmupqkoul4us66oc5XHU2gHsSYxRyrKUYRj++P/T09M//77mdDpJURS7xqdJtuJDCD/6/Pl8FhGRrut+9xY5kZX4GKPM8yzLsiQ75tZb3N3dJTumBbIZ42OMcj6fk0q/JoQgZZnN5cpD/CZ9b/q+zyYBzEL8EdI3xnH8cf5gAdfiY4xqErxn/K7Fv7y8qJ17GAbX2b5r8a+vr6rnv1wuquf/CW7FWxhnp2ly2+rdirfCkYllSlyKt9DaveNSvDU8dvfuxFssoMzzrB3Cl3En3mLZdK8y8Z7Yu4qf4PEiW8Sd+GmatEP4JxaHoI9wJ94qFoegj/AVrWG8PWJSPCgUDwrFJ8Lb0iyKTwSzelC8Lcyg+ERQ/M6cTiftELLAnXiLM2Ft22qH8GXcibdYIbMY02f4i9ggFH8QXddph+Ael+ItjfPeCjcbLsWLiNR1Vr/3PBy34pum0Q5BHh4etEP4Nm7FWyiYeF4N5Fa8iG4xp65rEzffd3EtXvPC39zcqJ07Ba7Fi+i0+qZpXD67X+M7enlr9UeXTHN4onAvXkSkqqrDzpXLblhZiC+K4pBCyu3tbRbSRTIRv7F3Kdf7uH5NPt9E3kq5e8nPbR1AVuJF9qnj5zKuX5OdeJH0XX5u0kUyFZ9yxavX2bfPyFJ8yhaaU0J3TZbfKmWLz7GbF8lU/DiOyY71/Pyc7FiWyE78Hlm9t1/J/A9ZiS+KYpftx8ZxNLXcKwXuZxtijLIsy+4bEG03VNM07ufiRZyL19iMYJ7n3zdZ13WyrqvLm8CV+BijVFUlfd9rhyIi72+vaJpGqqpy9ejnQnyMUWKMSbP1lGw9QF3X0jSNix7AvPiyLM208M9YlkWWZZG2baUsS9M9gGnx3jYU2ti2ZGvbVqqqMtkDmBN/1PtljmC7Ae7v783VAkz1RWVZZiP9mr7vJYRgSr6JFr+uq9nELSXjOJqZ7VNv8Zaz9T0IIZgY81XF5zSef4VhGNTfp6MmHlX6xjzPqi1fRTy69I2/33J9JCriKf2dEILKzN/h4i0kNtbQaAiHi9fs3sg76o9zRAeKB4XiQTm8ZGulZIkOWzwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA/KL9x+UO0AlgzQAAAAAElFTkSuQmCC';
	}else{
		$avatar = (new zUser())->getAvatar($uid);
		if($avatar != "")
			return $avatar;
		else
			//return z_get_static_url()."/images/User-Login-128.png";
			return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH4AAAB+CAYAAADiI6WIAAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAZ25vbWUtc2NyZWVuc2hvdO8Dvz4AAAQMSURBVHic7Z3dUqQwEEabnxLKEX3/h/MdFDIUKEP2wmKd3drSVQPdne87V5ZVAz0ckjSdTCgeHx+jEDhK7QCIDhQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgwIiP8e23odM0SV3XsiyLhBCkrmupqkoul4us66oc5XHU2gHsSYxRyrKUYRj++P/T09M//77mdDpJURS7xqdJtuJDCD/6/Pl8FhGRrut+9xY5kZX4GKPM8yzLsiQ75tZb3N3dJTumBbIZ42OMcj6fk0q/JoQgZZnN5cpD/CZ9b/q+zyYBzEL8EdI3xnH8cf5gAdfiY4xqErxn/K7Fv7y8qJ17GAbX2b5r8a+vr6rnv1wuquf/CW7FWxhnp2ly2+rdirfCkYllSlyKt9DaveNSvDU8dvfuxFssoMzzrB3Cl3En3mLZdK8y8Z7Yu4qf4PEiW8Sd+GmatEP4JxaHoI9wJ94qFoegj/AVrWG8PWJSPCgUDwrFJ8Lb0iyKTwSzelC8Lcyg+ERQ/M6cTiftELLAnXiLM2Ft22qH8GXcibdYIbMY02f4i9ggFH8QXddph+Ael+ItjfPeCjcbLsWLiNR1Vr/3PBy34pum0Q5BHh4etEP4Nm7FWyiYeF4N5Fa8iG4xp65rEzffd3EtXvPC39zcqJ07Ba7Fi+i0+qZpXD67X+M7enlr9UeXTHN4onAvXkSkqqrDzpXLblhZiC+K4pBCyu3tbRbSRTIRv7F3Kdf7uH5NPt9E3kq5e8nPbR1AVuJF9qnj5zKuX5OdeJH0XX5u0kUyFZ9yxavX2bfPyFJ8yhaaU0J3TZbfKmWLz7GbF8lU/DiOyY71/Pyc7FiWyE78Hlm9t1/J/A9ZiS+KYpftx8ZxNLXcKwXuZxtijLIsy+4bEG03VNM07ufiRZyL19iMYJ7n3zdZ13WyrqvLm8CV+BijVFUlfd9rhyIi72+vaJpGqqpy9ejnQnyMUWKMSbP1lGw9QF3X0jSNix7AvPiyLM208M9YlkWWZZG2baUsS9M9gGnx3jYU2ti2ZGvbVqqqMtkDmBN/1PtljmC7Ae7v783VAkz1RWVZZiP9mr7vJYRgSr6JFr+uq9nELSXjOJqZ7VNv8Zaz9T0IIZgY81XF5zSef4VhGNTfp6MmHlX6xjzPqi1fRTy69I2/33J9JCriKf2dEILKzN/h4i0kNtbQaAiHi9fs3sg76o9zRAeKB4XiQTm8ZGulZIkOWzwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA/KL9x+UO0AlgzQAAAAAElFTkSuQmCC';
	}
	
}

function z_get_rank($uid = "") {
	if(z_is_login() && $uid == ""){
		$rank = (new zUser())->getRank(z_get_uid());
		return $rank;
	}else{
		$rank = (new zUser())->getRank($uid);
		return $rank;
	}
}

function z_get_name($uid = "") {
	if(z_is_login() && $uid == ""){
		$name = z_get_username();
		return $name;
	}else{
		$name = (new zUser())->getDetail($uid)["username"];
		return $name;
	}
}

function z_get_report_num($uid = "") {
	if(z_is_login() && $uid == ""){
		$rank = (new zUser())->getReportNum(z_get_uid());
		return $rank;
	}else{
		$rank = (new zUser())->getReportNum($uid);
		return $rank;
	}
}

function z_logout() {
	session_unset ();
	session_destroy ();
}

function z_is_admin() {
	return ($_SESSION ["user"]["role"] == 1)?TRUE:FALSE;
}