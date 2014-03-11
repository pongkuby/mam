<?
include "dbconfig.php";
conndb();
error_reporting (E_ALL ^ E_NOTICE);

$aid = $_GET['aid'];
$uid = $_GET['uid'];

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

function get_fullname($uid)
{
    $strSQL_chk = "SELECT * FROM employee WHERE emp_id = '$uid'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
	$total_chk = mysql_num_rows($result_chk);

	return $row_chk['first_name']." ".$row_chk['last_name'];
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

	

	    <script>
		$( document ).on( "pageinit", "#one", function() {
			$( "#autocomplete" ).on( "listviewbeforefilter", function ( e, data ) {
				var $ul = $( this ),
					$input = $( data.input ),
					value = $input.val(),
					html = "";
				$ul.html( "" );
				if ( value && value.length > 2 ) {
					$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
					$ul.listview( "refresh" );
					$.ajax({
						url: "data.php",
						dataType: "json",
						async:false,
						data: {
							q: $input.val()
						}
					})
					.then( function ( response ) {
						$.each( response, function ( i, val ) {
							html += val;
						});
						$ul.html( html );
						$ul.listview( "refresh" );
						$ul.trigger( "updatelayout");
					});
				}
			});
		});
		
	
send_value2 = null;		
		
$(function() {
	  
	  function my_function(emp_id,fullname)
      {
	     //alert(emp_id);
		 
		 //$("#mam_co").append($('<option>', { 'value': emp_id,'selected': 'selected' }).text(fullname));

		 var exists = false; 
         $('#mam_co option').each(function(){
            if (this.value == emp_id) {
              exists = true;
            } 
         });
		 
		 if(!exists)
		 {
		      $("#mam_co").prepend("<option value='" + emp_id + "' selected>" + fullname + "</option>");
              $("#mam_co").selectmenu('refresh');
		 }
      }
	  
	  
	  
	  send_value2 = my_function;
	  
});
    </script>
	<style>
		.ui-listview-filter-inset {
			margin-top: 0;
		}
    </style>	
	
	
<script type="text/javascript">
function checkform ( form )
{

  if (form.app_subject.value == "") {
    alert( "โปรดกรอก หัวข้อการนัดหมาย ด้วย" );
    form.app_subject.focus();
    return false ;
  }

  if (form.app_place.value == "") {
    alert( "โปรดกรอก สถานที่ประชุม ด้วย" );
    form.app_place.focus();
    return false ;
  }

  if (form.app_detail.value == "") {
    alert( "โปรดกรอก รายละเอียด ด้วย" );
    form.app_detail.focus();
    return false ;
  }

  if (form.startdate_d.value == "") {
    alert( "โปรดกรอก วันที่เริ่มต้น ด้วย" );
    form.startdate_d.focus();
    return false ;
  }

  if (form.startdate_m.value == "") {
    alert( "โปรดกรอก เดือนเริ่มต้น ด้วย" );
    form.startdate_m.focus();
    return false ;
  }

  if (form.startdate_y.value == "") {
    alert( "โปรดกรอก ปี พ.ศ. เริ่มต้น ด้วย" );
    form.startdate_y.focus();
    return false ;
  }

  if (form.startdate_time.value == "") {
    alert( "โปรดกรอก เวลาเริ่มต้น ด้วย" );
    form.startdate_time.focus();
    return false ;
  }


  if (form.enddate_d.value == "") {
    alert( "โปรดกรอก วันที่สิ้นสุด ด้วย" );
    form.enddate_d.focus();
    return false ;
  }

  if (form.enddate_m.value == "") {
    alert( "โปรดกรอก เดือนสิ้นสุด ด้วย" );
    form.enddate_m.focus();
    return false ;
  }

  if (form.enddate_y.value == "") {
    alert( "โปรดกรอก ปี พ.ศ. สิ้นสุด ด้วย" );
    form.enddate_y.focus();
    return false ;
  }

  if (form.enddate_time.value == "") {
    alert( "โปรดกรอก เวลาสิ้นสุด ด้วย" );
    form.enddate_time.focus();
    return false ;
  }

  return true ;
}

function send_value(emp_id_tmp,fullname_tmp)
{
	send_value2(emp_id_tmp,fullname_tmp);
}

</script>

</head>

<body>

<!-- Start of first page: #one


 -->
<div data-role="page" id="one">

	<div data-role="header" data-theme="b" data-position="fixed">
	    <a href="javascript:window.location='view_meeting.php?aid=<?=$aid; ?>&uid=<?=$uid; ?>';" data-icon="back">Back</a>
		<h1>แก้ไขข้อมูลการนัดหมาย</h1>
	</div><!-- /header -->

	<div data-role="content" >
	

<form action="edit_meeting_in.php" method="post" data-ajax="false" onsubmit="return checkform(this);">	
<input type="hidden" name="app_id" id="app_id" value="<?=$aid; ?>" />
<input type="hidden" name="uid" id="uid" value="<?=$uid; ?>" />	

<div data-role="fieldcontain">
    <label for="name"><b>ประเภทการนัดหมาย : </b></label><br>

    <select name="app_type_id" id="app_type_id" data-native-menu="false">
	<?
$sql_lookup_text = "SELECT * FROM appointment_type ORDER BY app_type_id";
$result_lookup = mysql_query($sql_lookup_text);
While($row_lookup = mysql_fetch_array($result_lookup)){
  
   if($row_lookup['app_type_id'] == $row['app_type_id'])
     echo "<option value=\"".$row_lookup['app_type_id']."\" selected>".$row_lookup['app_type_name']."</option>\n";
   else
     echo "<option value=\"".$row_lookup['app_type_id']."\">".$row_lookup['app_type_name']."</option>\n";
	 
}
    ?>
    </select>
</div>

<div data-role="fieldcontain">
    <label for="name"><b>หัวข้อการนัดหมาย : </b></label><br>
    <input type="text" name="app_subject" id="app_subject" value="<?=$row['app_subject']; ?>" />
</div>

<div data-role="fieldcontain">
    <label for="name"><b>สถานที่ประชุม : </b></label><br>
    <input type="text" name="app_place" id="app_place" value="<?=$row['app_place']; ?>" />
</div>

<div data-role="fieldcontain">
    <label for="name"><b>รายละเอียด : </b></label><br>
    <textarea name="app_detail" id="app_detail"><?=$row['app_detail']; ?></textarea>
</div>

<div data-role="fieldcontain">
    <label for="name"><b>วันเวลา เริ่มต้น : </b></label><br>
		<fieldset data-role="controlgroup" data-type="horizontal">
	<select name="startdate_d" id="startdate_d">
			<option value="">วันที่</option>
			<option value="01" <? if($date_tmp_use_st[2] == "01") echo "selected"; ?>>01</option>
			<option value="02" <? if($date_tmp_use_st[2] == "02") echo "selected"; ?>>02</option>
			<option value="03" <? if($date_tmp_use_st[2] == "03") echo "selected"; ?>>03</option>
			<option value="04" <? if($date_tmp_use_st[2] == "04") echo "selected"; ?>>04</option>
			<option value="05" <? if($date_tmp_use_st[2] == "05") echo "selected"; ?>>05</option>
			<option value="06" <? if($date_tmp_use_st[2] == "06") echo "selected"; ?>>06</option>
			<option value="07" <? if($date_tmp_use_st[2] == "07") echo "selected"; ?>>07</option>
			<option value="08" <? if($date_tmp_use_st[2] == "08") echo "selected"; ?>>08</option>
			<option value="09" <? if($date_tmp_use_st[2] == "09") echo "selected"; ?>>09</option>
			<option value="10" <? if($date_tmp_use_st[2] == "10") echo "selected"; ?>>10</option>
			<option value="11" <? if($date_tmp_use_st[2] == "11") echo "selected"; ?>>11</option>
			<option value="12" <? if($date_tmp_use_st[2] == "12") echo "selected"; ?>>12</option>
			<option value="13" <? if($date_tmp_use_st[2] == "13") echo "selected"; ?>>13</option>
			<option value="14" <? if($date_tmp_use_st[2] == "14") echo "selected"; ?>>14</option>
			<option value="15" <? if($date_tmp_use_st[2] == "15") echo "selected"; ?>>15</option>
			<option value="16" <? if($date_tmp_use_st[2] == "16") echo "selected"; ?>>16</option>
			<option value="17" <? if($date_tmp_use_st[2] == "17") echo "selected"; ?>>17</option>
			<option value="18" <? if($date_tmp_use_st[2] == "18") echo "selected"; ?>>18</option>
			<option value="19" <? if($date_tmp_use_st[2] == "19") echo "selected"; ?>>19</option>
			<option value="20" <? if($date_tmp_use_st[2] == "20") echo "selected"; ?>>20</option>
			<option value="21" <? if($date_tmp_use_st[2] == "21") echo "selected"; ?>>21</option>
			<option value="22" <? if($date_tmp_use_st[2] == "22") echo "selected"; ?>>22</option>
			<option value="23" <? if($date_tmp_use_st[2] == "23") echo "selected"; ?>>23</option>
			<option value="24" <? if($date_tmp_use_st[2] == "24") echo "selected"; ?>>24</option>
			<option value="25" <? if($date_tmp_use_st[2] == "25") echo "selected"; ?>>25</option>
			<option value="26" <? if($date_tmp_use_st[2] == "26") echo "selected"; ?>>26</option>
			<option value="27" <? if($date_tmp_use_st[2] == "27") echo "selected"; ?>>27</option>
			<option value="28" <? if($date_tmp_use_st[2] == "28") echo "selected"; ?>>28</option>
			<option value="29" <? if($date_tmp_use_st[2] == "29") echo "selected"; ?>>29</option>
			<option value="30" <? if($date_tmp_use_st[2] == "30") echo "selected"; ?>>30</option>
			<option value="31" <? if($date_tmp_use_st[2] == "31") echo "selected"; ?>>31</option>
	</select><select name="startdate_m" id="startdate_m">
			<option value="">เดือน</option>
			<option value="01" <? if($date_tmp_use_st[1] == "01") echo "selected"; ?>>มกราคม</option>
			<option value="02" <? if($date_tmp_use_st[1] == "02") echo "selected"; ?>>กุมภาพันธ์</option>
			<option value="03" <? if($date_tmp_use_st[1] == "03") echo "selected"; ?>>มีนาคม</option>
			<option value="04" <? if($date_tmp_use_st[1] == "04") echo "selected"; ?>>เมษายน</option>
			<option value="05" <? if($date_tmp_use_st[1] == "05") echo "selected"; ?>>พฤษภาคม</option>
			<option value="06" <? if($date_tmp_use_st[1] == "06") echo "selected"; ?>>มิถุนายน</option>
			<option value="07" <? if($date_tmp_use_st[1] == "07") echo "selected"; ?>>กรกฎาคม</option>
			<option value="08" <? if($date_tmp_use_st[1] == "08") echo "selected"; ?>>สิงหาคม</option>
			<option value="09" <? if($date_tmp_use_st[1] == "09") echo "selected"; ?>>กันยายน</option>
			<option value="10" <? if($date_tmp_use_st[1] == "10") echo "selected"; ?>>ตุลาคม</option>
			<option value="11" <? if($date_tmp_use_st[1] == "11") echo "selected"; ?>>พฤศจิกายน</option>
			<option value="12" <? if($date_tmp_use_st[1] == "12") echo "selected"; ?>>ธันวาคม</option>
		</select><select name="startdate_y" id="startdate_y">
			<option value="">ปี พ.ศ.</option>
			<option value="2013" <? if($date_tmp_use_st[0] == "2013") echo "selected"; ?>>2556</option>
			<option value="2014" <? if($date_tmp_use_st[0] == "2014") echo "selected"; ?>>2557</option>
		</select><select name="startdate_time" id="startdate_time">
		<option value="">เวลา</option>
		
		
		
<option value="00:00:00" <? if($row['app_start_time'] == "00:00:00") echo "selected"; ?>>00:00</option>
<option value="00:30:00" <? if($row['app_start_time'] == "00:30:00") echo "selected"; ?>>00:30</option>				
<option value="01:00:00" <? if($row['app_start_time'] == "01:00:00") echo "selected"; ?>>01:00</option>
<option value="01:30:00" <? if($row['app_start_time'] == "01:30:00") echo "selected"; ?>>01:30</option>			
<option value="02:00:00" <? if($row['app_start_time'] == "02:00:00") echo "selected"; ?>>02:00</option>
<option value="02:30:00" <? if($row['app_start_time'] == "02:30:00") echo "selected"; ?>>02:30</option>			
<option value="03:00:00" <? if($row['app_start_time'] == "03:00:00") echo "selected"; ?>>03:00</option>
<option value="03:30:00" <? if($row['app_start_time'] == "03:30:00") echo "selected"; ?>>03:30</option>	
<option value="04:00:00" <? if($row['app_start_time'] == "04:00:00") echo "selected"; ?>>04:00</option>
<option value="04:30:00" <? if($row['app_start_time'] == "04:30:00") echo "selected"; ?>>04:30</option>		
<option value="05:00:00" <? if($row['app_start_time'] == "05:00:00") echo "selected"; ?>>05:00</option>		
<option value="05:30:00" <? if($row['app_start_time'] == "05:30:00") echo "selected"; ?>>05:30</option>		
<option value="06:00:00" <? if($row['app_start_time'] == "06:00:00") echo "selected"; ?>>06:00</option>		
<option value="06:30:00" <? if($row['app_start_time'] == "06:30:00") echo "selected"; ?>>06:30</option>		
<option value="07:00:00" <? if($row['app_start_time'] == "07:00:00") echo "selected"; ?>>07:00</option>		
<option value="07:30:00" <? if($row['app_start_time'] == "07:30:00") echo "selected"; ?>>07:30</option>		
<option value="08:00:00" <? if($row['app_start_time'] == "08:00:00") echo "selected"; ?>>08:00</option>		
<option value="08:30:00" <? if($row['app_start_time'] == "08:30:00") echo "selected"; ?>>08:30</option>
<option value="09:00:00" <? if($row['app_start_time'] == "09:00:00") echo "selected"; ?>>09:00</option>
<option value="09:30:00" <? if($row['app_start_time'] == "09:30:00") echo "selected"; ?>>09:30</option>
<option value="10:00:00" <? if($row['app_start_time'] == "10:00:00") echo "selected"; ?>>10:00</option>
<option value="10:30:00" <? if($row['app_start_time'] == "10:30:00") echo "selected"; ?>>10:30</option>
<option value="11:00:00" <? if($row['app_start_time'] == "11:00:00") echo "selected"; ?>>11:00</option>
<option value="11:30:00" <? if($row['app_start_time'] == "11:30:00") echo "selected"; ?>>11:30</option>
<option value="12:00:00" <? if($row['app_start_time'] == "12:00:00") echo "selected"; ?>>12:00</option>
<option value="12:30:00" <? if($row['app_start_time'] == "12:30:00") echo "selected"; ?>>12:30</option>
<option value="13:00:00" <? if($row['app_start_time'] == "13:00:00") echo "selected"; ?>>13:00</option>
<option value="13:30:00" <? if($row['app_start_time'] == "13:30:00") echo "selected"; ?>>13:30</option>
<option value="14:00:00" <? if($row['app_start_time'] == "14:00:00") echo "selected"; ?>>14:00</option>
<option value="14:30:00" <? if($row['app_start_time'] == "14:30:00") echo "selected"; ?>>14:30</option>
<option value="15:00:00" <? if($row['app_start_time'] == "15:00:00") echo "selected"; ?>>15:00</option>
<option value="15:30:00" <? if($row['app_start_time'] == "15:30:00") echo "selected"; ?>>15:30</option>
<option value="16:00:00" <? if($row['app_start_time'] == "16:00:00") echo "selected"; ?>>16:00</option>
<option value="16:30:00" <? if($row['app_start_time'] == "16:30:00") echo "selected"; ?>>16:30</option>
<option value="17:00:00" <? if($row['app_start_time'] == "17:00:00") echo "selected"; ?>>17:00</option>
<option value="17:30:00" <? if($row['app_start_time'] == "17:30:00") echo "selected"; ?>>17:30</option>
<option value="18:00:00" <? if($row['app_start_time'] == "18:00:00") echo "selected"; ?>>18:00</option>
<option value="18:30:00" <? if($row['app_start_time'] == "18:30:00") echo "selected"; ?>>18:30</option>
<option value="19:00:00" <? if($row['app_start_time'] == "19:00:00") echo "selected"; ?>>19:00</option>
<option value="19:30:00" <? if($row['app_start_time'] == "19:30:00") echo "selected"; ?>>19:30</option>
<option value="20:00:00" <? if($row['app_start_time'] == "20:00:00") echo "selected"; ?>>20:00</option>
<option value="20:30:00" <? if($row['app_start_time'] == "20:30:00") echo "selected"; ?>>20:30</option>
<option value="21:00:00" <? if($row['app_start_time'] == "21:00:00") echo "selected"; ?>>21:00</option>
<option value="21:30:00" <? if($row['app_start_time'] == "21:30:00") echo "selected"; ?>>21:30</option>
<option value="22:00:00" <? if($row['app_start_time'] == "22:00:00") echo "selected"; ?>>22:00</option>
<option value="22:30:00" <? if($row['app_start_time'] == "22:30:00") echo "selected"; ?>>22:30</option>
<option value="23:00:00" <? if($row['app_start_time'] == "23:00:00") echo "selected"; ?>>23:00</option>
<option value="23:30:00" <? if($row['app_start_time'] == "23:30:00") echo "selected"; ?>>23:30</option>



</select>
		
	</fieldset>	
</div>


<div data-role="fieldcontain">
    <label for="name"><b>วันเวลา สิ้นสุด : </b></label><br>
	<fieldset data-role="controlgroup" data-type="horizontal">
	<select name="enddate_d" id="enddate_d">
			<option value="">วันที่</option>
			<option value="01" <? if($date_tmp_use_end[2] == "01") echo "selected"; ?>>01</option>
			<option value="02" <? if($date_tmp_use_end[2] == "02") echo "selected"; ?>>02</option>
			<option value="03" <? if($date_tmp_use_end[2] == "03") echo "selected"; ?>>03</option>
			<option value="04" <? if($date_tmp_use_end[2] == "04") echo "selected"; ?>>04</option>
			<option value="05" <? if($date_tmp_use_end[2] == "05") echo "selected"; ?>>05</option>
			<option value="06" <? if($date_tmp_use_end[2] == "06") echo "selected"; ?>>06</option>
			<option value="07" <? if($date_tmp_use_end[2] == "07") echo "selected"; ?>>07</option>
			<option value="08" <? if($date_tmp_use_end[2] == "08") echo "selected"; ?>>08</option>
			<option value="09" <? if($date_tmp_use_end[2] == "09") echo "selected"; ?>>09</option>
			<option value="10" <? if($date_tmp_use_end[2] == "10") echo "selected"; ?>>10</option>
			<option value="11" <? if($date_tmp_use_end[2] == "11") echo "selected"; ?>>11</option>
			<option value="12" <? if($date_tmp_use_end[2] == "12") echo "selected"; ?>>12</option>
			<option value="13" <? if($date_tmp_use_end[2] == "13") echo "selected"; ?>>13</option>
			<option value="14" <? if($date_tmp_use_end[2] == "14") echo "selected"; ?>>14</option>
			<option value="15" <? if($date_tmp_use_end[2] == "15") echo "selected"; ?>>15</option>
			<option value="16" <? if($date_tmp_use_end[2] == "16") echo "selected"; ?>>16</option>
			<option value="17" <? if($date_tmp_use_end[2] == "17") echo "selected"; ?>>17</option>
			<option value="18" <? if($date_tmp_use_end[2] == "18") echo "selected"; ?>>18</option>
			<option value="19" <? if($date_tmp_use_end[2] == "19") echo "selected"; ?>>19</option>
			<option value="20" <? if($date_tmp_use_end[2] == "20") echo "selected"; ?>>20</option>
			<option value="21" <? if($date_tmp_use_end[2] == "21") echo "selected"; ?>>21</option>
			<option value="22" <? if($date_tmp_use_end[2] == "22") echo "selected"; ?>>22</option>
			<option value="23" <? if($date_tmp_use_end[2] == "23") echo "selected"; ?>>23</option>
			<option value="24" <? if($date_tmp_use_end[2] == "24") echo "selected"; ?>>24</option>
			<option value="25" <? if($date_tmp_use_end[2] == "25") echo "selected"; ?>>25</option>
			<option value="26" <? if($date_tmp_use_end[2] == "26") echo "selected"; ?>>26</option>
			<option value="27" <? if($date_tmp_use_end[2] == "27") echo "selected"; ?>>27</option>
			<option value="28" <? if($date_tmp_use_end[2] == "28") echo "selected"; ?>>28</option>
			<option value="29" <? if($date_tmp_use_end[2] == "29") echo "selected"; ?>>29</option>
			<option value="30" <? if($date_tmp_use_end[2] == "30") echo "selected"; ?>>30</option>
			<option value="31" <? if($date_tmp_use_end[2] == "31") echo "selected"; ?>>31</option>
	</select><select name="enddate_m" id="enddate_m">
			<option value="">เดือน</option>
			<option value="01" <? if($date_tmp_use_end[1] == "01") echo "selected"; ?>>มกราคม</option>
			<option value="02" <? if($date_tmp_use_end[1] == "02") echo "selected"; ?>>กุมภาพันธ์</option>
			<option value="03" <? if($date_tmp_use_end[1] == "03") echo "selected"; ?>>มีนาคม</option>
			<option value="04" <? if($date_tmp_use_end[1] == "04") echo "selected"; ?>>เมษายน</option>
			<option value="05" <? if($date_tmp_use_end[1] == "05") echo "selected"; ?>>พฤษภาคม</option>
			<option value="06" <? if($date_tmp_use_end[1] == "06") echo "selected"; ?>>มิถุนายน</option>
			<option value="07" <? if($date_tmp_use_end[1] == "07") echo "selected"; ?>>กรกฎาคม</option>
			<option value="08" <? if($date_tmp_use_end[1] == "08") echo "selected"; ?>>สิงหาคม</option>
			<option value="09" <? if($date_tmp_use_end[1] == "09") echo "selected"; ?>>กันยายน</option>
			<option value="10" <? if($date_tmp_use_end[1] == "10") echo "selected"; ?>>ตุลาคม</option>
			<option value="11" <? if($date_tmp_use_end[1] == "11") echo "selected"; ?>>พฤศจิกายน</option>
			<option value="12" <? if($date_tmp_use_end[1] == "12") echo "selected"; ?>>ธันวาคม</option>
		</select><select name="enddate_y" id="enddate_y">
			<option value="">ปี พ.ศ.</option>
			<option value="2013" <? if($date_tmp_use_end[0] == "2013") echo "selected"; ?>>2556</option>
			<option value="2014" <? if($date_tmp_use_end[0] == "2014") echo "selected"; ?>>2557</option>
		</select><select name="enddate_time" id="enddate_time">
		<option value="">เวลา</option>

<option value="00:00:00" <? if($row['app_end_time'] == "00:00:00") echo "selected"; ?>>00:00</option>
<option value="00:30:00" <? if($row['app_end_time'] == "00:30:00") echo "selected"; ?>>00:30</option>				
<option value="01:00:00" <? if($row['app_end_time'] == "01:00:00") echo "selected"; ?>>01:00</option>
<option value="01:30:00" <? if($row['app_end_time'] == "01:30:00") echo "selected"; ?>>01:30</option>			
<option value="02:00:00" <? if($row['app_end_time'] == "02:00:00") echo "selected"; ?>>02:00</option>
<option value="02:30:00" <? if($row['app_end_time'] == "02:30:00") echo "selected"; ?>>02:30</option>			
<option value="03:00:00" <? if($row['app_end_time'] == "03:00:00") echo "selected"; ?>>03:00</option>
<option value="03:30:00" <? if($row['app_end_time'] == "03:30:00") echo "selected"; ?>>03:30</option>	
<option value="04:00:00" <? if($row['app_end_time'] == "04:00:00") echo "selected"; ?>>04:00</option>
<option value="04:30:00" <? if($row['app_end_time'] == "04:30:00") echo "selected"; ?>>04:30</option>		
<option value="05:00:00" <? if($row['app_end_time'] == "05:00:00") echo "selected"; ?>>05:00</option>		
<option value="05:30:00" <? if($row['app_end_time'] == "05:30:00") echo "selected"; ?>>05:30</option>		
<option value="06:00:00" <? if($row['app_end_time'] == "06:00:00") echo "selected"; ?>>06:00</option>		
<option value="06:30:00" <? if($row['app_end_time'] == "06:30:00") echo "selected"; ?>>06:30</option>		
<option value="07:00:00" <? if($row['app_end_time'] == "07:00:00") echo "selected"; ?>>07:00</option>		
<option value="07:30:00" <? if($row['app_end_time'] == "07:30:00") echo "selected"; ?>>07:30</option>		
<option value="08:00:00" <? if($row['app_end_time'] == "08:00:00") echo "selected"; ?>>08:00</option>		
<option value="08:30:00" <? if($row['app_end_time'] == "08:30:00") echo "selected"; ?>>08:30</option>
<option value="09:00:00" <? if($row['app_end_time'] == "09:00:00") echo "selected"; ?>>09:00</option>
<option value="09:30:00" <? if($row['app_end_time'] == "09:30:00") echo "selected"; ?>>09:30</option>
<option value="10:00:00" <? if($row['app_end_time'] == "10:00:00") echo "selected"; ?>>10:00</option>
<option value="10:30:00" <? if($row['app_end_time'] == "10:30:00") echo "selected"; ?>>10:30</option>
<option value="11:00:00" <? if($row['app_end_time'] == "11:00:00") echo "selected"; ?>>11:00</option>
<option value="11:30:00" <? if($row['app_end_time'] == "11:30:00") echo "selected"; ?>>11:30</option>
<option value="12:00:00" <? if($row['app_end_time'] == "12:00:00") echo "selected"; ?>>12:00</option>
<option value="12:30:00" <? if($row['app_end_time'] == "12:30:00") echo "selected"; ?>>12:30</option>
<option value="13:00:00" <? if($row['app_end_time'] == "13:00:00") echo "selected"; ?>>13:00</option>
<option value="13:30:00" <? if($row['app_end_time'] == "13:30:00") echo "selected"; ?>>13:30</option>
<option value="14:00:00" <? if($row['app_end_time'] == "14:00:00") echo "selected"; ?>>14:00</option>
<option value="14:30:00" <? if($row['app_end_time'] == "14:30:00") echo "selected"; ?>>14:30</option>
<option value="15:00:00" <? if($row['app_end_time'] == "15:00:00") echo "selected"; ?>>15:00</option>
<option value="15:30:00" <? if($row['app_end_time'] == "15:30:00") echo "selected"; ?>>15:30</option>
<option value="16:00:00" <? if($row['app_end_time'] == "16:00:00") echo "selected"; ?>>16:00</option>
<option value="16:30:00" <? if($row['app_end_time'] == "16:30:00") echo "selected"; ?>>16:30</option>
<option value="17:00:00" <? if($row['app_end_time'] == "17:00:00") echo "selected"; ?>>17:00</option>
<option value="17:30:00" <? if($row['app_end_time'] == "17:30:00") echo "selected"; ?>>17:30</option>
<option value="18:00:00" <? if($row['app_end_time'] == "18:00:00") echo "selected"; ?>>18:00</option>
<option value="18:30:00" <? if($row['app_end_time'] == "18:30:00") echo "selected"; ?>>18:30</option>
<option value="19:00:00" <? if($row['app_end_time'] == "19:00:00") echo "selected"; ?>>19:00</option>
<option value="19:30:00" <? if($row['app_end_time'] == "19:30:00") echo "selected"; ?>>19:30</option>
<option value="20:00:00" <? if($row['app_end_time'] == "20:00:00") echo "selected"; ?>>20:00</option>
<option value="20:30:00" <? if($row['app_end_time'] == "20:30:00") echo "selected"; ?>>20:30</option>
<option value="21:00:00" <? if($row['app_end_time'] == "21:00:00") echo "selected"; ?>>21:00</option>
<option value="21:30:00" <? if($row['app_end_time'] == "21:30:00") echo "selected"; ?>>21:30</option>
<option value="22:00:00" <? if($row['app_end_time'] == "22:00:00") echo "selected"; ?>>22:00</option>
<option value="22:30:00" <? if($row['app_end_time'] == "22:30:00") echo "selected"; ?>>22:30</option>
<option value="23:00:00" <? if($row['app_end_time'] == "23:00:00") echo "selected"; ?>>23:00</option>
<option value="23:30:00" <? if($row['app_end_time'] == "23:30:00") echo "selected"; ?>>23:30</option>
		
		
</select>
		
	</fieldset>
</div>

<!--
<div data-role="fieldcontain">
    <label for="name"><b>การแสดงหัวข้อการนัดหมาย : </b></label><br>
	<fieldset data-role="controlgroup" data-type="horizontal">
	<input type="radio" name="app_status" id="radio-mini-1" value="1" <? if($row['app_status'] == "1") echo "checked"; ?> />
    	<label for="radio-mini-1">แสดงให้เห็นทุกคน</label>

	<input type="radio" name="app_status" id="radio-mini-2" value="2" <? if($row['app_status'] == "2") echo "checked"; ?> />
    	<label for="radio-mini-2">ไม่แสดง</label>
		
	<input type="radio" name="app_status" id="radio-mini-3" value="3" <? if($row['app_status'] == "3") echo "checked"; ?> />
    	<label for="radio-mini-3">แสดงให้เห็นเฉพาะบางบุคคล</label>
                  </fieldset>
		<br>
	<select name="mam_co[]" id="mam_co" multiple="multiple" data-native-menu="false">
			<option value="">รายชื่อผู้ที่มีสิทธิมองเห็นหัวข้อการนัดหมาย</option>		


//$strSQL_sel = "SELECT * FROM appointment_show WHERE app_id='$aid' ORDER BY app_show_id";
//$result_sel = mysql_query($strSQL_sel);
//echo mysql_error();
//While($row_sel = mysql_fetch_array($result_sel)){

   <option value="$row_sel['emp_id']; ?>" selected>get_fullname($row_sel['emp_id']); ?></option>

//}

	</select>
	<br>
	<ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="ค้นหาผู้มีสิทธิเห็นหัวข้อการนัดหมาย" data-filter-theme="d"></ul>

</div>



<br><br>

-->

<div class="ui-body ui-body-b">
	<fieldset class="ui-grid-a">
			<div class="ui-block-a"><button type="submit" data-theme="d">แก้ไขข้อมูล</button></div>
			<div class="ui-block-b"><button type="reset" data-theme="d">ยกเลิก</button></div>	
                  </fieldset>
</div>


</form>
		
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


</body>
</html>
