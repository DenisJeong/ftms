<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';

// SQL 쿼리

db_open();

if ($_POST['regedit'] == "등록하기") {
	//asset-list 테이블로 임시 DB(temp-list)복사하기
	$sql = "INSERT INTO `asset-list` SELECT * FROM `temp-list`";
	$input = array();
	$result = db_query($sql, $input);
	if (!$result) {
		redirect(false, '등록이 되지 않았습니다. 다시 시도해주세요.');
		exit;
	}

	//asset-list 테이블로 복사한 후, 임시 DB 데이터 모두 삭제하기
	$sql = "DELETE FROM `temp-list";
	$input = array();
	$result = db_query($sql, $input);
	if (!$result) {
		redirect(false, '서버에 오류가 있습니다. 다시 시도해주세요.');
		exit;
	}
	echo "<meta http-equiv='refresh' content='0; url=./asset_regedit.php'> ";
	echo "<script type='text/javascript'>alert('" . '등록이 완료 됐습니다.' . "');</script>";
	//redirect(false, '등록이 완료 됐습니다.');
	//	exit;
}

	


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
