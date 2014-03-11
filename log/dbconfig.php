<?php

$conn;

$server = "localhost"; // มักเป็น localhost (กรณี Host ที่คุณใช้ไม่ได้กำหนดเป็นค่าอย่างอื่น)
$user = "mam"; // Username ในการติดต่อฐานข้อมูล
$pass = "mam1234"; // Password ในการติดต่อฐานข้อมูล
$dbname = "mam"; // ชื่อฐานข้อมูลที่ได้สร้างไว้

function conndb() {
  global $conn;
  global $server;
  global $user;
  global $pass;
  global $dbname;
  $conn = mysql_connect($server,$user,$pass);
mysql_query("SET NAMES tis620");
  if (!$conn)
    die("ไม่สามารถติดต่อกับ MySQL ได้");

  mysql_select_db($dbname,$conn)
    or die("ไม่สามารถเลือกใช้งานฐานข้อมูลได้");
}

function closedb() {
  global $conn;
  mysql_close($conn);
}



?>
