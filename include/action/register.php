<?php
if (! defined ( "ZSEC_ENTRANCE" )) {
	header ( "HTTP/1.0 404 Not Found" );
	exit ();
}
header ( 'Content-Type: text/html; charset=utf-8' );
if(z_is_login()) {
	die("你已经登录.");
}
$username = isset ( $_POST ["username"] ) ? trim($_POST ["username"]) : "";
$email = isset ( $_POST ["email"] ) ? trim($_POST ["email"]) : "";
$password = isset ( $_POST ["password"] ) ? $_POST ["password"] : "";
$password2 = isset ( $_POST ["password2"] ) ? $_POST ["password2"] : "";
$liscence = isset ( $_POST ["liscence"] ) ? $_POST ["liscence"] : 0;
if($liscence != 1) {
	die ( "请先同意用户协议." );
}
if(!preg_match('/^(?!_|\s\')[A-Za-z0-9_\x80-\xff\s\']+$/', $username)) {
	die ( "用户名不符合规范." );
}
if(strcasecmp($password, $password2) != 0) {
	die ( "两次输入密码不同." );
}
if(strlen($password) < 6) {
	die ( "密码不能小于6位." );
}
if($username === "" || $email === "") {
	die ( "不能未空." );
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	die ( "邮箱格式错误." );
}

$user_obj = new zUser();
if($user_obj->isExistEmail($email)){
	die ( "邮箱已存在." );
}
if($user_obj->isExistName($username)){
	die ( "用户名已存在." );
}
$avatar = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH4AAAB+CAYAAADiI6WIAAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAZ25vbWUtc2NyZWVuc2hvdO8Dvz4AAAQMSURBVHic7Z3dUqQwEEabnxLKEX3/h/MdFDIUKEP2wmKd3drSVQPdne87V5ZVAz0ckjSdTCgeHx+jEDhK7QCIDhQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgwIiP8e23odM0SV3XsiyLhBCkrmupqkoul4us66oc5XHU2gHsSYxRyrKUYRj++P/T09M//77mdDpJURS7xqdJtuJDCD/6/Pl8FhGRrut+9xY5kZX4GKPM8yzLsiQ75tZb3N3dJTumBbIZ42OMcj6fk0q/JoQgZZnN5cpD/CZ9b/q+zyYBzEL8EdI3xnH8cf5gAdfiY4xqErxn/K7Fv7y8qJ17GAbX2b5r8a+vr6rnv1wuquf/CW7FWxhnp2ly2+rdirfCkYllSlyKt9DaveNSvDU8dvfuxFssoMzzrB3Cl3En3mLZdK8y8Z7Yu4qf4PEiW8Sd+GmatEP4JxaHoI9wJ94qFoegj/AVrWG8PWJSPCgUDwrFJ8Lb0iyKTwSzelC8Lcyg+ERQ/M6cTiftELLAnXiLM2Ft22qH8GXcibdYIbMY02f4i9ggFH8QXddph+Ael+ItjfPeCjcbLsWLiNR1Vr/3PBy34pum0Q5BHh4etEP4Nm7FWyiYeF4N5Fa8iG4xp65rEzffd3EtXvPC39zcqJ07Ba7Fi+i0+qZpXD67X+M7enlr9UeXTHN4onAvXkSkqqrDzpXLblhZiC+K4pBCyu3tbRbSRTIRv7F3Kdf7uH5NPt9E3kq5e8nPbR1AVuJF9qnj5zKuX5OdeJH0XX5u0kUyFZ9yxavX2bfPyFJ8yhaaU0J3TZbfKmWLz7GbF8lU/DiOyY71/Pyc7FiWyE78Hlm9t1/J/A9ZiS+KYpftx8ZxNLXcKwXuZxtijLIsy+4bEG03VNM07ufiRZyL19iMYJ7n3zdZ13WyrqvLm8CV+BijVFUlfd9rhyIi72+vaJpGqqpy9ejnQnyMUWKMSbP1lGw9QF3X0jSNix7AvPiyLM208M9YlkWWZZG2baUsS9M9gGnx3jYU2ti2ZGvbVqqqMtkDmBN/1PtljmC7Ae7v783VAkz1RWVZZiP9mr7vJYRgSr6JFr+uq9nELSXjOJqZ7VNv8Zaz9T0IIZgY81XF5zSef4VhGNTfp6MmHlX6xjzPqi1fRTy69I2/33J9JCriKf2dEILKzN/h4i0kNtbQaAiHi9fs3sg76o9zRAeKB4XiQTm8ZGulZIkOWzwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA8KxYNC8aBQPCgUDwrFg0LxoFA8KBQPCsWDQvGgUDwoFA/KL9x+UO0AlgzQAAAAAElFTkSuQmCC';
if($user_obj->add($username, $email, $password, $avatar)) {
	echo "注册成功.";
}else {
	die ( "注册失败." );
}
