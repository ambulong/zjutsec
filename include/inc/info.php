<?php
function z_get_sitename() {
	return (new zConfig())->getName();
}