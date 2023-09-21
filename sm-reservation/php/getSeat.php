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
$selMovieId = $_GET["selMovieId"];
$selDate = $_GET["selDate"];
$selTime = $_GET["selTime"];

// 해당 스케쥴에 대한 좌석 정보 가져오기
$query = "SELECT * FROM schedule WHERE movieId='$selMovieId' AND date='$selDate' AND time='$selTime'";
$result = $link->query($query);

// 결과를 배열로 저장
$data = array();
$i = 3;
$row = $result->fetch_row();
if ($result->num_rows > 0) {
    while($i < $result->field_count) {
        array_push($data, $row[$i++]);
    }
}

// JSON 형식으로 결과 반환
header('Content-Type: application/json');
echo json_encode($data);

// 데이터베이스 연결 종료
$link->close();
?>