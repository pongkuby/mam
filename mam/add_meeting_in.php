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
		<h1>การสร้างการนัดหมาย</h1>
	</div><!-- /header -->

	<div data-role="content" >
		
<?
$owner_empID = $_POST['owner_empID'];
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

$join_status = $_POST['join_status'];

$filename_original = $_FILES['filesattach_name']['name'];
$filename = $_FILES['filesattach_name']['name'];
$dot_position = strrpos($filename,".");
$file_type = substr($filename,0-(strlen($filename)-$dot_position));

$now_str = date("YmdHis");

$filename = $now_str.$file_type;

$path = "../resources/upload/";
$max_size = 4194304; // ขนาดภาพสูงสุด (Byte)


if (is_uploaded_file($_FILES['filesattach_name']['tmp_name'])) {

        if ($_FILES['filesattach_name']['size']>$max_size) {
                echo "<center><font size=\"5\" color=\"#800000\">Error !! Your file has over 4 MB .</font></center>"; exit; }

        if (file_exists($path . $_FILES['filesattach_name']['name'])) {
                      echo "<center><font size=\"5\" color=\"#800000\">Error !! Your file has already exists name, Pleasy change filename .</font></center><br>\n"; exit; }

        $res = copy($_FILES['filesattach_name']['tmp_name'], $path.$filename);
        if (!$res) { echo "<center><font size=\"5\" color=\"#800000\">Error !! Cann't upload your file</font></center><br>\n"; exit; } 

}
else
{
    $filename = "nofile.jpg";
}



$insertp ="insert into appointment (app_id,app_type_id,app_subject,app_start_date,app_end_date,app_start_time,app_end_time,app_place,app_detail,app_status,app_all_day,app_repeat,app_day_of_week,app_repeat_month,app_modified_date,owner_org,owner_empID) 
VALUES (NULL,'$app_type_id','$app_subject','$app_start_date','$app_end_date','$app_start_time','$app_end_time','$app_place','$app_detail','$app_status',NULL,NULL,NULL,NULL,'$app_modified_date',NULL,'$owner_empID')";

$result = mysql_query($insertp);

echo mysql_error();


$app_id = mysql_insert_id();


if($filename != "nofile.jpg")
{
    $up_date = date("Y-m-d H:i:s");

    $insert_up ="insert into appointment_upload (up_id,up_app_id,up_name,up_old_name,up_date) VALUES (NULL,'$app_id','$filename','$filename_original','$up_date')";
    $result_up = mysql_query($insert_up);
    echo mysql_error();	
}










if($app_status == 3)
{
    $mam_co = $_POST['mam_co'];

    for ($i=0 ; $i<count($_POST['mam_co']) ; $i++)
    {
	     $emp_id_tmp = $mam_co[$i];
		 
		 //echo $emp_id_tmp;
	
         $insert2 ="insert into appointment_show (app_show_id,app_id,emp_id) VALUES (NULL,'$app_id','$emp_id_tmp')";
         $result2 = mysql_query($insert2);
         echo mysql_error();	 
		 
		 
    }
}


$insert3 ="insert into appointment_emp (app_emp_id,app_id,emp_id) VALUES (NULL,'$app_id','$owner_empID')";
$result3 = mysql_query($insert3);
echo mysql_error();

		 
if($join_status == 2)
{
    $mam_join = $_POST['mam_join'];

    for ($i=0 ; $i<count($_POST['mam_join']) ; $i++)
    {
	     $emp_id_tmp = $mam_join[$i];
	
         $insert4 ="insert into appointment_emp (app_emp_id,app_id,emp_id) VALUES (NULL,'$app_id','$emp_id_tmp')";
         $result4 = mysql_query($insert4);
         echo mysql_error();
    }
}		 
		 



if($result) { 
?>  
  <br><center><font color=green><b>สร้างการนัดหมายเรียบร้อยแล้ว !!</b></font><br><br><a href="javascript:window.location='add_meeting.php?uid=<?=$owner_empID; ?>';" data-role="button">ตกลง</a></center>
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
