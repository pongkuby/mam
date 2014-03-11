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
$aid = $_POST['app_id'];
$uid = $_POST['uid'];
$app_type_id = $_POST['app_type_id'];
$app_subject = $_POST['app_subject'];
$app_place = $_POST['app_place'];
$app_detail = $_POST['app_detail'];
$app_start_date = $_POST['startdate_y']."-".$_POST['startdate_m']."-".$_POST['startdate_d'];
$app_end_date = $_POST['enddate_y']."-".$_POST['enddate_m']."-".$_POST['enddate_d'];
$app_start_time = $_POST['startdate_time'];
$app_end_time = $_POST['enddate_time'];
$app_status = $_POST['app_status'];

$app_modified_date = date("Y-m-d H:i:s");

$sql[0] = "update appointment set app_type_id='$app_type_id' where app_id='$aid' ";
$sql[1] = "update appointment set app_subject='$app_subject' where app_id='$aid' ";
$sql[2] = "update appointment set app_place='$app_place' where app_id='$aid' ";
$sql[3] = "update appointment set app_detail='$app_detail' where app_id='$aid' ";
$sql[4] = "update appointment set app_start_date='$app_start_date' where app_id='$aid' ";
$sql[5] = "update appointment set app_end_date='$app_end_date' where app_id='$aid' ";
$sql[6] = "update appointment set app_start_time='$app_start_time' where app_id='$aid' ";
$sql[7] = "update appointment set app_end_time='$app_end_time' where app_id='$aid' ";
$sql[8] = "update appointment set app_status='$app_status' where app_id='$aid' ";



for($i=0;$i<9;$i++) {
    $result = mysql_query($sql[$i]);
	echo mysql_error();
}



if($app_status == 3)
{

    $sql_del = "delete from appointment_show where app_id=$aid";
    $result_del = mysql_query($sql_del);


    $mam_co = $_POST['mam_co'];

    for ($i=0 ; $i<count($_POST['mam_co']) ; $i++)
    {
	     $emp_id_tmp = $mam_co[$i];
	
         $insert2 ="insert into appointment_show (app_show_id,app_id,emp_id) VALUES (NULL,'$aid','$emp_id_tmp')";

         $result2 = mysql_query($insert2);

         echo mysql_error();
    }
}





if($result) { 
?>  
  <br><center><font color=green><b>แก้ไขการนัดหมายเรียบร้อยแล้ว !!</b></font><br><br><a href="javascript:window.location='edit_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>';" data-role="button">ตกลง</a></center>
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
