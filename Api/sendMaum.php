<?php
/*
 * Created on 2012. 5. 11.
=================================================
sendMaum
# ���� ������
	request :
		token		#������ū
		uuid		#����uuid
		mcode		#�����ڵ�
		mstring		#�������ڿ�(�����ڵ尡 800�� ��, �� ��������� ���ڿ� �϶��� ���)
		item		#������ ��ȣ(0-������, 1-�����˸�, 2-�����Ը��˸�)
		delay		#�����˸� �ð�(item ���� 1�϶��� ����. ������ �ð�) 
	response :
=================================================
 */

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$fid = $_REQUEST["uuid"];
	$mcode = $_REQUEST["mcode"];
	$mstring = $_REQUEST["mstring"];
	$item = $_REQUEST["item"];
	$delay = $_REQUEST["delay"];
}else{
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
	$mcode = $_POST["mcode"];
	$mstring = $_POST["mstring"];
	$item = $_POST["item"];
	$delay = $_POST["delay"];
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
if($item!=1){ // ������ �Ǵ� �����Ը� �˸�. delay���� �ʿ� ����
	$delay = 0;
}

// �׻���� ������ ���� ������ ������ �־��ٸ�?
if($uuid < $fid)
	$where = "WHERE (uuidA='".$uuid."' OR uuidB='".$fid."')";
else
	$where = "WHERE (uuidA='".$fid."' OR uuidB='".$uuid."')";
	
if($mcode==800){
	$where .= "AND mcode=800 AND mstring='".$mstring."'";
}else{
	$where .= "AND mcode=".$mcode;
}
$result = db_query("SELECT * FROM maum " . $where);

if(mysql_num_rows($result)>0){
	// ���� ������ update!
	$row = mysql_fetch_array($result);
	$uuidA = $row[0];
	$uuidB = $row[2];
	$delay = $delay + $row[10];
	$query = "UPDATE maum SET"; 
	if($uuidA == $uuid){	// ���� A, ������ B
		$query .= "AtoB=true, itemA=".$item.", delay=".$delay." dateInf=".($row[11]+$delay);
	}else if($uuidB == $uuid){	// ������ A, ���� B
		$query .= "BtoA=true, itemB=".$item.", delay=".$delay." dateInf=".($row[12]+$delay);
	}
	$query .= " ".$where;
	db_query($query);
}else{
	// ���ο� ������ insert!
	db_query("INSERT INTO maum");
}
?>
