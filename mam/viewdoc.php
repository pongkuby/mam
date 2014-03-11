<?
include "dbconfig.php";
conndb();
error_reporting (E_ALL ^ E_NOTICE);

$aid = $_GET['aid'];
$uid = $_GET['uid'];
$currentview = $_GET['currentview'];


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


</head>

<body>

<!-- Start of first page: #one


 -->
<div data-role="page" id="one">

	<div data-role="header" data-theme="b" data-position="fixed">
<!--	    <a href="../index.html?uid=--><?//=$uid; ?><!--" data-icon="back" target="_self">ย้อนกลับ</a>-->

        <a href="javascript:window.location='view_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>&currentview=<?=$currentview; ?>';" data-icon="back">Back</a>
		<h1>รายละเอียดไฟล์แนบ</h1>
		

	
		
		</div><!-- /header -->

	<div data-role="content" >
		



<div data-role="fieldcontain">

<?

    $strSQL_file = "SELECT * FROM appointment_upload WHERE up_app_id = '$aid' ORDER BY up_id";
    $result_file = mysql_query($strSQL_file);
	$total_file = mysql_num_rows($result_file);
	
	if($total_file == 0)
	{
?>
<a href="#" data-role="button" data-icon="info" disabled>ไม่มีไฟล์แนบ</a>
<?	
	}
	
    while($row_file = mysql_fetch_array($result_file))
	{
?>

    <iframe src="http://docs.google.com/viewer?url=http://mam.mwa.co.th/mam/resources/upload/<?=$row_file['up_name']; ?>&embedded=true" style="border: none;" width="100%" height="780" ></iframe>


<!--
	<a href="javascript:window.open('https://docs.google.com/viewer?url=http://css.mwa.co.th/mam/resources/upload/<?=$row_file['up_name']; ?>','_blank','location=yes');" data-role="button" data-icon="info" target="_blank"><?=$row_file['up_old_name']; ?> เมื่อ <?=$row_file['up_date']; ?></a>
-->
	
<?	
    }	
?>
	
</div>



		
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


</body>
</html>
