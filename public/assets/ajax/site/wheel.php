<?php
/*
╔═════════════════════════════════════════════╗
║            Design by VuTungDuy              ║
║            Mail: admin@junoo.net            ║
║            Hotline: 0395.682.731            ║ 
╚═════════════════════════════════════════════╝
*/
function check_wheel($percent){
    if ($percent < 2) return false;
    if ($percent >= 100) return true;
    $array_number = array();
    //tạo mảng
        for ($i=0; $i < 100 ; $i++) { 
            array_push($array_number, $i);
        }
    //lấy ra $percent số ngẫu nhiên
    $random_array = array_rand($array_number,$percent);
    //check
    if (in_array(rand(0,99), $random_array)) return true;
    else return false;
    return false;
}

//info wheel
function info_wheel($type) {
    $wheel = array();
    switch ($type) {
        case 1:
            $wheel['msg']  = 'Nick từ 40 tướng';
            $wheel['angles']   = 360;
            break;
        case 2:
            $wheel['msg']  = 'Nick Trắng Thông Tin';
            $wheel['angles']   = 90;
            break;
        case 3:
            $wheel['msg']  = 'Nick đá quý hoặc skin đá quý';
            $wheel['angles']   = 403;
            break;
        case 4:
            $wheel['msg']  = 'Nhận được 0 quân huy';
            $wheel['angles']   = 626;
            break;
        case 5:
            $wheel['msg']  = 'Nổ hũ vàng ';
            $wheel['angles']   = 540;
            break;
        case 6:
            $wheel['msg']  = 'Nick từ 30 tướng';
            $wheel['angles']   = 582;
            break;
        case 7:
            $wheel['msg']  = 'Nick từ 20 tướng';
            $wheel['angles']   = 494;
            break;
        case 8:
            $wheel['msg']  = 'Nhận được 50 quân huy';
            $wheel['angles']   = 627;
            break;
        default :
            $wheel['msg']  = 'Nick từ 20 tướng';
            $wheel['angles']   = 494;
            break;

    }
    return $wheel;
}
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/tomdz/dbtomdzvl.php');
//check post
if(!$_POST){load_url('/');die();}
//lấy dữ liệu vòng quay
$sql_setting_wheel =  "SELECT * FROM `setting_wheel`";
if (mysql_num_rows(mysql_query($sql_setting_wheel))){
	$setting_wheel = mysql_fetch_assoc(mysql_query($sql_setting_wheel), 1);
	$price = $setting_wheel['wheel_price'];//giá quay
}else{
	echo json_encode(array('title' => 'Lỗi', 'msg' => "Vòng quay đang bảo trì. Vui lòng thử lại sau !"));die;
}

if (!$user_login) {
    echo json_encode(array('title' => 'Lỗi', 'msg' => "Bạn chưa đăng nhập !"));die;}
if($setting_wheel['status'] != 1 ){
    echo json_encode(array('title' => 'Lỗi', 'msg' => "Vòng quay đang bảo trì. Vui lòng thử lại sau !"));die;}
if ($tom['looked'] > 0){
    echo json_encode(array('title' => 'Lỗi', 'msg' => 'Tài khoản của bạn đã bị khóa. Lý do: '.$TOM_Users['note'].'. Vui lòng liên hệ với Admin !'));die();}
if ($tom['sodu'] < $price){
    echo json_encode(array('title' => 'Lỗi', 'msg' => 'Bạn cần '.number_format($price).'đ để chơi vòng quay này !'));die();}

//thông tin người dùng
$iduser = $tom['username'];
$name = addslashes($tom['name']);
$date_current = time();
$date_now = time();
	mysql_query("UPDATE `TOM_Users` SET `sodu` = `sodu` - '".$price."' WHERE `username` = '".$iduser."'");//trừ tiền
	mysql_query("UPDATE `setting_wheel` SET `huvang` = `huvang` + '".$price*0.8."'");//cộng tiền vào hũ

//tạo list quà
$gift = array();
for ($i=1;$i <= 8; $i++){
    if($setting_wheel[$i] != 0) array_push($gift, $i);
}

$gift = $gift[array_rand($gift)];//lấy gói quà
$percent = $setting_wheel['id_nohu'] == $iduser && $gift == 5 ? 100:$setting_wheel[$gift];//lấy tỷ lệ
$gift = check_wheel($percent) ? $gift:7;//check tỉ lệ
$msg = info_wheel($gift)['msg'];//nội dung
$angles = info_wheel($gift)['angles'];//góc quay
$hide = $gift == 4 || $gift == 6 ? 1:0;
$huvang = mysql_fetch_assoc(mysql_query("SELECT * FROM setting_wheel"), 1)['huvang'];
$nohu = $gift == 5 ? $huvang:0;
$id_wheel = 0;

//xử lý nhận acc
if($gift != 4 && $gift != 5 && $gift != 8){
	$sql_wheel =  "SELECT id FROM `wheel` WHERE `type` = '".$gift."' AND `status` = '0' AND `iduser` = '' ORDER BY rand() LIMIT 1";
	if (mysql_num_rows(mysql_query($sql_wheel))){
		$id_wheel = mysql_fetch_assoc(mysql_query($sql_wheel), 1)['id'];
		mysql_query("UPDATE `wheel` SET `iduser` = '".$iduser."',`time` = '".time()."', `status` = '1' WHERE `id` = '".$id_wheel."'");//cập nhật acc
	}else{
		mysql_query("INSERT INTO `wheel` (`iduser`,`time`,`type`) VALUES ('".$iduser."','".time()."','".$gift."')");//tạo order acc
		$id_wheel = mysql_insert_id();
	}
}elseif($gift == 5){
	$msg .= number_format($huvang).'đ';
	mysql_query("UPDATE `TOM_Users` SET `sodu` = `sodu` + '".$huvang."' WHERE `username` = '".$iduser."'");//cộng tiền
	mysql_query("UPDATE `setting_wheel` SET `huvang` = `huvang` - '".$huvang."', `id_nohu` = ''");//trừ tiền hũ
	$huvang = mysql_fetch_assoc(mysql_query("SELECT * FROM setting_wheel"), 1)['huvang'];
}
mysql_query("INSERT INTO `history_wheel` (`username`,`name`,`type`,`id_wheel`,`prize`,`nohu`,`hide`,`time`,`date`) VALUES ('".$iduser."','".$name."','".$gift."','".$id_wheel."','".$msg."','".$nohu."','".$hide."','".$date_current."','".$date_now."')");
$msg = $gift == 4 ? $msg.'. Chúc bạn may mắn lần sau.':$msg;
$msg = $gift == 8 ? $msg.'. Liên hệ Fanpage để nhận quân huy.':$msg;
echo json_encode(array(
	'status' => 1,
	'msg' => $msg,
	'local' => $angles,
	'huvang' => number_format($huvang).'đ'
	));
die();