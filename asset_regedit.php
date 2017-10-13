<?php
include './include/header.php';
include_once './include/helper.php';
include_once './include/db_helper.php';
?>


<?php
// asset_regedit 입력창에서 GET과 POST로 받기
if (!empty($_POST['code'])) {
	$code = $_POST['code'];
} else { $code = ''; }
if (!empty($_POST['item'])) {
	$item = $_POST['item'];
} else { $item = ''; }
if (!empty($_POST['color'])) {
	$color = $_POST['color'];
} else { $color = ''; }
if (!empty($_POST['size'])) {
	$product_size = $_POST['size'];
} else { $product_size = ''; }
if (!empty($_POST['location'])) {
	$location = $_POST['location'];
} else { $location = ''; }
if (!empty($_POST['purchase_date'])) {
	$purchase_date = $_POST['purchase_date'];
	$y = substr($purchase_date, 0, 2);
	$m = substr($purchase_date, 2, 2);
	$d = substr($purchase_date, 4, 2);
	$purchase_ymd = '20' . $y . '-' .  $m . '-' .  $d; 
	//var_dump($purchase_ymd);
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
	//이유는 모르겠으나 2037년 후는 입력이 안된다. 32비트 버그라고 함.
	$calculated_expiry_date = date("Y-m-d", strtotime($purchase_ymd . "+" . $expiry_date . "year"));
	//var_dump($calculated_expiry_date);
} else { $expiry_date = ''; $calculated_expiry_date = '';}
if (!empty($_POST['administrator'])) {
	$administrator = $_POST['administrator'];
} else { $administrator = ''; }

if (!empty($_POST['number'])) {
	$number = (int)$_POST['number'];
	$line_number = $number + 1;
} else { 
	$number = 0;
	$line_number = $number + 1;
}
	$array_number = $number - 1;
//var_dump($number);
//var_dump($line_number);

/* 제품이미지 이미지 파일 업로드*/


if (!empty($_FILES)) {
	$original_file_name = $_FILES['product_image']['name']; // 파일의 원본 이름
	$type = $_FILES['product_image']['type'];		 // 파일의 형식
	$size = $_FILES['product_image']['size'];		 // 파일의 용량
	$tmp_name = $_FILES['product_image']['tmp_name']; // 서버에 업로드 된 임시파일 이름
		// 파일의 확장자 추출하기
		$p = strrpos($original_file_name, '.');
	    $l = strlen($original_file_name);
	    $file_ext = strtolower(substr($original_file_name, $p, $l - $p));
	$file_name = $code . $file_ext;
	var_dump($file_name);
	//if (!empty($temp_list['product_image'])) {
	//	$uploaded_file_name = './images/product-img/' . $temp_list['product_image'];
		//var_dump($del_file_name);
	//}
	$upload_data = single_upload($original_file_name, $type, $size, $tmp_name, $file_name);
	$file_name = $upload_data['file_name'];
}

//if (!$upload_data) {
//	redirect(false, '업로드에 실패했습니다.');
//	exit;
//} else {
  	//echo("<h2>업로드 된 파일 정보</h2>");
	//echo("<pre>");
	//print_r($upload_data);
	//echo("</pre>");
  
//}

// 이미지 파일 업로드 끝/*
db_open();

//asset_list DB에서 가장 큰 id값 받기 (id 중복을 방지하기 위해)
$sql = "SELECT MAX(id) FROM `asset-list`";
$input = array();
$result = db_query($sql, $input);
$id = (int)$result[0]['MAX(id)'] + 1;
var_dump($id);

//var_dump($code);
if ($line_number > 1 && $line_number <= 2)  {
	$regedit = array($id, $code, $item, $color, $product_size, $file_name, $location, $purchase_date, $manufacturer, $wheretobuy, $contact, $asset_no, $seat_no, $user_no, $calculated_expiry_date, $administrator);
	$regedit_input = array($regedit);
} else if ($line_number > 2) {
	$regedit = array($code, $item, $color, $product_size, $file_name, $location, $purchase_date, $manufacturer, $wheretobuy, $contact, $asset_no, $seat_no, $user_no, $calculated_expiry_date, $administrator);
	$regedit_input = array($regedit);
} else {
	$regedit = '';
}
	

//var_dump($regedit_input);



//임시로 DB에 저장하기(temp-list 테이블)
if ($line_number > 1 && $line_number <= 2) {
	$sql_body = "SET id = '%d', code = '%s', item = '%s', color = '%s', size = '%s', image = '%s', location = '%s', purchase_date = '%s', manufacturer = '%s', wheretobuy = '%s', contact = '%s', asset_no = '%s', seat_no = '%s', user_no = '%s', expiry_date = '%s', administrator = '%s'";
	//var_dump($sql_body);
	$sql = "INSERT INTO `temp-list` {$sql_body}";
	$input = $regedit;
	$result = db_query($sql, $input);
	$temp_list = $result;
} else if ($line_number > 2) {
	$sql_body = "SET code = '%s', item = '%s', color = '%s', size = '%s', image = '%s', location = '%s', purchase_date = '%s', manufacturer = '%s', wheretobuy = '%s', contact = '%s', asset_no = '%s', seat_no = '%s', user_no = '%s', expiry_date = '%s', administrator = '%s'";
	//var_dump($sql_body);
	$sql = "INSERT INTO `temp-list` {$sql_body}";
	$input = $regedit;
	$result = db_query($sql, $input);
	$temp_list = $result;
}

