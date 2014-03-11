<?
include "dbconfig.php";
conndb();
error_reporting (E_ALL ^ E_NOTICE);

$return_arr = array();
$keyword = $_GET['q'];


$sql = "select emp_id,first_name,last_name,cctr_text from employee where (emp_id = '$keyword') OR (first_name like '%$keyword%') OR (last_name like '%$keyword%') OR (cctr_text like '%$keyword%') order by first_name";
$fetch = mysql_query($sql);

echo mysql_error();

while($row = mysql_fetch_array($fetch)){

//  OnClick=\"JavaScript:save_value('".$row['emp_id']."');\"

$emp_id_tmp = $row['emp_id'];
$emp_fullname_tmp = $row['first_name']." ".$row['last_name'];

//$fullname = "<li><a href=\"#\" OnClick=\"JavaScript:send_value('".$row['emp_id']."');\">".$row['emp_id']." ".$row['first_name']." ".$row['last_name']." [".$row['cctr_text']."]</a></li>";
$fullname = "<li><a href=\"#\" OnClick=\"JavaScript:send_value('".$emp_id_tmp."','".$emp_fullname_tmp."');\">".$row['emp_id']." ".$row['first_name']." ".$row['last_name']." [".$row['cctr_text']."]</a></li>";

array_push($return_arr,$fullname);

}

echo json_encode($return_arr);




?>