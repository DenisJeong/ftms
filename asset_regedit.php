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
$regedit = array($code, $item, $color, $size,'', $location, $purchase_date, $manufacturer, $wheretobuy, $contact, $asset_no, $seat_no, $user_no, $expiry_date, $administrator);
$regedit_input = array($regedit);
for ($h = 0; $h < $number ; $h++) {
	 array_push($regedit_input, $regedit_input[$h]);
}
var_dump($regedit_input);





//var_dump($regedit_input[$array_number]);
//var_dump(count($regedit_input[$number]));

?>



	<div class="regedit">
		<div>
			<table class="regedit_table">
				<tr>
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
						for ($i = 0; $i < $number; $i++) { 
					?>
				<tr>
					<?php for ($j = 0; $j < count($regedit_input[$array_number]); $j++) { ?>
							<td><?php echo $regedit_input[$array_number][$j]?></td>
					<?php }?>
					
				</tr>
				<?php }?>
				<?php
						//var_dump($number);
						//var_dump(count($regedit_input[$array_number]));
					?>

			</table>
			<form method="post" class="regedit_btn" action="./asset_regedit_action.php">
				<button type="submit" class="btn btn_primary">등록하기</button>
			</form>			
		</div>
		<div class="regedit_form">
			<div class="regedit_form_left">
				<form method="post" action="./asset_regedit.php?number=<?=$number?>">
					<table class="regedit_form_table">
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
				<div class="regedit_form_right">
					<table class="regedit_form_table">
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
							<td><input type="text" class="form_control" name="expiry_date" id="expiry_date" placeholder="예)7years -> 반드시 숫자+years로 표기"></td>
						</tr>
						<tr>
							<th>구입처 담당자</th>
							<td><input type="text" class="form_control" name="administrator" id="administrator" placeholder="예)정진덕 -> 이름만 표기"></td>
						</tr>
					</table>
					<input type="text" name="number" id="number" value="<?php if (empty($line_number)) {
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