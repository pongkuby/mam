<?
include "dbconfig.php";
conndb();
error_reporting (E_ALL ^ E_NOTICE);

$aid = $_GET['aid'];
$uid = $_GET['uid'];
$currentview = $_GET['currentview'];


$strSQL_chk = "SELECT * FROM appointment_emp WHERE (app_id = '$aid') AND (emp_id = '$uid')";
$result_chk = mysql_query($strSQL_chk);
$row_chk = mysql_fetch_array($result_chk);

if ($row_chk['approve_status'] == 0)
{
   $sql_update_chk = "update appointment_emp set approve_status='3' WHERE (app_id = '$aid') AND (emp_id = '$uid')";
   $result_update_chk = mysql_query($sql_update_chk);
}






$strSQL1 = "SELECT * FROM appointment WHERE app_id = '$aid'";
$result1 = mysql_query($strSQL1);
$row = mysql_fetch_array($result1);

$date_tmp_use_st = convert_date($row['app_start_date']);
$date_tmp_use_end = convert_date($row['app_end_date']);

function convert_date($date_tmp)
{
    $date_tmp_arr = explode("-",$date_tmp);

    return $date_tmp_arr;
}


function get_fullname($uid_tmp)
{
    $strSQL_chk = "SELECT * FROM employee WHERE emp_id = '$uid_tmp'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
	$total_chk = mysql_num_rows($result_chk);

	return $row_chk['first_name']." ".$row_chk['last_name'];
}

function chk_in_meeting($uid_tmp,$aid_tmp)
{
    $strSQL_chk = "SELECT * FROM appointment_emp WHERE (app_id = '$aid_tmp') AND (emp_id = '$uid_tmp')";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
	$total_chk = mysql_num_rows($result_chk);

	return $total_chk;
}

function approve_name($approve_status)
{
    if($approve_status == 0)
    	return "  -> ยังไม่ยืนยัน";
    if($approve_status == 1)
    	return "  -> ยืนยันการเข้าร่วม";
    if($approve_status == 2)
    	return "  -> ไม่เข้าร่วม";		
    if($approve_status == 3)
    	return "  -> ยังไม่ยืนยัน";	
}

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

<script Language="Javascript">
<!--
function Conf(object) {
              if (confirm("โปรดยืนยันการลบ ?") == true) {
          return true;
                }
          return false;
                }
//-->
</script>

</head>

<body>

<!-- Start of first page: #one


 -->
<div data-role="page" id="one">

	<div data-role="header" data-theme="b" data-position="fixed">
<!--	    <a href="../index.html?uid=--><?//=$uid; ?><!--" data-icon="back" target="_self">ย้อนกลับ</a>-->

        <a href="javascript:window.location='../index.html?uid=<?=$uid; ?>&currentview=<?=$currentview; ?>';" data-icon="back">Back</a>
		<h1>ข้อมูลการนัดหมาย</h1>
		
		<?
		if(chk_in_meeting($uid,$aid) > 0)
		{
		?>
		
		<div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
			<a href="javascript:window.location='edit_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>';" data-role="button" data-icon="gear">แก้ไข</a>
			<a OnClick="return Conf(this)" href="javascript:window.location='delete_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>';" data-role="button" data-icon="delete">ลบ</a>
		</div>
		
		<?
		}
		?>
	
		
		</div><!-- /header -->

	<div data-role="content" >
		

<div data-role="fieldcontain">

    <label for="name"><b>ประเภทการนัดหมาย : </b></label><br>

    <select name="app_type_id" id="app_type_id" data-native-menu="false">
	<?
