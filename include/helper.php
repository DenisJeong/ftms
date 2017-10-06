<?php
/**
 * HTTP GET 파라미터 값을 수신한다.
 *
 * @param $key - 파라미터 이름
 * @param $def - 값이 없을 경우 사용될 기본값.
 */
function get($key, $def)
{
    // 일단 기본값으로 변수 생성
    $value = $def;

    // $key를 이름으로 하는 파라미터가 존재한다면?
    if (isset($_GET[$key])) {
        // 리턴할 변수를 HTTP GET 파라미터로 재설정
        $value = $_GET[$key];

        // 배열이 아니라면?
        if (!is_array($value)) {
            // 앞,뒤 공백 제거
            $value = trim($value);

            // 길이가 1보다 작다면?
            if (mb_strlen($value) < 1) {
                // 전달된 값이 없는 경우이므로 기본값으로 재설정
                $value = $def;
            }
        }
    }

    // 최종 값 리턴
    return $value;
}

/**
 * 메시지를 화면에 표시한 후, 저정된 페이지로 강제 이동 시킨다.
 *
 * @param $url - 이동할 페이지 경로. FALSE로 지정한 경우 이전 페이지로 이동
 * @param $msg - 화면에 표시할 메시지. FALSE인 경우 표시 안함.
 */
function redirect($url, $msg)
{
    $html = '<!doctype html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= "<meta charset='utf-8'>";

    // 메시지가 전달된 경우
    if ($msg != false) {
        $html .= "<script type='text/javascript'>alert('" . $msg . "');</script>";
    }

    // 이동할 URL이 전달된 경우
    if ($url != false) {
        $html .= "<meta http-equiv='refresh' content='0; url=" . $url . "''>";
    } else {
        $html .= "<script type='text/javascript'>history.back();</script>";
    }

    $html .= '</head>';
    $html .= '<body></body>';
    $html .= '</html>';
    echo($html);
    exit();
}

/**
 * HTTP POST 파라미터 값을 수신한다.
 *
 * @param $key - 파라미터 이름
 * @param $def - 값이 없을 경우 사용될 기본값.
 */
function post($key, $def)
{
    // 일단 기본값으로 변수 생성
    $value = $def;

    // $key를 이름으로 하는 파라미터가 존재한다면?
    if (isset($_POST[$key])) {
        // 리턴할 변수를 HTTP POST 파라미터로 재설정
        $value = $_POST[$key];

        // 배열이 아니라면?
        if (!is_array($value)) {
            // 앞,뒤 공백 제거
            $value = trim($value);

            // 길이가 1보다 작다면?
            if (mb_strlen($value) < 1) {
                // 전달된 값이 없는 경우이므로 기본값으로 재설정
                $value = $def;
            }
        }
    }

    // 최종 값 리턴
    return $value;
}

/**
 * 메일을 발송한다.
 *
 * @param $sender - 보내는 사람 메일 주소.
 * @param $sender_name - 보내는 사람의 이름.
 * @param $receiver - 받는 사람 메일 주소
 * @param $receiver_name - 받는 사람의 이름
 * @param $subject - 메일 제목
 * @param $content - 메일 내용
 */
function send_mail($sender, $sender_name, $receiver, $receiver_name, $subject, $content)
{
    // 리턴할 결과값
    $is_mail_send_ok = false;

    // __FILE__ --> 현재 파일(helper.php)의 경로값
    // dirname(...) --> 주어진 경로에서 상위 폴더까지의 경로를 리턴한다.
    $inc_dir = dirname(__FILE__);
    include_once $inc_dir . '/PHPMailer/PHPMailerAutoload.php';

    /* 메일 발송 기능 초기화 */
    $mail = new PHPMailer();
    $mail->CharSet = 'utf-8';
    $mail->Encoding = 'base64';
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '자신의 Gmail 주소';
    $mail->Password = '자신의 Gmail 비밀번호';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->isHTML(true);

    /* 보내는 사람 정보 설정 */
    $mail->From = $sender;
    $mail->FromName = $sender_name;

    /* 받는 사람 정보 설정 */
    $mail->addAddress($receiver, $receiver_name);

    /* 제목과 내용 */
    $mail->Subject = $subject;
    $mail->Body = $content;

    /* 발송 및 발송 결과 처리 */
    $is_mail_send_ok = $mail->send();

    return $is_mail_send_ok;
}

