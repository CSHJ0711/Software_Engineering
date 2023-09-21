<?php
// 데이터베이스 연결 정보 설정
$servername = "localhost";
$username = "semin1127";
$password = "tpals1528!";
$dbname = "semin1127";

// DB 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DB Query
$sql = "DELETE FROM movie_info WHERE movieId=".$_GET["movieId"];
$result = $conn->query($sql);

// DB 연결 종료
$conn->close();

header("Location: manage_movie.php");
exit();
?>