$sql_lookup_text = "SELECT * FROM appointment_type ORDER BY app_type_id";
$result_lookup = mysql_query($sql_lookup_text);
While($row_lookup = mysql_fetch_array($result_lookup)){
  
   if($row_lookup['app_type_id'] == $row['app_type_id'])
     echo "<option value=\"".$row_lookup['app_type_id']."\" selected disabled=\"disabled\">".$row_lookup['app_type_name']."</option>\n";
   else
     echo "<option value=\"".$row_lookup['app_type_id']."\" disabled=\"disabled\">".$row_lookup['app_type_name']."</option>\n";
	 
}
    ?>
    </select>
</div>

<div data-role="fieldcontain">
    <label for="name"><b>หัวข้อการนัดหมาย : </b></label><br>
    <input readonly="1" type="text" name="app_subject" id="app_subject" value="<?=$row['app_subject']; ?>" />
</div>

<div data-role="fieldcontain">
    <label for="name"><b>สถานที่ประชุม : </b></label><br>
    <input readonly="1" type="text" name="app_place" id="app_place" value="<?=$row['app_place']; ?>" />
</div>

<div data-role="fieldcontain">
    <label for="name"><b>รายละเอียด : </b></label><br>
    <textarea name="app_detail" id="app_detail" readonly="1"><?=$row['app_detail']; ?></textarea>
</div>

