<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
addFriendByNum
# ��ȭ��ȣ�� ģ�� �߰�
	request :
		token		#������ū
		phoneNum	#ģ����ȭ��ȣ(�����ڵ�+��ȭ��ȣ)
	response :
		uuid		#ģ���۰�����ȣ
		name		#�̸�
		message		#���踻
=================================================
 */
 
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$phoneNum = $_REQUEST["phoneNum"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$phoneNum = $_POST["phoneNum"];
}
if($token!=$HTTP_SESSION_VARS['token']){
	raise_error(102, "token�� ��ȿ���� �ʽ��ϴ�.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session�� ��ȿ���� �ʽ��ϴ�.");
	return;
}
if($phoneNum==null || $phoneNum==""){
	raise_error(0, "�ùٸ��� ���� ��ȭ��ȣ �Դϴ�.");
	return;
}

$result = ("SELECT uuid, name, message FROM user WHERE phoneNum='".$phoneNum."'");
$row = mysql_fetch_row($result);
echo "{code:1,uuid:\"".$row[0]."\",name:\"".$row[1]."\",message:\"".$row[2]."\"}";
db_query("INSERT INTO friend(uuid, fid) VALUES('".$uuid."','".$row[0]."')");
?>
