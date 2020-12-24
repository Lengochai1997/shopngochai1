<?php 
// Code được Cover lại bởi Ngô Quốc Đạt - DATLECHIN
// Nhận code Các Thể loại LH Facebook: https://www.facebook.com/Dat.Viruss.Tml.Official
// Cảm ơn các bạn đã ủng hộ và sử dụng sản phẩm của mình

include '../../tomdz/dbtomdzvl.php';
?>

<?php
$bank = mysql_real_escape_string($_POST['bank']);
$chutk = mysql_real_escape_string($_POST['chutk']);
$stk = mysql_real_escape_string($_POST['stk']);
$chinhanh = mysql_real_escape_string($_POST['chinhanh']);
$getbank = array("Không hợp lệ", "Thesieure.com", "Thecaosieure.com", "Azpro.vn", "Shopnro247.com");

$dlc1 = '<div class="alert alert-danger">
Vui lòng nhập đầy đủ thông tin
</div>';
$dlc2 = '<div class="alert alert-danger">
Bạn chưa chọn loại ví</div>';
$dlc3 = '<div class="alert alert-danger">
Nhập lại tài khoản ví không đúng
</div>';
$dlc4 = '<div class="alert alert-success">
Thêm tài khoản ngân hàng thành công<script> location.reload(); </script>
</div>';

if(empty($chutk) || empty($stk) || empty($chinhanh)){
echo json_encode(array('msg' => "$dlc1"));
exit();
}
if($bank < 6 || $bank > 12){
echo json_encode(array('msg' => "$dlc2"));
exit();
}
mysql_query("INSERT INTO DLC_Nganhang SET
 `username` = '".$tom['username']."', `bankaccount` = '".$bank."',
 `bankname` = '".$stk."', `chinhanh` = '".$chinhanh."', `chubank` = '".$chutk."', `type` = '0'");
echo json_encode(array('msg'=>"$dlc4"));	
?>