<div data-role="fieldcontain">
    <label for="name"><b>วันเวลา เริ่มต้น : </b></label><br>
		<fieldset data-role="controlgroup" data-type="horizontal">
	<select name="startdate_d" id="startdate_d">
			<option value="" disabled="disabled">วันที่</option>
			<option value="01" <? if($date_tmp_use_st[2] == "01") echo "selected"; echo " disabled=\"disabled\""; ?>>01</option>
			<option value="02" <? if($date_tmp_use_st[2] == "02") echo "selected"; echo " disabled=\"disabled\""; ?>>02</option>
			<option value="03" <? if($date_tmp_use_st[2] == "03") echo "selected"; echo " disabled=\"disabled\""; ?>>03</option>
			<option value="04" <? if($date_tmp_use_st[2] == "04") echo "selected"; echo " disabled=\"disabled\""; ?>>04</option>
			<option value="05" <? if($date_tmp_use_st[2] == "05") echo "selected"; echo " disabled=\"disabled\""; ?>>05</option>
			<option value="06" <? if($date_tmp_use_st[2] == "06") echo "selected"; echo " disabled=\"disabled\""; ?>>06</option>
			<option value="07" <? if($date_tmp_use_st[2] == "07") echo "selected"; echo " disabled=\"disabled\""; ?>>07</option>
			<option value="08" <? if($date_tmp_use_st[2] == "08") echo "selected"; echo " disabled=\"disabled\""; ?>>08</option>
			<option value="09" <? if($date_tmp_use_st[2] == "09") echo "selected"; echo " disabled=\"disabled\""; ?>>09</option>
			<option value="10" <? if($date_tmp_use_st[2] == "10") echo "selected"; echo " disabled=\"disabled\""; ?>>10</option>
			<option value="11" <? if($date_tmp_use_st[2] == "11") echo "selected"; echo " disabled=\"disabled\""; ?>>11</option>
			<option value="12" <? if($date_tmp_use_st[2] == "12") echo "selected"; echo " disabled=\"disabled\""; ?>>12</option>
			<option value="13" <? if($date_tmp_use_st[2] == "13") echo "selected"; echo " disabled=\"disabled\""; ?>>13</option>
			<option value="14" <? if($date_tmp_use_st[2] == "14") echo "selected"; echo " disabled=\"disabled\""; ?>>14</option>
			<option value="15" <? if($date_tmp_use_st[2] == "15") echo "selected"; echo " disabled=\"disabled\""; ?>>15</option>
			<option value="16" <? if($date_tmp_use_st[2] == "16") echo "selected"; echo " disabled=\"disabled\""; ?>>16</option>
			<option value="17" <? if($date_tmp_use_st[2] == "17") echo "selected"; echo " disabled=\"disabled\""; ?>>17</option>
			<option value="18" <? if($date_tmp_use_st[2] == "18") echo "selected"; echo " disabled=\"disabled\""; ?>>18</option>
			<option value="19" <? if($date_tmp_use_st[2] == "19") echo "selected"; echo " disabled=\"disabled\""; ?>>19</option>
			<option value="20" <? if($date_tmp_use_st[2] == "20") echo "selected"; echo " disabled=\"disabled\""; ?>>20</option>
			<option value="21" <? if($date_tmp_use_st[2] == "21") echo "selected"; echo " disabled=\"disabled\""; ?>>21</option>
			<option value="22" <? if($date_tmp_use_st[2] == "22") echo "selected"; echo " disabled=\"disabled\""; ?>>22</option>
			<option value="23" <? if($date_tmp_use_st[2] == "23") echo "selected"; echo " disabled=\"disabled\""; ?>>23</option>
			<option value="24" <? if($date_tmp_use_st[2] == "24") echo "selected"; echo " disabled=\"disabled\""; ?>>24</option>
			<option value="25" <? if($date_tmp_use_st[2] == "25") echo "selected"; echo " disabled=\"disabled\""; ?>>25</option>
			<option value="26" <? if($date_tmp_use_st[2] == "26") echo "selected"; echo " disabled=\"disabled\""; ?>>26</option>
			<option value="27" <? if($date_tmp_use_st[2] == "27") echo "selected"; echo " disabled=\"disabled\""; ?>>27</option>
			<option value="28" <? if($date_tmp_use_st[2] == "28") echo "selected"; echo " disabled=\"disabled\""; ?>>28</option>
			<option value="29" <? if($date_tmp_use_st[2] == "29") echo "selected"; echo " disabled=\"disabled\""; ?>>29</option>
			<option value="30" <? if($date_tmp_use_st[2] == "30") echo "selected"; echo " disabled=\"disabled\""; ?>>30</option>
			<option value="31" <? if($date_tmp_use_st[2] == "31") echo "selected"; echo " disabled=\"disabled\""; ?>>31</option>
	</select><select name="startdate_m" id="startdate_m">
			<option value="" disabled="disabled">เดือน</option>
			<option value="01" <? if($date_tmp_use_st[1] == "01") echo "selected"; echo " disabled=\"disabled\""; ?>>มกราคม</option>
			<option value="02" <? if($date_tmp_use_st[1] == "02") echo "selected"; echo " disabled=\"disabled\""; ?>>กุมภาพันธ์</option>
			<option value="03" <? if($date_tmp_use_st[1] == "03") echo "selected"; echo " disabled=\"disabled\""; ?>>มีนาคม</option>
			<option value="04" <? if($date_tmp_use_st[1] == "04") echo "selected"; echo " disabled=\"disabled\""; ?>>เมษายน</option>
			<option value="05" <? if($date_tmp_use_st[1] == "05") echo "selected"; echo " disabled=\"disabled\""; ?>>พฤษภาคม</option>
			<option value="06" <? if($date_tmp_use_st[1] == "06") echo "selected"; echo " disabled=\"disabled\""; ?>>มิถุนายน</option>
			<option value="07" <? if($date_tmp_use_st[1] == "07") echo "selected"; echo " disabled=\"disabled\""; ?>>กรกฎาคม</option>
			<option value="08" <? if($date_tmp_use_st[1] == "08") echo "selected"; echo " disabled=\"disabled\""; ?>>สิงหาคม</option>
			<option value="09" <? if($date_tmp_use_st[1] == "09") echo "selected"; echo " disabled=\"disabled\""; ?>>กันยายน</option>
			<option value="10" <? if($date_tmp_use_st[1] == "10") echo "selected"; echo " disabled=\"disabled\""; ?>>ตุลาคม</option>
			<option value="11" <? if($date_tmp_use_st[1] == "11") echo "selected"; echo " disabled=\"disabled\""; ?>>พฤศจิกายน</option>
			<option value="12" <? if($date_tmp_use_st[1] == "12") echo "selected"; echo " disabled=\"disabled\""; ?>>ธันวาคม</option>
		</select><select name="startdate_y" id="startdate_y">
			<option value="" disabled="disabled">ปี พ.ศ.</option>
			<option value="2013" <? if($date_tmp_use_st[0] == "2013") echo "selected"; echo " disabled=\"disabled\""; ?>>2556</option>
			<option value="2014" <? if($date_tmp_use_st[0] == "2014") echo "selected"; echo " disabled=\"disabled\""; ?>>2557</option>
		</select><select name="startdate_time" id="startdate_time">
		<option value="" disabled="disabled">เวลา</option>

