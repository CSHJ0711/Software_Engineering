<?php
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
$movieId = $_GET["movieId"];
$selDate = $_GET["selDate"];

// 상영 시간 정보 가져오기
$query = "SELECT time FROM schedule WHERE movieId='$movieId' AND date='$selDate' ORDER BY time ASC";
$result = $link->query($query);

// 결과를 배열로 저장
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($data, $row["time"]);
    }
}

// JSON 형식으로 결과 반환
header('Content-Type: application/json');
echo json_encode($data);

// 데이터베이스 연결 종료
$link->close();
?>