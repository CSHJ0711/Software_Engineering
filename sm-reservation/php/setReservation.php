<?php
session_start();

// 데이터베이스 연결 정보 설정
$servername = "localhost";
$username = "semin1127";
$password = "tpals1528!";
$dbname = "semin1127";

// 데이터베이스 연결
$link = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// PHP 문자 인코딩 설정
mysqli_set_charset($link, "utf8");

// GET로부터 영화와 날짜 정보 받아오기
$selMovieId = $_GET["selMovieId"];
$selDate = $_GET["selDate"];
$selTime = $_GET["selTime"];
$selSeat = explode(',', $_GET['selSeat']);

// reservation 테이블에 예약 정보를 입력하는 쿼리
$query = "SELECT * FROM reservation WHERE user_id='".$_SESSION["user_id"]."' AND movieId='$selMovieId' AND date='$selDate' AND time='$selTime' AND seat='".$_GET["selSeat"]."'";
$result = $link->query($query);
if ($result->num_rows == 0) {
    $query = "INSERT INTO reservation VALUES('".$_SESSION["user_id"]."', '$selMovieId', '$selDate', '$selTime', '".$_GET['selSeat']."')";
    $result = $link->query($query);
    
    foreach ($selSeat as $seat) {
        // schedule 테이블의 좌석 정보를 '이미 예약된 좌석'으로 변경하는 쿼리
        $query = "UPDATE schedule SET $seat=1 WHERE movieId='$selMovieId' AND date='$selDate' AND time='$selTime'";
        $result = $link->query($query);    
    }
}

// JSON 형식으로 결과 반환
$response = ['status' => 'success'];
echo json_encode($response);

// 데이터베이스 연결 종료
$conn->close();
?>