<option value="00:00:00" <? if($row['app_start_time'] == "00:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>00:00</option>
<option value="00:30:00" <? if($row['app_start_time'] == "00:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>00:30</option>				
<option value="01:00:00" <? if($row['app_start_time'] == "01:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>01:00</option>
<option value="01:30:00" <? if($row['app_start_time'] == "01:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>01:30</option>			
<option value="02:00:00" <? if($row['app_start_time'] == "02:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>02:00</option>
<option value="02:30:00" <? if($row['app_start_time'] == "02:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>02:30</option>			
<option value="03:00:00" <? if($row['app_start_time'] == "03:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>03:00</option>
<option value="03:30:00" <? if($row['app_start_time'] == "03:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>03:30</option>	
<option value="04:00:00" <? if($row['app_start_time'] == "04:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>04:00</option>
<option value="04:30:00" <? if($row['app_start_time'] == "04:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>04:30</option>		
<option value="05:00:00" <? if($row['app_start_time'] == "05:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>05:00</option>		
<option value="05:30:00" <? if($row['app_start_time'] == "05:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>05:30</option>		
<option value="06:00:00" <? if($row['app_start_time'] == "06:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>06:00</option>		
<option value="06:30:00" <? if($row['app_start_time'] == "06:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>06:30</option>		
<option value="07:00:00" <? if($row['app_start_time'] == "07:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>07:00</option>		
<option value="07:30:00" <? if($row['app_start_time'] == "07:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>07:30</option>		
<option value="08:00:00" <? if($row['app_start_time'] == "08:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>08:00</option>		
<option value="08:30:00" <? if($row['app_start_time'] == "08:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>08:30</option>
<option value="09:00:00" <? if($row['app_start_time'] == "09:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>09:00</option>
<option value="09:30:00" <? if($row['app_start_time'] == "09:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>09:30</option>
<option value="10:00:00" <? if($row['app_start_time'] == "10:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>10:00</option>
<option value="10:30:00" <? if($row['app_start_time'] == "10:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>10:30</option>
<option value="11:00:00" <? if($row['app_start_time'] == "11:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>11:00</option>
<option value="11:30:00" <? if($row['app_start_time'] == "11:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>11:30</option>
<option value="12:00:00" <? if($row['app_start_time'] == "12:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>12:00</option>
<option value="12:30:00" <? if($row['app_start_time'] == "12:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>12:30</option>
<option value="13:00:00" <? if($row['app_start_time'] == "13:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>13:00</option>
<option value="13:30:00" <? if($row['app_start_time'] == "13:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>13:30</option>
<option value="14:00:00" <? if($row['app_start_time'] == "14:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>14:00</option>
<option value="14:30:00" <? if($row['app_start_time'] == "14:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>14:30</option>
<option value="15:00:00" <? if($row['app_start_time'] == "15:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>15:00</option>
<option value="15:30:00" <? if($row['app_start_time'] == "15:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>15:30</option>
<option value="16:00:00" <? if($row['app_start_time'] == "16:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>16:00</option>
<option value="16:30:00" <? if($row['app_start_time'] == "16:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>16:30</option>
<option value="17:00:00" <? if($row['app_start_time'] == "17:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>17:00</option>
<option value="17:30:00" <? if($row['app_start_time'] == "17:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>17:30</option>
<option value="18:00:00" <? if($row['app_start_time'] == "18:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>18:00</option>
<option value="18:30:00" <? if($row['app_start_time'] == "18:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>18:30</option>
<option value="19:00:00" <? if($row['app_start_time'] == "19:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>19:00</option>
<option value="19:30:00" <? if($row['app_start_time'] == "19:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>19:30</option>
<option value="20:00:00" <? if($row['app_start_time'] == "20:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>20:00</option>
<option value="20:30:00" <? if($row['app_start_time'] == "20:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>20:30</option>
<option value="21:00:00" <? if($row['app_start_time'] == "21:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>21:00</option>
<option value="21:30:00" <? if($row['app_start_time'] == "21:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>21:30</option>
<option value="22:00:00" <? if($row['app_start_time'] == "22:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>22:00</option>
<option value="22:30:00" <? if($row['app_start_time'] == "22:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>22:30</option>
<option value="23:00:00" <? if($row['app_start_time'] == "23:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>23:00</option>
<option value="23:30:00" <? if($row['app_start_time'] == "23:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>23:30</option>

		
		
		</select>
		
	</fieldset>	
</div>


<div data-role="fieldcontain">
    <label for="name"><b>วันเวลา สิ้นสุด : </b></label><br>
	<fieldset data-role="controlgroup" data-type="horizontal">
	<select name="enddate_d" id="enddate_d">
			<option value="" disabled="disabled">วันที่</option>
			<option value="01" <? if($date_tmp_use_end[2] == "01") echo "selected"; echo " disabled=\"disabled\""; ?>>01</option>
			<option value="02" <? if($date_tmp_use_end[2] == "02") echo "selected"; echo " disabled=\"disabled\""; ?>>02</option>
			<option value="03" <? if($date_tmp_use_end[2] == "03") echo "selected"; echo " disabled=\"disabled\""; ?>>03</option>
			<option value="04" <? if($date_tmp_use_end[2] == "04") echo "selected"; echo " disabled=\"disabled\""; ?>>04</option>
			<option value="05" <? if($date_tmp_use_end[2] == "05") echo "selected"; echo " disabled=\"disabled\""; ?>>05</option>
			<option value="06" <? if($date_tmp_use_end[2] == "06") echo "selected"; echo " disabled=\"disabled\""; ?>>06</option>
			<option value="07" <? if($date_tmp_use_end[2] == "07") echo "selected"; echo " disabled=\"disabled\""; ?>>07</option>
			<option value="08" <? if($date_tmp_use_end[2] == "08") echo "selected"; echo " disabled=\"disabled\""; ?>>08</option>
			<option value="09" <? if($date_tmp_use_end[2] == "09") echo "selected"; echo " disabled=\"disabled\""; ?>>09</option>
			<option value="10" <? if($date_tmp_use_end[2] == "10") echo "selected"; echo " disabled=\"disabled\""; ?>>10</option>
			<option value="11" <? if($date_tmp_use_end[2] == "11") echo "selected"; echo " disabled=\"disabled\""; ?>>11</option>
			<option value="12" <? if($date_tmp_use_end[2] == "12") echo "selected"; echo " disabled=\"disabled\""; ?>>12</option>
			<option value="13" <? if($date_tmp_use_end[2] == "13") echo "selected"; echo " disabled=\"disabled\""; ?>>13</option>
			<option value="14" <? if($date_tmp_use_end[2] == "14") echo "selected"; echo " disabled=\"disabled\""; ?>>14</option>
			<option value="15" <? if($date_tmp_use_end[2] == "15") echo "selected"; echo " disabled=\"disabled\""; ?>>15</option>
			<option value="16" <? if($date_tmp_use_end[2] == "16") echo "selected"; echo " disabled=\"disabled\""; ?>>16</option>
			<option value="17" <? if($date_tmp_use_end[2] == "17") echo "selected"; echo " disabled=\"disabled\""; ?>>17</option>
			<option value="18" <? if($date_tmp_use_end[2] == "18") echo "selected"; echo " disabled=\"disabled\""; ?>>18</option>
			<option value="19" <? if($date_tmp_use_end[2] == "19") echo "selected"; echo " disabled=\"disabled\""; ?>>19</option>
			<option value="20" <? if($date_tmp_use_end[2] == "20") echo "selected"; echo " disabled=\"disabled\""; ?>>20</option>
			<option value="21" <? if($date_tmp_use_end[2] == "21") echo "selected"; echo " disabled=\"disabled\""; ?>>21</option>
			<option value="22" <? if($date_tmp_use_end[2] == "22") echo "selected"; echo " disabled=\"disabled\""; ?>>22</option>
			<option value="23" <? if($date_tmp_use_end[2] == "23") echo "selected"; echo " disabled=\"disabled\""; ?>>23</option>
			<option value="24" <? if($date_tmp_use_end[2] == "24") echo "selected"; echo " disabled=\"disabled\""; ?>>24</option>
			<option value="25" <? if($date_tmp_use_end[2] == "25") echo "selected"; echo " disabled=\"disabled\""; ?>>25</option>
			<option value="26" <? if($date_tmp_use_end[2] == "26") echo "selected"; echo " disabled=\"disabled\""; ?>>26</option>
			<option value="27" <? if($date_tmp_use_end[2] == "27") echo "selected"; echo " disabled=\"disabled\""; ?>>27</option>
			<option value="28" <? if($date_tmp_use_end[2] == "28") echo "selected"; echo " disabled=\"disabled\""; ?>>28</option>
			<option value="29" <? if($date_tmp_use_end[2] == "29") echo "selected"; echo " disabled=\"disabled\""; ?>>29</option>
			<option value="30" <? if($date_tmp_use_end[2] == "30") echo "selected"; echo " disabled=\"disabled\""; ?>>30</option>
			<option value="31" <? if($date_tmp_use_end[2] == "31") echo "selected"; echo " disabled=\"disabled\""; ?>>31</option>
	</select><select name="enddate_m" id="enddate_m">
			<option value="" disabled="disabled">เดือน</option>
			<option value="01" <? if($date_tmp_use_end[1] == "01") echo "selected"; echo " disabled=\"disabled\""; ?>>มกราคม</option>
			<option value="02" <? if($date_tmp_use_end[1] == "02") echo "selected"; echo " disabled=\"disabled\""; ?>>กุมภาพันธ์</option>
			<option value="03" <? if($date_tmp_use_end[1] == "03") echo "selected"; echo " disabled=\"disabled\""; ?>>มีนาคม</option>
			<option value="04" <? if($date_tmp_use_end[1] == "04") echo "selected"; echo " disabled=\"disabled\""; ?>>เมษายน</option>
			<option value="05" <? if($date_tmp_use_end[1] == "05") echo "selected"; echo " disabled=\"disabled\""; ?>>พฤษภาคม</option>
			<option value="06" <? if($date_tmp_use_end[1] == "06") echo "selected"; echo " disabled=\"disabled\""; ?>>มิถุนายน</option>
			<option value="07" <? if($date_tmp_use_end[1] == "07") echo "selected"; echo " disabled=\"disabled\""; ?>>กรกฎาคม</option>
			<option value="08" <? if($date_tmp_use_end[1] == "08") echo "selected"; echo " disabled=\"disabled\""; ?>>สิงหาคม</option>
			<option value="09" <? if($date_tmp_use_end[1] == "09") echo "selected"; echo " disabled=\"disabled\""; ?>>กันยายน</option>
			<option value="10" <? if($date_tmp_use_end[1] == "10") echo "selected"; echo " disabled=\"disabled\""; ?>>ตุลาคม</option>
			<option value="11" <? if($date_tmp_use_end[1] == "11") echo "selected"; echo " disabled=\"disabled\""; ?>>พฤศจิกายน</option>
			<option value="12" <? if($date_tmp_use_end[1] == "12") echo "selected"; echo " disabled=\"disabled\""; ?>>ธันวาคม</option>
		</select><select name="enddate_y" id="enddate_y">
			<option value="" disabled="disabled">ปี พ.ศ.</option>
			<option value="2013" <? if($date_tmp_use_end[0] == "2013") echo "selected"; echo " disabled=\"disabled\""; ?>>2556</option>
			<option value="2014" <? if($date_tmp_use_end[0] == "2014") echo "selected"; echo " disabled=\"disabled\""; ?>>2557</option>
		</select><select name="enddate_time" id="enddate_time">
		<option value="" disabled="disabled">เวลา</option>
<option value="00:00:00" <? if($row['app_end_time'] == "00:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>00:00</option>
<option value="00:30:00" <? if($row['app_end_time'] == "00:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>00:30</option>				
<option value="01:00:00" <? if($row['app_end_time'] == "01:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>01:00</option>
<option value="01:30:00" <? if($row['app_end_time'] == "01:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>01:30</option>			
<option value="02:00:00" <? if($row['app_end_time'] == "02:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>02:00</option>
<option value="02:30:00" <? if($row['app_end_time'] == "02:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>02:30</option>			
<option value="03:00:00" <? if($row['app_end_time'] == "03:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>03:00</option>
<option value="03:30:00" <? if($row['app_end_time'] == "03:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>03:30</option>	
<option value="04:00:00" <? if($row['app_end_time'] == "04:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>04:00</option>
<option value="04:30:00" <? if($row['app_end_time'] == "04:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>04:30</option>		
<option value="05:00:00" <? if($row['app_end_time'] == "05:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>05:00</option>		
<option value="05:30:00" <? if($row['app_end_time'] == "05:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>05:30</option>		
<option value="06:00:00" <? if($row['app_end_time'] == "06:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>06:00</option>		
<option value="06:30:00" <? if($row['app_end_time'] == "06:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>06:30</option>		
<option value="07:00:00" <? if($row['app_end_time'] == "07:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>07:00</option>		
<option value="07:30:00" <? if($row['app_end_time'] == "07:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>07:30</option>		
<option value="08:00:00" <? if($row['app_end_time'] == "08:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>08:00</option>		
<option value="08:30:00" <? if($row['app_end_time'] == "08:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>08:30</option>
<option value="09:00:00" <? if($row['app_end_time'] == "09:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>09:00</option>
<option value="09:30:00" <? if($row['app_end_time'] == "09:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>09:30</option>
<option value="10:00:00" <? if($row['app_end_time'] == "10:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>10:00</option>
<option value="10:30:00" <? if($row['app_end_time'] == "10:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>10:30</option>
<option value="11:00:00" <? if($row['app_end_time'] == "11:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>11:00</option>
<option value="11:30:00" <? if($row['app_end_time'] == "11:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>11:30</option>
<option value="12:00:00" <? if($row['app_end_time'] == "12:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>12:00</option>
<option value="12:30:00" <? if($row['app_end_time'] == "12:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>12:30</option>
<option value="13:00:00" <? if($row['app_end_time'] == "13:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>13:00</option>
<option value="13:30:00" <? if($row['app_end_time'] == "13:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>13:30</option>
<option value="14:00:00" <? if($row['app_end_time'] == "14:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>14:00</option>
<option value="14:30:00" <? if($row['app_end_time'] == "14:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>14:30</option>
<option value="15:00:00" <? if($row['app_end_time'] == "15:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>15:00</option>
<option value="15:30:00" <? if($row['app_end_time'] == "15:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>15:30</option>
<option value="16:00:00" <? if($row['app_end_time'] == "16:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>16:00</option>
<option value="16:30:00" <? if($row['app_end_time'] == "16:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>16:30</option>
<option value="17:00:00" <? if($row['app_end_time'] == "17:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>17:00</option>
<option value="17:30:00" <? if($row['app_end_time'] == "17:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>17:30</option>
<option value="18:00:00" <? if($row['app_end_time'] == "18:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>18:00</option>
<option value="18:30:00" <? if($row['app_end_time'] == "18:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>18:30</option>
<option value="19:00:00" <? if($row['app_end_time'] == "19:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>19:00</option>
<option value="19:30:00" <? if($row['app_end_time'] == "19:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>19:30</option>
<option value="20:00:00" <? if($row['app_end_time'] == "20:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>20:00</option>
<option value="20:30:00" <? if($row['app_end_time'] == "20:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>20:30</option>
<option value="21:00:00" <? if($row['app_end_time'] == "21:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>21:00</option>
<option value="21:30:00" <? if($row['app_end_time'] == "21:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>21:30</option>
<option value="22:00:00" <? if($row['app_end_time'] == "22:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>22:00</option>
<option value="22:30:00" <? if($row['app_end_time'] == "22:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>22:30</option>
<option value="23:00:00" <? if($row['app_end_time'] == "23:00:00") echo "selected"; echo " disabled=\"disabled\""; ?>>23:00</option>
<option value="23:30:00" <? if($row['app_end_time'] == "23:30:00") echo "selected"; echo " disabled=\"disabled\""; ?>>23:30</option>
	</select>
		
	</fieldset>
</div>


<?

$strSQL_sel = "SELECT * FROM appointment_emp WHERE app_id='$aid' ORDER BY app_emp_id";
$result_sel = mysql_query($strSQL_sel);

$no = 1;
While($row_sel = mysql_fetch_array($result_sel)){

   $app_person .= $no.".) ".get_fullname($row_sel['emp_id'])." ".approve_name($row_sel['approve_status'])."\n";

   $no++;
   
}

?>


<div data-role="fieldcontain">
    <label for="name"><b>รายชื่อผู้เข้าประชุม : </b></label><br>
    <textarea name="app_person" id="app_person" readonly="1"><?=$app_person; ?></textarea>
</div>


<?

$strSQL_file = "SELECT * FROM appointment_upload WHERE up_app_id = '$aid' ORDER BY up_id";
$result_file = mysql_query($strSQL_file);
$total_file = mysql_num_rows($result_file);

if($total_file != 0)
{
?>


<div data-role="fieldcontain">
    <label for="name"><b>ไฟล์แนบ : </b></label><br>
<?


	
	if($total_file == 0)
	{
?>
<a href="#" data-role="button" data-icon="info" disabled>ไม่มีไฟล์แนบ</a>
<?	
	}
	
    while($row_file = mysql_fetch_array($result_file))
	{
?>
	<a href="viewdoc.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>&currentview=<?=$currentview; ?>" data-role="button" data-icon="info"><?=$row_file['up_old_name']; ?> เมื่อ <?=$row_file['up_date']; ?></a>
<?	
    }	
?>
	
</div>

<?
}
?>




<div data-role="fieldcontain">
	
<div data-role="controlgroup" data-type="vertical" >
<center>
<a href="approve_meeting.php?aid=<?=$aid;?>&uid=<?=$uid;?>&status=1" data-role="button" <? if($row_chk['approve_status'] == 1) echo "data-icon=\"check\""; ?> style="background: #56A00E; color: white;">เข้าร่วม</a> <a href="approve_meeting.php?aid=<?=$aid;?>&uid=<?=$uid;?>&status=2" data-role="button" <? if($row_chk['approve_status'] == 2) echo "data-icon=\"check\""; ?> style="background: #b43d3d; color: white;">ไม่เข้าร่วม</a>
</center>
</div>
</div>


		
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


</body>
</html>
