<?php
// DATABASE 접속객체
$_DB = false;

/**
 * 데이터베이스에 접속한다.
 */
function db_open()
{
    // 함수 밖에서 정의된 변수에 접근할 수 있도록 설정.
    global $_DB;

    /*	데이터베이스에 접속하기 위한 정보 정의하기 */
    $db_hostname = 'localhost';
    $db_database = 'fursysoc';
    $db_username = 'root';
    $db_password = '';
    $db_portnumber = 3306;
    $db_charset = 'utf8';

    /* 데이터베이스 접속 처리 */
    if ($_DB === false) {
        $_DB = @mysqli_connect($db_hostname, $db_username, $db_password,
            $db_database, $db_portnumber);

        // 에러가 존재한다면?
        if (mysqli_connect_errno()) {
            // 에러메시지 출력하기
            printf("<div style='padding: 15px; margin: 10px;
                            border: 1px solid #dca7a7; border-radius: 4px;
                            color: #a94442; background-color: #f2dede;'>
                        <strong>[Error: %d]</strong> %s</div>",
                mysqli_connect_errno(), mysqli_connect_error());
            // 웹 페이지 실행중단
            exit();
        } else {
            // 케릭터셋 설정하기
            @mysqli_set_charset($_DB, $db_charset);
        }
    }
}

/**
 * 데이터베이스 접속을 해제한다.
 */
function db_close()
{
    global $_DB;

    if ($_DB !== false) {
        /* 접속 해제 */
        @mysqli_close($_DB);
    }
}

/**
 * SQL구문을 실행한 후 결과를 리턴한다.
 *
 * @param   $sql - SQL구문의 템플릿. 변수로 치환할 곳은 %s, %d등의 이스케이프 문자를 사용한다.
 * @param   $params - $sql변수 내의 이스케이프 문자를 치환하기 위한 배열.
 *
 * @return 1) SQL구문에 에러가 있는 경우 FALSE가 리턴된다.
 *            2) SELECT문을 실행한 경우 -> 조회결과가 배열로 변환되어 리턴된다.
 *            3) INSERT문을 실행한 경우 -> 자동증가 일련번호값이 리턴된다.
 *            4) UPDATE,DELETE 문을 실행한 경우 -> 영향을 받은 행의 수가 리턴된다.
 */
function db_query($sql, $params)
{
    global $_DB;

    // 파라미터가 배열로 전달된 경우 배열의 각 요소에 SQL 특수문자 처리
    if (is_array($params)) {
        for ($i = 0; $i < count($params); ++$i) {
            $params[$i] = mysqli_real_escape_string($_DB, $params[$i]);
        }
        $sql = vsprintf($sql, $params);
    }

    // 쿼리 실행
    $result = @mysqli_query($_DB, $sql);

    // 에러 체크
    if (mysqli_errno($_DB)) {
        printf("<div style='padding: 15px; margin: 10px;
                        border: 1px solid #dca7a7; border-radius: 4px;
                        color: #a94442; background-color: #f2dede;'>
                    <strong>[SQL Error: %d]</strong> %s
                    <blockquote style='padding: 0 0 0 5px; margin: 10px 0 0 5px;
                        border-left: 3px solid #dca7a7'>
                        <i><small>%s</small></i></blockquote></div>",
            mysqli_errno($_DB), mysqli_error($_DB), $sql);

        exit(); // 에러가 발생했으므로 처리 중단 --> 개발중에만 사용하고 상용화시에는 삭제해야 함

        return false;
    }

    // SQL 구문 종류 분석
    $query_type = substr(strtolower(trim($sql)), 0, 6);

    // 구분 종류에 따라서 처리결과를 생성한다.
    $value = false;

    switch ($query_type) {
        case 'insert':
            // 자동증가 일련번호 값 리턴하기
            $value = mysqli_insert_id($_DB);
            break;
        case 'delete':
        case 'update':
            // 영향을 받은 행의 수 리턴하기
            $value = mysqli_affected_rows($_DB);
            break;
        case 'select':
            // 조회결과를 배열로 변환하여 리턴
            // MYSQLI_ASSOC, MYSQLI_NUM, MYSQLI_BOTH
            $value = mysqli_fetch_all($result, MYSQLI_ASSOC);
            break;
    }

    // 처리결과 리턴
    return $value;
}



if (!function_exists('mysqli_fetch_all')) {
    function mysqli_fetch_all($result, $mode = 0) {
        $all = FALSE;
        if ($result) {
            $all = array();
            while($row = mysqli_fetch_array($result)) {
                $all[] = $row;
            }
        }

        return $all;
    }
}