//var_dump($regedit_input[$array_number]);
//var_dump(count($regedit_input[$number]));

?>



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
						$sql = "SELECT * FROM `temp-list` ORDER BY `id` DESC";
						$input = $regedit;
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
		<div class="edit_form">
			<div class="edit_form_left">
				<form method="post" action="./asset_regedit.php" enctype="multipart/form-data">
					<table class="edit_form_table">
						<tr>
							<th>제조사 제품코드</th>
							<td><input type="text" class="form_control" name="code" id="code" placeholder="예)CHN4300AH"></td>
						</tr>
						<tr>
							<th>품목</th>
							<td><input type="text" class="form_control" name="item" id="item" placeholder="예)업무용의자"></td>
						</tr>
						<tr>
							<th>색상/코드</th>
							<td><input type="text" class="form_control" name="color" id="color" placeholder="예)코드가 있으면 코드를 없으면 주관적 색상 예) 검붉은색"></td>
						</tr>
						<tr>
							<th>제품사이즈</th>
							<td><input type="text" class="form_control" name="size" id="size" placeholder="예)1600x800x720"></td>
						</tr>
						<tr>
							<th>제품이미지업로드</th>
							<td><input type="file" class="form_control" name="product_image" id="product_image"></td>
						</tr>
						<tr>
							<th>제품위치</th>
							<td><input type="text" class="form_control" name="location" id="location" placeholder="예)퍼시스빌딩 2층 총무팀"></td>
						</tr>
						<tr>
							<th>구입일</th>
							<td><input type="text" class="form_control" name="purchase_date" id="purchase_date" placeholder="예)17년 1월 1일은 170101로 표기"></td>
						</tr>
						<tr>
							<th>제조사</th>
							<td><input type="text" class="form_control" name="manufacturer" id="manufacturer" placeholder="예)퍼시스"></td>
						</tr>
					</table>			
				</div>
				<div class="edit_form_right">
					<table class="edit_form_table">
						<tr>
							<th>구입처</th>
							<td><input type="text" class="form_control" name="wheretobuy" id="wheretobuy" placeholder="예)퍼시스 오피스컨설팅그룹"></td>
						</tr>
						<tr>
							<th>AS연락처</th>
							<td><input type="text" class="form_control" name="contact" id="contact" placeholder="예)070-4800-3599"></td>
						</tr>
						<tr>
							<th>자산번호</th>
							<td><input type="text" class="form_control" name="asset_no" id="asset_no" placeholder="예)자산관리팀에서 부여한 번호/모르면 빈칸"></td>
						</tr>
						<tr>
							<th>자리번호</th>
							<td><input type="text" class="form_control" name="seat_no" id="seat_no" placeholder="예)자산관리팀에서 부여한 번호/모르면 빈칸"></td>
						</tr>
						<tr>
							<th>사용자번호</th>
							<td><input type="text" class="form_control" name="user_no" id="user_no" placeholder="예)자산관리팀에서 부여한 번호/모르면 빈칸"></td>
						</tr>
						<tr>
							<th>내구년한</th>
							<td><input type="text" class="form_control" name="expiry_date" id="expiry_date" placeholder="예)7년 -> 7 (반드시 년도 숫자로만 표기)"></td>
						</tr>
						<tr>
							<th>구입처 담당자</th>
							<td><input type="text" class="form_control" name="administrator" id="administrator" placeholder="예)정진덕 -> 이름만 표기"></td>
						</tr>
					</table>
					<input type="hidden" name="number" id="number" value="<?php if (empty($line_number)) {
																					$line_number = 0;
																					echo($line_number);
																				} else {
																					echo($line_number);
																				}?>">
					<button type="submit" class="btn btn_primary">입력하기</button>
				</form>
			</div>
		</div>
	</div>
	<br>
<?php include './include/footer.php'; ?>


				<!--<td><?=$code?></td>
					<td><?=$item?></td>
					<td><?=$color?></td>
					<td><?=$size?></td>
					<td></td>
					<td><?=$location?></td>
					<td><?=$purchase_date?></td>
					<td><?=$manufacturer?></td>
					<td><?=$wheretobuy?></td>
					<td><?=$contact?></td>
					<td><?=$asset_no?></td>
					<td><?=$seat_no?></td>
					<td><?=$user_no?></td>
					<td><?=$expiry_date?></td>
					<td><?=$administrator?></td>
				-->