<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';

// SQL 쿼리

// asset_regedit 입력창에서 GET과 POST로 받기
if (!empty($_POST['code'])) {
	$code = array($_POST['code']);
} else { $code = ''; }
if (!empty($_POST['item'])) {
	$item = $_POST['item'];
} else { $item = ''; }
if (!empty($_POST['color'])) {
	$color = $_POST['color'];
} else { $color = ''; }
if (!empty($_POST['size'])) {
	$size = $_POST['size'];
} else { $size = ''; }
if (!empty($_POST['location'])) {
	$location = $_POST['location'];
} else { $location = ''; }
if (!empty($_POST['purchase_date'])) {
	$purchase_date = $_POST['purchase_date'];
} else { $purchase_date = ''; }
if (!empty($_POST['manufacturer'])) {
	$manufacturer = $_POST['manufacturer'];
} else { $manufacturer = ''; }
if (!empty($_POST['wheretobuy'])) {
	$wheretobuy = $_POST['wheretobuy'];
} else { $wheretobuy = ''; }
if (!empty($_POST['contact'])) {
	$contact = $_POST['contact'];
} else { $contact = ''; }
if (!empty($_POST['asset_no'])) {
	$asset_no = $_POST['asset_no'];
} else { $asset_no = ''; }
if (!empty($_POST['seat_no'])) {
	$seat_no = $_POST['seat_no'];
} else { $seat_no = ''; }
if (!empty($_POST['user_no'])) {
	$user_no = $_POST['user_no'];
} else { $user_no = ''; }
if (!empty($_POST['expiry_date'])) {
	$expiry_date = $_POST['expiry_date'];
} else { $expiry_date = ''; }
if (!empty($_POST['administrator'])) {
	$administrator = $_POST['administrator'];
} else { $administrator = ''; }


$number = $_GET['number'];

/*
$code = $_POST['code'];
$item = $_POST['item'];
$color = $_POST['color'];
$size = $_POST['size'];
$location = $_POST['location'];
$purchase_date = $_POST['purchase_date'];
$manufacturer = $_POST['manufacturer'];
$wheretobuy = $_POST['wheretobuy'];
$contact = $_POST['contact'];
$asset_no = $_POST['asset_no'];
$seat_no = $_POST['seat_no'];
$user_no = $_POST['user_no'];
$expiry_date = $_POST['expiry_date'];
$administrator = $_POST['administrator'];
*/

//var_dump($code);
$regedit_input = array($number => array($code, $code, $item, $size,'', $location, $purchase_date, $manufacturer, $wheretobuy, $contact, $asset_no, $seat_no, $user_no, $expiry_date, $administrator));
var_dump($regedit_input[$number]);
?>

<!--regedit table에 입력하기 위한 input type hidden code-->
<form method="POST" action="./asset_regedit.php?regedit_input=<?=$regedit_input[$number]?>">
	<input type="text" name="<?=$regedit_input?>" id="regidit_input">
</form>

<?php
$number = $_GET['number'];
var_dump($number);
//echo("<meta http-equiv='refresh' content='0' url='./asset_regedit.php'>");
//if ($regedit_input) {
//	redirect(false,'입력이 되었습니다.');
//	exit;
//}



/* 제품이미지 이미지 파일 업로드*/
/* 좀 이따가 구현
$original_file_name = $_FILES['product_image']['name']; // 파일의 원본 이름
$type = $_FILES['product_image']['type'];		 // 파일의 형식
$size = $_FILES['product_image']['size'];		 // 파일의 용량
$tmp_name = $_FILES['product_image']['tmp_name']; // 서버에 업로드 된 임시파일 이름
$file_name = '';
if ($regedit['product_image']) {
	$del_file_name = '../images/' . $regedit['product_image'];
	//var_dump($del_file_name);
}
$upload_data = single_upload($original_file_name, $type, $size, $tmp_name, $file_name);
$file_name = $upload_data['file_name'];
*/
//var_dump($file_name);

/* if (!$upload_data) {
	redirect(false, '업로드에 실패했습니다.');
	exit;
} else {
  	//echo("<h2>업로드 된 파일 정보</h2>");
	//echo("<pre>");
	//print_r($upload_data);
	//echo("</pre>");
  
} */

// 이미지 파일 업로드 끝
