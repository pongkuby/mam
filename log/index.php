<?
include "dbconfig.php";
conndb();
error_reporting(E_ALL ^ E_NOTICE);

$startdate = $_POST['startdate'];
if (!isset($_POST['startdate'])) {
    $startdate = date('Y-m-d');
}
$enddate = $_POST['enddate'];
if (!isset($_POST['enddate'])) {
    $enddate = date('Y-m-d');
}

function get_total_pageviews($startdate, $enddate)
{
    $strSQL_chk = "SELECT COUNT(emp_id) AS TOTAL_COUNT FROM activity_log WHERE DATE(activity_time) BETWEEN '$startdate' AND '$enddate'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
    echo mysql_error();
    return $row_chk['TOTAL_COUNT'];
}


function get_total_uip($startdate, $enddate)
{
    $strSQL_chk = "SELECT COUNT(DISTINCT ipaddress) AS TOTAL_COUNT FROM activity_log WHERE DATE(activity_time) BETWEEN '$startdate' AND '$enddate'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
    echo mysql_error();
    return $row_chk['TOTAL_COUNT'];
}

function get_total_empid($startdate, $enddate)
{
    $strSQL_chk = "SELECT COUNT(DISTINCT emp_id) AS TOTAL_COUNT FROM activity_log WHERE DATE(activity_time)BETWEEN '$startdate' AND '$enddate'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
    echo mysql_error();
    return $row_chk['TOTAL_COUNT'];
}


function convert_datetime($date_tmp)
{
    $datetime_arr = explode(" ", $date_tmp);
    $date_tmp_arr = explode("-", $datetime_arr[0]);
    $time_tmp_arr = $datetime_arr[1];
    $str_return = $date_tmp_arr[2] . "/" . $date_tmp_arr[1] . "/" . ($date_tmp_arr[0] + 543);
    return $str_return . " - " . $time_tmp_arr;
}

function convert_date($date_tmp)
{
    $datetime_arr = explode(" ", $date_tmp);
    $date_tmp_arr = explode("-", $datetime_arr[0]);
    $time_tmp_arr = $datetime_arr[1];
    $str_return = $date_tmp_arr[2] . "/" . $date_tmp_arr[1] . "/" . ($date_tmp_arr[0] + 543);
    return $str_return;
}


function get_emp_data($emp_id)
{
    $strSQL_chk = "SELECT * FROM employee WHERE emp_id = '$emp_id'";
    $result_chk = mysql_query($strSQL_chk);
    $row_chk = mysql_fetch_array($result_chk);
    return $row_chk['first_name'] . " " . $row_chk['last_name'] . "<br>[ " . $row_chk['pos_name'] . " ]" . "<br>[ " . $row_chk['org_unit_text'] . " ]";
}