/**
 * 파일 업로드를 수행하고, 업로드된 파일의 정보를 리턴한다.
 *
 * @param   $name - 원본 파일이름
 * @param   $type - 파일형식
 * @param   $size - 파일크기
 * @param   $tmp_name - 임시파일명
 *
 * @return 파일의 정보가 저장되어 있는 배열
 */
function single_upload($original_file_name, $type, $size, $tmp_name, $file_name)
{
    // 리턴할 업로드 정보
    $upload_data = false;

    // 원본명이 없거나 용량이 없다면 처리 중단
    if (!$original_file_name || $size < 1) {
        return false;
    }

    /*파일이 저장될 폴더 준비하기*/
    //DocumentRoot 안에서의 저장폴더 경로를 구성한다.
    $upload_dir_uri = "/images";
    //DocumentRoot의 실제 경로를 얻어와서 전체 경로를 구성한다.
    $upload_dir_path = $_SERVER['DOCUMENT_ROOT'] . $upload_dir_uri;
    //폴더가 없으면 중지.
    if (!is_dir($upload_dir_path)) {
        echo ("<h2>폴더가 없습니다. 관리자에게 문의해주세요.</h2>");
    } 

    /*파일의 저장될 경로명 준비하기*/
    //파일의 확장자는 원본 이름에서 추출한다.
    $p = strrpos($original_file_name, '.');
    $l = strlen($original_file_name);
    $file_ext = strtolower(substr($original_file_name, $p, $l - $p));

    $file_name = '';    // 파일이 복사될 이름
    $upload_uri = '';   // 파일이 복사될 웹 상의 경로
    $upload_path = '';  // 파일이 복사될 전체 경로

    // 일단 무한루프
    //파일이 복사될 이름
    $file_name = 'works-logo-' . date('Y-m-d') . $file_ext;
    for ($i = 1; $i > 0 ; $i++) { 
        
        //파일이 복사될 웹 상의 경로
        $upload_uri = $upload_dir_uri . '/' . $file_name;
        //파일이 복사될 전체 경로
        $upload_path = $upload_dir_path . '/' . $file_name;

        //같은 이름의 파일이 없다면 반복 종료
        if (!is_file($upload_path)) {
            break;
         } else {
            $file_name = 'works-logo-' . date('Y-m-d') . "-{$i}" . $file_ext;
         }
    }

    /*파일 복사하기*/
    $is_copy = move_uploaded_file($tmp_name, $upload_path);
    if ($is_copy) {
        chmod($upload_path, 0777);
    }
        // 업로드 처리에 사용된 결과값들을 미리 준비한 변수에 배열 형태로 저장한다.
        $upload_data = array(
            'name' => $original_file_name,
            'type' => $type,
            'size' => $size,
            'upload_path' => $upload_path,
            'upload_uri' => $upload_uri,
            'file_name' => $file_name,
        );
     return $upload_data;
}

/**
 * 싱글, 멀티 파일 업로드를 구분하여 처리한다.
 *
 * @param   $field - <input type='file'>에 적용한 name속성값
 *
 * @return 파일의 정보가 저장되어 있는 배열
 */
function do_upload($field)
{
    // 리턴할 데이터
    $rt = array();

    /* 1) 해당 필드가 존재하는지 체크 */
    if (!isset($_FILES[$field])) {
        return false;  // 업로드 필드 없음
    }

    /* 2) 임시폴더에 업로드된 파일의 정보 얻기 */
    $name = $_FILES[$field]['name'];
    $type = $_FILES[$field]['type'];
    $size = $_FILES[$field]['size'];
    $tmp_name = $_FILES[$field]['tmp_name'];

    /* 3) 싱글,멀티 업로드 구분 */
    if (!is_array($name)) {
        // 파일이름이 배열이 아닌 경우 (싱글업로드)
        $upload = single_upload($name, $type, $size, $tmp_name);
        if ($upload !== false) {
            $rt[0] = $upload;
        }
    } else {
        // 멀티 업로드
        $count = count($name);
        $index = 0;
        for ($i = 0; $i < $count; ++$i) {
            $upload = single_upload($name[$i], $type[$i], $size[$i], $tmp_name[$i]);
            if ($upload !== false) {
                $rt[$index] = $upload;
                ++$index;
            }
        }
    }

    return $rt;
}

