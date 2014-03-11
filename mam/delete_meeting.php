<?
include "dbconfig.php";
conndb();
error_reporting (E_ALL ^ E_NOTICE);


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Appointment on Mobile</title>
	<link rel="stylesheet"  href="css/themes/default/jquery.mobile-1.3.1.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
	<script src="js/jquery.js"></script>
	<script src="_assets/js/index.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
	
<style type="text/css"> 
    table { width:90%; }
    table caption { text-align:left;  }
    table thead th { text-align:left; border-bottom-width:1px; border-top-width:1px; }
    table th, td { text-align:left; padding:1px;} 
</style> 
	
</head>

<body>

<!-- Start of first page: #one -->
<div data-role="page" id="one">

	<div data-role="header" data-theme="b" data-position="fixed">
		<h1>ลบการนัดหมาย</h1>
	</div><!-- /header -->

	<div data-role="content" >
		
<?
$aid = $_GET['aid'];
$uid = $_GET['uid'];

$sql1 = "DELETE FROM appointment_emp where app_id='$aid' AND emp_id='$uid' ";
$result1 = mysql_query($sql1);


$strSQL_chk = "SELECT * FROM appointment_emp WHERE app_id = '$aid'";
$result_chk = mysql_query($strSQL_chk);
$row_chk = mysql_fetch_array($result_chk);
$total_chk = mysql_num_rows($result_chk);

if($total_chk == 0)
{
   $sql_del1 = "DELETE FROM appointment where app_id='$aid'";
   $result_del1 = mysql_query($sql_del1);
   
   $sql_del2 = "DELETE FROM appointment_show where app_id='$aid'";
   $result_del2 = mysql_query($sql_del2);
   
   
   $sql_select_del = "SELECT * FROM appointment_upload WHERE up_app_id='$aid'";
   $result_select_del = mysql_query($sql_select_del);
   
   while($row_select_del = mysql_fetch_array($result_select_del))
   {
      $filename_tmp = $row_select_del['up_name'];
	  unlink("../resources/upload/$filename_tmp");
   }
   
   $sql_del3 = "DELETE FROM appointment_upload where up_app_id='$aid'";
   $result_del3 = mysql_query($sql_del3);
}



if($result1) { 
?>  
  <br><center><font color=green><b>ลบการนัดหมายเรียบร้อยแล้ว !!</b></font><br><br><a href="javascript:window.location='../index.html?uid=<?=$uid; ?>';" data-role="button">ตกลง</a></center>
<?
}

?>

		
		
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


</body>
</html>
