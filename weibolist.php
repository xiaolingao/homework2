<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
//$ms  = $c->home_timeline(); // done
$ms = $c->user_timeline_by_name();
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博内容发送</title>
<link rel="stylesheet" type="text/css" href="CSS/input.css">
</head>

<body>
    <p><?=$user_message['screen_name']?>您好！</p>
    <br/>
	<div id="banner">
		<ul>
			<li><h2>我可以即时和定时发微博啦。</h2></li>
			<li>&nbsp;</li>
			<li><span id="tips"></span></li>
		</ul>
	</div>
	<form action='weibolist.php' method="post">
		<div id="inputBox">			
			<textarea rows="7" cols="60" id="content" name="text">告诉大家点什么吧！！</textarea>
			<div id="timeSelect">
				定时发微博：
				<select name='year'>
					<option value='2014'>2014年</option>
					<option value='2015'>2015年</option>
					<option value='2016'>2016年</option>
					<option value='2017'>2017年</option>
					<option value='2018'>2018年</option>
					<option value='2019'>2019年</option>
				</select>
				<select name='month'>
					<option value='01'>1月</option>
					<option value='02'>2月</option>
					<option value='03'>3月</option>
					<option value='04'>4月</option>
					<option value='05'>5月</option>
					<option value='06'>6月</option>
				</select>
				<select name='day'>
					<option value='20'>20日</option>
					<option value='21'>21日</option>
					<option value='22'>22日</option>
					<option value='23'>23日</option>
					<option value='24'>24日</option>
					<option value='25'>25日</option>
				</select>
				<select name='hour'>
					<option value='00'>00</option>
					<option value='01'>01</option>
					<option value='02'>02</option>
					<option value='03'>03</option>
					<option value='04'>04</option>
					<option value='05'>05</option>
					<option value='06'>06</option>
					<option value='07'>07</option>
					<option value='08'>08</option>
					<option value='09'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					<option value='21'>21</option>
					<option value='22'>22</option>
					<option value='23'>23</option>
				</select>
				<select name='minute'>
					<option value='00'>00</option>
					<option value='05'>05</option>
					<option value='10'>10</option>
					<option value='15'>15</option>
					<option value='20'>20</option>
					<option value='25'>25</option>
					<option value='30'>30</option>
					<option value='35'>35</option>
					<option value='40'>40</option>
					<option value='45'>45</option>
					<option value='50'>50</option>
					<option value='55'>55</option>
				</select>
			</div>
				<input type="submit" name="submit" id="submit" value="提交" />
		</div>
	</from>
<?php		
if( isset($_REQUEST['submit']) ) {
    $text = $_REQUEST['text'];
    $time = mktime($_POST['hour'],$_POST['minute'],0,$_POST['month'],$_POST['day'],$_POST['year']);
    if( strlen(isset($text))>= 140 ){
			echo "<p id='tiao' disabled='true'>不能发送！&nbsp;&nbsp;&nbsp;<span id='span'>5</span>秒后自动跳转</p>
 				<script type='text/javascript'>
 					var seconds = 0; 
 					setInterval(function(){   
 						seconds += 1;
						document.getElementById('span').innerHTML = 5-seconds; 
  						if(seconds == 5){
  							document.getElementById('tiao').disabled = false;
  							window.location='login.html';
  						} 
  					},1000); 
			</script>";
	}
    $text = trim($text);
    if( (!empty($text)) && (!empty($time)) ) {
        if($time == 1390147200){
			//默认时间，表示即时发微博
			$ret = $c->update( $text );	
			if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
				echo "<p>发送失败，错误：{$ret['error_code']}:{$ret['error']}</p>";
			} else {
				echo "<p>发送成功</p>";
			}
		}else{
			if($time >= $dateArray['0'] ){
                require('config/databaseConfig.php');
				$sql = "insert into test(`id`,`text`,`time`) values('','$text','$time');";
				$resqult = mysql_query($sql);
				if(mysql_insert_id()){
					echo '插入数据成功！';
				}else{
					echo '失败了';
				}
			}else{
				exit;
			}
		}
    }else{
        exit;
    }
}
?>

<?php if( is_array( $ms['statuses'] ) ): ?>
<?php foreach( $ms['statuses'] as $item ): ?>
<div style="padding:10px;margin:5px;border:1px solid #ccc;float:left;">
	<?=$item['text'];?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</body>
 <script type="text/javascript" src="JS/jquery-1.7.1.min.js"></script>
 <script type="text/javascript" src="JS/input.js"></script>
</html>