/**
 * easy image resize function.
 *
 * @param  $file - file name to resize
 * @param  $string - The image data, as a string
 * @param  $width - new image width
 * @param  $height - new image height
 * @param  $proportional - keep image proportional, default is no
 * @param  $output - name of the new file (include path if needed)
 * @param  $delete_original - if true the original image will be deleted
 * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
 * @param  $quality - enter 1-100 (100 is best quality) default is 100
 *
 * @return bool|resource
 */
function smart_resize_image($file,
                            $string = null,
                            $width = 0,
                            $height = 0,
                            $proportional = false,
                            $output = 'file',
                            $delete_original = true,
                            $use_linux_commands = false,
                            $quality = 100)
{
    if ($height <= 0 && $width <= 0) {
        return false;
    }
    if ($file === null && $string === null) {
        return false;
    }

    # Setting defaults and meta
    $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
    $image = '';
    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
    $cropHeight = $cropWidth = 0;

    # Calculating proportionality
    if ($proportional) {
        if ($width == 0) {
            $factor = $height / $height_old;
        } elseif ($height == 0) {
            $factor = $width / $width_old;
        } else {
            $factor = min($width / $width_old, $height / $height_old);
        }

        $final_width = round($width_old * $factor);
        $final_height = round($height_old * $factor);
    } else {
        $final_width = ($width <= 0) ? $width_old : $width;
        $final_height = ($height <= 0) ? $height_old : $height;
        $widthX = $width_old / $width;
        $heightX = $height_old / $height;

        $x = min($widthX, $heightX);
        $cropWidth = ($width_old - $width * $x) / 2;
        $cropHeight = ($height_old - $height * $x) / 2;
    }

    # Loading image to memory according to type
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
            break;
        case IMAGETYPE_GIF:
            $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
            break;
        case IMAGETYPE_PNG:
            $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
            break;
        default:
            return false;
    }

    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor($final_width, $final_height);
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $transparency = imagecolortransparent($image);
        $palletsize = imagecolorstotal($image);

        if ($transparency >= 0 && $transparency < $palletsize) {
            $transparent_color = imagecolorsforindex($image, $transparency);
            $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
        } elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);

    # Taking care of original, if needed
    if ($delete_original) {
        if ($use_linux_commands) {
            exec('rm ' . $file);
        } else {
            @unlink($file);
        }
    }

    # Preparing a method of providing result
    switch (strtolower($output)) {
        case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $output = null;
            break;
        case 'file':
            $output = $file;
            break;
        case 'return':
            return $image_resized;
            break;
        default:
            break;
    }

    # Writing image according to type to the output destination and image quality
    switch ($info[2]) {
        case IMAGETYPE_GIF:
            imagegif($image_resized, $output);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image_resized, $output, $quality);
            break;
        case IMAGETYPE_PNG:
            $quality = 9 - (int)((0.9 * $quality) / 10.0);
            imagepng($image_resized, $output, $quality);
            break;
        default:
            return false;
    }

    return true;
}

/**
 * 크롭처리된 썸네일 이미지를 생성한다.
 */
function image_crop($orgin_path, $thumb_path, $width, $height)
{
    if (file_exists($orgin_path) && !file_exists($thumb_path)) {
        smart_resize_image($orgin_path,     // 원본 파일의 경로
            false,          // 이미지를 읽어들인 바이너리 문자열 (사용안함)
            $width,         // 가로크기
            $height,        // 세로크기
            false,          // 이미지의 비율을 유지할지 여부. false일 경우 crop처리함
            $thumb_path,    // 썸네일이 생성될 경로
            false,          // 원본을 삭제할지 여부 (true=삭제함)
            false,          // 리눅스 명령어를 사용할지 여부 (사용안함)
            100             // 이미지 퀄리티(%)
        );
    }
}

