<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';

//db_open();
//$sql = "SELECT * FROM ";

//$code = $_GET['product'];


?>

	<div class="main container">
		<div class="left_container">
			<div class="image_box">
				<a href="#">
					<img src="./images/ch4300h.jpg" alt="" title="제품상세보기">
				</a>				
			</div>	
		</div>
		<div class="right_container">
			<h2>제품 정보</h2>
			<table class="product_table">
				<tr>
					<th>제조사 제품코드</th>
					<td></td>
				</tr>
				<tr>
					<th>제조사</th>
					<td></td>
				</tr>
				<tr>
					<th>품목</th>
					<td></td>
				</tr>
				<tr>
					<th>색상(코드)</th>
					<td></td>
				</tr>
				<tr>
					<th>제품사이즈</th>
					<td></td>
				</tr>
			</table>
			<h2>자산 정보</h2>
			<table class="product_table">
				<tr>
					<th>자산번호</th>
					<td></td>
				</tr>
				<tr>
					<th>구매년월</th>
					<td></td>
				</tr>
				<tr>
					<th>내구년한 종료일</th>
					<td></td>
				</tr>
				<tr>
					<th>구매처</th>
					<td></td>
				</tr>
				<tr>
					<th>AS담당자</th>
					<td></td>
				</tr>
			</table>	
		</div>
	</div>
<?php include './include/footer.php'; ?>