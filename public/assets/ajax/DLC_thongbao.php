<?php 
// Code được Cover lại bởi Ngô Quốc Đạt - DATLECHIN
// Nhận code Các Thể loại LH Facebook: https://www.facebook.com/Dat.Viruss.Tml.Official
// Cảm ơn các bạn đã ủng hộ và sử dụng sản phẩm của mình

include '../../tomdz/dbtomdzvl.php';
?>
<?php

if(isset($_GET[datlechin])) {
 

$tong = mysql_result(mysql_query("SELECT COUNT(*) FROM `DLC_Thongbao`"), 0);
$DLC_result = mysql_query("SELECT * FROM `DLC_Thongbao` ORDER by id DESC LIMIT 0, 12");
while($getdlc = mysql_fetch_assoc($DLC_result)){

$datlechin .='
<tr>
<td>'.$getdlc['id'].'</td>
<td>'.$getdlc['nguoidang'].'</td>
<td>'.$getdlc['tieude'].'</td>
<td>'.$getdlc['noidung'].'</td>
<td>'.date('d/m/Y - H:i:s', $getdlc['time']).'</td>
</tr>
 ';
 }

$datlechinJSON['msg'] = $datlechin;
    echo json_encode($datlechinJSON);
} else {
$tieude = mysql_real_escape_string($_POST['tieude']);
$noidung = mysql_real_escape_string($_POST['noidung']);

$dlc1 = '<div class="alert alert-danger">
Vui lòng nhập đầy đủ thông tin
</div>';
$dlc2 = '<div class="alert alert-success">
Đăng thông báo thành công
</div>';
if (empty($tieude) || empty($noidung)) {
echo json_encode(array('msg' => "$dlc1"));
exit();
} else {
mysql_query("INSERT INTO DLC_Thongbao SET 
`nguoidang` = '".$congtacvien['user']."',
`tieude` = '".$tieude."',
`noidung` = '".$noidung."',
`time` = '".time()."'");


echo json_encode(array('msg' => "$dlc2"));
}	}
?>