/**
 * 리사이즈된 썸네일 이미지를 생성한다.
 */
function image_resize($orgin_path, $thumb_path, $width, $height)
{
    if (file_exists($orgin_path) && !file_exists($thumb_path)) {
        smart_resize_image($orgin_path,     // 원본 파일의 경로
            false,          // 이미지를 읽어들인 바이너리 문자열 (사용안함)
            $width,         // 가로크기
            $height,        // 세로크기
            true,           // 이미지의 비율을 유지할지 여부. false일 경우 crop처리함
            $thumb_path,    // 썸네일이 생성될 경로
            false,          // 원본을 삭제할지 여부 (true=삭제함)
            false,          // 리눅스 명령어를 사용할지 여부 (사용안함)
            100             // 이미지 퀄리티(%)
        );
    }
}

/**
 * 쿠키값을 저장한다.
 *
 * @param   $key - 쿠키이름
 * @param   $value - 쿠키값
 * @param   $time - 저장시간
 *                 (60=60초 유지, 0=브라우저를 닫을 경우 즉시 삭제, 음수=즉시삭제)
 *
 * @return bool (true=성공, false=실패)
 */
function set_cookie($key, $value, $time)
{
    if ($time != 0) {
        $time += time();
    }

    return setcookie($key, urlencode($value), $time, '/');
}

/**
 * 쿠키값을 읽어온다.
 *
 * @param $key - 쿠키 이름
 * @param $def - 값이 없을 경우 사용될 기본값.
 */
function get_cookie($key, $def)
{
    // 일단 기본값으로 변수 생성
    $value = $def;

    // $key를 이름으로 하는 쿠키가 존재한다면?
    if (isset($_COOKIE[$key])) {
        // 리턴할 변수를 쿠키값으로 재설정
        $value = $_COOKIE[$key];

        // 배열이 아니라면?
        if (!is_array($value)) {
            // URLDecode 처리 후 - 앞,뒤 공백 제거
            $value = trim(urldecode($value));

            // 길이가 1보다 작다면?
            if (mb_strlen($value) < 1) {
                // 전달된 값이 없는 경우이므로 기본값으로 재설정
                $value = $def;
            }
        }
    }

    // 최종 값 리턴
    return $value;
}

/**
 * 세션값을 읽어온다.
 *
 * @param $key - 세션 이름
 * @param $def - 값이 없을 경우 사용될 기본값.
 */
function get_session($key, $def)
{
    // 일단 기본값으로 변수 생성
    $value = $def;

    // $key를 이름으로 하는 세션값이 존재한다면?
    if (isset($_SESSION[$key])) {
        // 리턴할 변수를 세션값으로 재설정
        $value = $_SESSION[$key];

        // 배열이 아니라면?
        if (!is_array($value)) {
            // 앞,뒤 공백 제거
            $value = trim($value);

            // 길이가 1보다 작다면?
            if (mb_strlen($value) < 1) {
                // 전달된 값이 없는 경우이므로 기본값으로 재설정
                $value = $def;
            }
        }
    }

    // 최종 값 리턴
    return $value;
}

/**
 * 변수값을 화면에 출력한다. (테스트용).
 */
