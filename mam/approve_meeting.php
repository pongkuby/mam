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
		<h1>แก้ไขข้อมูลการนัดหมาย</h1>
	</div><!-- /header -->

	<div data-role="content" >
		
<?
$aid = $_GET['aid'];
$uid = $_GET['uid'];
$status = $_GET['status'];


$sql_update = "update appointment_emp set approve_status='$status' WHERE (app_id = '$aid') AND (emp_id = '$uid')";
$result_update = mysql_query($sql_update);



if($result_update) { 
?>  
  <br><center><font color=green><b>แก้ไขการนัดหมายเรียบร้อยแล้ว !!</b></font><br><br><a href="javascript:window.location='view_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>';" data-role="button">ตกลง</a></center>
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
