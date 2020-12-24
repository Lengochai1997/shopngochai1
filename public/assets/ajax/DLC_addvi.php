<?php 
// Code được Cover lại bởi Ngô Quốc Đạt - DATLECHIN
// Nhận code Các Thể loại LH Facebook: https://www.facebook.com/Dat.Viruss.Tml.Official
// Cảm ơn các bạn đã ủng hộ và sử dụng sản phẩm của mình

include '../../tomdz/dbtomdzvl.php';
?>

<?php
$bank = mysql_real_escape_string($_POST['bank']);
$account = mysql_real_escape_string($_POST['account']);
$account_confirm = mysql_real_escape_string($_POST['account_confirm']);

$dlc1 = '<div class="alert alert-danger">
Vui lòng nhập đầy đủ thông tin
</div>';
$dlc2 = '<div class="alert alert-danger">
Bạn chưa chọn loại ví</div>';
$dlc3 = '<div class="alert alert-danger">
Nhập lại tài khoản ví không đúng
</div>';
$dlc4 = '<div class="alert alert-success">
Thêm tài khoản ví thành công<script> location.reload(); </script>
</div>';
if(empty($account) || empty($account_confirm)){
echo json_encode(array('msg' => "$dlc1"));
exit();
}
if($bank < 1 || $bank > 5){
echo json_encode(array('msg' => "$dlc2"));
exit();
}
if($account_confirm != $account){
echo json_encode(array('msg' => "$dlc3"));
exit();
}
mysql_query("INSERT INTO DLC_Nganhang SET
 `username` = '".$tom['username']."', `bankaccount` = '".$bank."',
 `bankname` = '".$account."', `type` = '1'");
echo json_encode(array('msg'=>"$dlc4"));
?>