<?php
/*
*@Description:链接数据库配置信息
*
*
*/
$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if (!$con)
{
	die('Could not connect:' . mysql_error());
}
//选择数据库
mysql_select_db("app_fangfaweibo", $con) or die('can not connect to the databases');
date_default_timezone_set("Asia/Shanghai");
?>