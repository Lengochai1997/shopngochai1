<?php 
// Code được Cover lại bởi Ngô Quốc Đạt - DATLECHIN
// Nhận code Các Thể loại LH Facebook: https://www.facebook.com/Dat.Viruss.Tml.Official
// Cảm ơn các bạn đã ủng hộ và sử dụng sản phẩm của mình

include '../../tomdz/dbtomdzvl.php';
?>

<?php
$keyword = trim($_POST['name']) ;	
$keyword = mysql_real_escape_string($keyword);
$row = mysql_fetch_assoc(mysql_query("select * from TOM_Users where username = '$keyword' LIMIT 1"));
$data .= ''.$row[email].'<br>';
$json[msg] = $data;
echo json_encode($json);
