<?php
/*
Created on 2012. 5. 14.
=================================================
register
# ����� ����� ���ִ� API.
# ���α׷� ��ġ�� ���ʽ��� 1ȸ�� ȣ��.
	request :
		uuid		#�۰�����ȣ	(UUID, http://huewu.blog.me/110107222113 ����. �����ID�� ���� ����)
		phoneNum	#�����ڵ�+��ȭ��ȣ (��ȭ��ȣ ���� ���� �׳� �� ���ڿ�)
		name		#����� �̸�(����Ʈ���� ����� �� ���)
		nums[]		#�ּҷϿ� ����Ǿ��ִ� ������� �����ڵ�+��ȭ��ȣ ����Ʈ
	response :
		appKey		#����Ű��
=================================================
�ش� phoneNum�� ���� uuid�� ã�Ƽ� ��� ���̺��� ���� ���� ����
user���̺� �� ������ ����
*/
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$uuid = $_REQUEST["uuid"];
	$name = $_REQUEST["name"];
	$phoneNum = $_REQUEST["phoneNum"];
	$nums = $_REQUEST["nums"];
}else{
	// do not allow GET method
	$uuid = $_POST["uuid"];
	$name = $_POST["name"];
	$phoneNum = $_POST["phoneNum"];
	$nums = $_POST["nums"];
}
$appKey = sha1($uuid.$phoneNum."�ð����帥�ٿ�ų����ų������ų��ްų����ų�");
$rs = db_query("SELECT uuid FROM user WHERE phoneNum='".$phoneNum."'");
$old_uuid =  
$query = "DELETE FROM user WHERE uuid = (SELECT uuid FROM user WHERE phoneNum='')";
$query = "DELETE FROM user WHERE uuid = (SELECT uuid FROM user WHERE phoneNum='')";
//$result = db_query("SELECT * FROM user WHERE phoneNum='".$phoneNum."'");
//db_query("INSERT INTO user(uuid, phoneNum, appKey, name, image, imageTs, message, lon, lat, maxMaum, cntMaum, itm1, itm2, itm3) " .
//		"VALUES()"
//		);


echo $appKey;
?>
