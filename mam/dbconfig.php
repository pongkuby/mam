<?php

$conn;

$server = "localhost"; // �ѡ�� localhost (�ó� Host ���س��������˹��繤�����ҧ���)
$user = "mam"; // Username 㹡�õԴ��Ͱҹ������
$pass = "mam1234"; // Password 㹡�õԴ��Ͱҹ������
$dbname = "mam"; // ���Ͱҹ�����ŷ�������ҧ���

function conndb() {
  global $conn;
  global $server;
  global $user;
  global $pass;
  global $dbname;
  $conn = mysql_connect($server,$user,$pass);
mysql_query("SET NAMES utf8");
  if (!$conn)
    die("�������ö�Դ��͡Ѻ MySQL ��");

  mysql_select_db($dbname,$conn)
    or die("�������ö���͡��ҹ�ҹ��������");
}

function closedb() {
  global $conn;
  mysql_close($conn);
}



?>
