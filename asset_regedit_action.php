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