function debug($value)
{
    echo("<div style='padding: 15px; margin: 10px;
                border: 1px solid #bce8f1; border-radius: 4px;
                color: #31708f; background-color: #d9edf7;'>
            <strong>[Debug Message]</strong> <br/>
            <pre style='margin-bottom: 0px; margin-top: 5px; padding: 0; border:0; background: none;'>");
    print_r($value);
    echo('</pre></div>');
}

/*
 * 페이지 구현에 필요한 변수값들을 계산한다.
 * @param  $total_count 	- 페이지 계산의 대상이 되는 전체 데이터 수
 * @param  $now_page 		- 현재 페이지
 * @param  $list_count 		- 한 페이지에 보여질 목록의 수
 * @param  $group_count 	- 페이지 그룹 수
 * @return Array - now_page 	: 현재 페이지
 *               - total_count 	: 전체 데이터 수
 *               - list_count 	: 한 페이지에 보여질 목록의 수
 *               - total_page 	: 전체 페이지 수
 *               - group_count 	: 한 페이지에 보여질 그룹의 수
 *               - total_group 	: 전체 그룹 수
 *               - now_group 	: 현재 페이지가 속해 있는 그룹 번호
 *               - group_start 	: 현재 그룹의 시작 페이지
 *               - group_end 	: 현재 그룹의 마지막 페이지
 *               - prev_group_last_page  : 이전 그룹의 마지막 페이지
 *               - next_group_first_page : 다음 그룹의 시작 페이지
 *               - offset 		: SQL의 LIMIT절에서 사용할 데이터 시작 위치
 */
function get_page_info($total_count, $now_page, $list_count, $group_count)
{
    // 현제 페이지 번호가 없다면 1페이지로 강제 설정
    if (!$now_page) {
        $now_page = 1;
    }

    // 한 페이지의 목록 수가 정해지지 않았다면 15개로 강제 설정
    if (!$list_count) {
        $list_count = 15;
    }

    // 한 페이지당 그룹 수가 정해지지 않았다면 5개로 강제 설정
    if (!$group_count) {
        $group_count = 5;
    }

    // 전체 페이지 수
    $total_page = intval((($total_count - 1) / $list_count)) + 1;

    // 전체 그룹 수
    $total_group = intval((($total_page) - 1) / ($group_count)) + 1;

    // 현재 페이지가 속한 그룹
    $now_group = intval((($now_page - 1) / $group_count)) + 1;

    // 현재 그룹의 시작 페이지 번호
    $group_start = intval((($now_group - 1) * $group_count)) + 1;

    // 현재 그룹의 마지막 페이지 번호
    $group_end = min($total_page, $now_group * $group_count);

    // 이전 그룹의 마지막 페이지 번호
    $prev_group_last_page = 0;
    if ($group_start > $group_count) {
        $prev_group_last_page = $group_start - 1;
    }

    // 다음 그룹의 시작 페이지 번호
    $next_group_first_page = 0;
    if ($group_end < $total_page) {
        $next_group_first_page = $group_end + 1;
    }

    // LIMIT 절에서 사용할 데이터 시작 위치
    $offset = ($now_page - 1) * $list_count;

    // 리턴할 데이터들을 배열로 묶기
    $data = array('now_page' => $now_page,
        'total_count' => $total_count,
        'list_count' => $list_count,
        'total_page' => $total_page,
        'group_count' => $group_count,
        'total_group' => $total_group,
        'now_group' => $now_group,
        'group_start' => $group_start,
        'group_end' => $group_end,
        'prev_group_last_page' => $prev_group_last_page,
        'next_group_first_page' => $next_group_first_page,
        'offset' => $offset,);

    return $data;
}

/*
 * 배열에 담긴 모든 값을 URLEncode 처리하여 리턴한다.
 * @param 	$data - 변환할 배열
 * @return  array
 */
function array_urlencode($data)
{
    if (is_array($data)) {
        $new_data = array();
        foreach ($data AS $k => $v) {
            if (is_array($v)) {
                $new_data[$k] = array_urlencode($v);
            } else {
                $new_data[$k] = urlencode($v);
            }
        }
    } else {
        $new_data = urlencode($data);
    }

    return $new_data;
}


/*
 * 배열을 분석하여 JSON 데이터로 생성한다.
 * @param 	$rt - 결과코드 (OK OR FAIL)
 * @param 	$data - 생성할 데이터
 * @return  string
 */
function print_rest_api($rt, $data)
{
    $buffer['rt'] = $rt;    // 결과 메시지
    $buffer['pubdate'] = date('Y-m-d H:i:s', time());   // 생성 날짜

    if ($data) {    // 데이터가 존재한다면 두 배열을 병합한다.
        $buffer = array_merge($buffer, $data);
    }

    $enc_data = array_urlencode($buffer);       // 배열의 모든 값을 URLEncode 처리한다.
    $json = urldecode(json_encode($enc_data));  // 배열을 JSON으로 변환한다.

    // 브라우저에게 전달되는 컨텐츠 종류 설정 후 출력
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    echo($json);
    exit();
}
