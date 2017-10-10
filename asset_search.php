<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';
?>
<?php
db_open();
?>
		<div class="main search">
			<div class="search_inner">
				<form method="post" class="edit_btn src_btn search" action="./asset_search.php">
					<label for="src_code">제품코드</label>
					<input type="text" name="src_code" class="src_form_control" value="">
					<label for="src_item">품목</label>
					<input type="text" name="src_item" class="src_form_control" value="">
					<label for="src_asset_no">자산번호</label>
					<input type="text" name="src_asset_no" class="src_form_control" value="">
					<label for="src_purchase_date">구입기간</label>
					<input type="text" name="src_purchase_date" class="src_form_control" value="">
					<button type="submit" class="btn btn_primary">검색하기</button>
				</form>
			</div>	
		</div>
		<div class="edit">
			<div>
				<table class="edit_table">
					<tr>
						<th>번호</th>
						<th>제품코드</th>
						<th>품목</th>
						<th>색상</th>
						<th>사이즈</th>
						<th>이미지</th>
						<th>제품위치</th>
						<th>구입일</th>
						<th>제조사</th>
						<th>구입처</th>
						<th>AS연락처</th>
						<th>자산번호</th>
						<th>자리번호</th>
						<th>사용자번호</th>
						<th>내구년한종료일</th>
						<th>구입처담당자</th>
					</tr>
						<?php
							if (!empty($_POST['src_code'])) {
								$src_code = $_POST['src_code'];
							} else {
								$src_code = '';
							}


							$sql = "SELECT * FROM `asset-list` WHERE `code` IN '$src_code'";
							$input = array();
							$result = db_query($sql, $input);
							for ($i = 0; $i < count($result); $i++) { 
						?>
					<tr class="edit_table_row">
						<td><?=$i + 1?></td>
						<td><?=$result[$i]['code']?></td>
						<td><?=$result[$i]['item']?></td>
						<td><?=$result[$i]['color']?></td>
						<td><?=$result[$i]['size']?></td>
						<td><img src="./images/product-img/<?=$result[$i]['image']?>" alt=""></td>
						<td><?=$result[$i]['location']?></td>
						<td><?=$result[$i]['purchase_date']?></td>
						<td><?=$result[$i]['manufacturer']?></td>
						<td><?=$result[$i]['wheretobuy']?></td>
						<td><?=$result[$i]['contact']?></td>
						<td><?=$result[$i]['asset_no']?></td>
						<td><?=$result[$i]['seat_no']?></td>
						<td><?=$result[$i]['user_no']?></td>
						<td><?=$result[$i]['expiry_date']?></td>
						<td><?=$result[$i]['administrator']?></td>										
					</tr>
						<?php }?>
					
				</table>
				<form method="post" class="edit_btn" action="./asset_regedit_action.php">
					<input type="hidden" name="regedit" value="등록하기">
					<button type="submit" class="btn btn_primary">등록하기</button>
				</form>			
			</div>
		</div>
<?php include './include/footer.php'; ?>


