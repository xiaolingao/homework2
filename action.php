<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
require('config/databaseConfig.php');

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
//$ms  = $c->home_timeline(); // done
$ms = $c->user_timeline_by_name();
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

	$dateArray = getdate();
	$checkTime = $dateArray['0'];

	$sql = "select text from test where time='$checkTime';";
	$result = mysql_query($sql);
	$numbers = mysql_num_rows($result);
	if(numbers > 0){
        $row = mysql_fetch_array($result);
        while($row){
        	$text = $row['text'];
            $ret = $c->update( $text );	
			if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
				echo "<p>发送失败，错误：{$ret['error_code']}:{$ret['error']}</p>";
			} else {
				echo "<p>发送成功</p>";
			}
            mysql_free_result($result);
        }
    }else{
        exit;
    }
?>