<?php

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