?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=tis-620">
    <title>สถิติการใช้งานระบบ M@M</title>
    <STYLE type=text/css>
        A:link {
            color: #0000cc;
            text-decoration: none
        }

        A:visited {
            color: #0000cc;
            text-decoration: none
        }

        A:hover {
            color: red;
            text-decoration: none
        }
    </STYLE>
    <style type="text/css">
        <!--
        small {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
        }

        input, textarea {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        b {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        big {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20pt;
        }

        strong {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            font-weight: bold;
        }

        font, td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        BODY {
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        -->
    </style>


    <script language="JavaScript" type="text/javascript">
        function checkform(form) {

            if (form.startdate.value == "") {
                alert("โปรดกรอก วันที่เริ่มต้น ด้วย");
                form.startdate.focus();
                return false;
            }

            if (form.enddate.value == "") {
                alert("โปรดกรอก วันที่สิ้นสุด ด้วย");
                form.enddate.focus();
                return false;
            }

            return true;
        }
    </script>

    <script language="JavaScript" type="text/javascript" src="datepicker/datepicker.js"></script>
    <link href="datepicker/datepickerstyle.css" type="text/css" rel="stylesheet">

</head>

<body>
<center>
    <b><big><< สถิติการใช้งานระบบ M@M >></big></b>
    <br><br>

    <form name="myform" method="post" action="index.php" enctype="multipart/form-data"
          onsubmit="return checkform(this);">
        วันที่เริ่มต้น : <INPUT size="10" name="startdate" id="startdate" value="<?= $startdate; ?>"
                                readonly="1"> <a href="javascript:displayDatePicker('startdate')"><img border="0"
                                                                                                       src="datepicker/formcal.gif"
                                                                                                       width="16"
                                                                                                       height="16"></a>
        <b>ถึง</b> วันที่สิ้นสุด : <INPUT size="10" name="enddate" id="enddate"
                                          value="<?= $enddate ?>" readonly="1"> <a
            href="javascript:displayDatePicker('enddate')"><img border="0" src="datepicker/formcal.gif" width="16"
                                                                height="16"></a>
        <br><br>
        <INPUT type="submit" value="<< เรียกดู >>" name="submit_bt">
    </form>
    <br>
    สถิติตั้งแต่ <b><?= convert_date($startdate); ?></b> ถึง <b><?= convert_date($enddate); ?></b>
    <br><br>

    <TABLE borderColor=#000000 cellSpacing=0 width="800" border="1">
        <tr bgcolor="#D0C6C6">
            <td width="33%">
                <div align="center"><b>จำนวน Pageviews ทั้งหมด</b></div>
            </td>
            <td width="33%">
                <div align="center"><b>จำนวน Unique IP ทั้งหมด</b></div>
            </td>
            <td width="34%">
                <div align="center"><b>จำนวน พนักงาน ทั้งหมด</b></div>
            </td>
        </tr>
        <tr>
            <td>
                <div align="center"><?= get_total_pageviews($startdate, $enddate); ?></div>
            </td>
            <td>
                <div align="center"><?= get_total_uip($startdate, $enddate); ?></div>
            </td>
            <td>
                <div align="center"><?= get_total_empid($startdate, $enddate); ?></div>
            </td>
        </tr>
    </table>

    <br><br>

    <TABLE borderColor=#000000 cellSpacing=0 width="1200" border="1">
        <tr bgcolor="#D0C6C6">
            <td>
                <div align="center"><b>วัน/เวลา</b></div>
            </td>
            <td>
                <div align="center"><b>ข้อมูลพนักงาน</b></div>
            </td>
            <td>
                <div align="center"><b>IP ADDRESS</b></div>
            </td>
            <td>
                <div align="center"><b>กิจกรรม</b></div>
            </td>
            <td>
                <div align="center"><b>OS</b></div>
            </td>
            <td>
                <div align="center"><b>RESOLUTION</b></div>
            </td>
            <td>
                <div align="center"><b>BROWSER</b></div>
            </td>
        </tr>

        <?

        $strSQL_chk = "SELECT * FROM activity_log WHERE DATE(activity_time) BETWEEN '$startdate' AND '$enddate' ORDER BY activity_time";
        $result_chk = mysql_query($strSQL_chk);
        while ($row_chk = mysql_fetch_array($result_chk)) {
            ?>

            <tr bgcolor="#FFFFFF">
                <td>
                    <div align="center"><?= convert_datetime($row_chk['activity_time']); ?></div>
                </td>
                <td>
                    <div align="center"><?= $row_chk['emp_id']; ?><br><?= get_emp_data($row_chk['emp_id']); ?></div>
                </td>
                <td>
                    <div align="center"><?= $row_chk['ipaddress']; ?></div>
                </td>
                <td>
                    <div align="center"><?= $row_chk['activity_text']; ?></div>
                </td>
                <td>
                    <div align="center"><?= $row_chk['system']; ?></div>
                </td>
                <td>
                    <div align="center"><?= $row_chk['resolution']; ?></div>
                </td>
                <td style="background: none repeat scroll 0 0 white; width: 40px;">
                    <div align="center"><?= $row_chk['browser']; ?></div>
                </td>
            </tr>

        <?
        }
        ?>

    </table>
</center>

</body>
</html>
