<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';

// SQL 쿼리
$regedit = '';


// asset_regedit 입력창에서 POST로 받기
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

?>
<


<?php
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