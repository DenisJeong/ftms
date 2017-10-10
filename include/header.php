<?php header("Content-Type: text/html; charset=UTF-8"); ?>

<!DOCTYPE html>
<html lang="ko-KR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>FTMS(Floorplan Tangible asset Management System</title>
	<link rel="stylesheet" href="./css/style.css" type="text/css" media="all" />
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/jquery.watermark.min.js"></script>
	<script type="text/javascript" src="./js/script.js"></script>
</head>
<body>
	<div class="header">
		<div class="header_inner">
			<div class="header_logo">
				<a href="./index.php"><img src="./images/giants-logo.jpg" alt="logo"></a>
			</div>
			<div class="header_title">
				<h1>도면기반 유형자산 관리 시스템</h1>
			</div>
			<div class="header_btn">	
				<form method="post" action="./asset_regedit.php">
					
						<button class="btn btn_primary" type="submit">자산등록하기</button>
				</form>
				<form method="post" action="./asset_search.php">
						<button class="btn btn_primary" type="submit">자산검색하기</button>
				</form>
			</div>
		</div>
	</div>