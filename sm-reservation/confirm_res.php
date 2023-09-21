<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
    <link rel="stylesheet" href="./css/showtime.css">
    <link rel="stylesheet" href="../movie/set/manage_movie.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <title>예매내역 확인 | GW시네마</title>
</head>
<body>
    <!--header-->
    <header>
		<div class="container">
			<div class="row">
				<div class="header clearfix">
					<h1>
                        <a href="../index.html">
                            <em><img src="../movie/src/gwnu.png" alt="GWNU"></em>
                            <strong><img src="../movie/src/gwnu_long.png" alt="GWNU_Long"></strong>
                        </a>
					</h1>
					<nav class="nav">
						<ul class="clearfix">
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <li><a href="../login/logout.php">로그아웃</a></li>
                                <?php }else { ?>
                                <li><a href="../login/movie_login.php">로그인</a></li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <li><a href="../login/mypage.php">마이페이지</a></li>
                                <?php }else { ?>
                                    <li><a href="../login/movie_login.php">마이페이지</a></li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                <li><a href="./confirm_res.html">예매내역 확인</a></li>
                                <?php }else { ?>
                                <li><a href="../login/movie_login.php">예매내역 확인</a></li>
                                <?php } ?>
                                <?php if ($_SESSION['user_id'] == 'admin') { ?>
                                <li><a href="../movie/2nd-GH/manage_movie.php">영화 관리</a></li>
                                <?php } ?>
                        </ul>
					</nav>
				</div>
			</div>
		</div>
	</header>

    <!--main-->
    <div id="container-main">
        <h1>예매내역</h1>

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

            // 예매내역 삭제 버튼 누르면 실행되는 부분
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id']) && isset($_GET['movieId']) && isset($_GET['date']) && isset($_GET['time']) && isset($_GET['seat'])) {
                $user_id = $_GET["user_id"];
                $movieId = $_GET["movieId"];
                $date = $_GET["date"];
                $time = $_GET["time"];
                $seat = explode(',', $_GET["seat"]);

                // schedule 테이블의 좌석 상태 '예약가능'으로 변경
                foreach ($seat as $each_seat) {
                    $update_sql = "UPDATE schedule SET $each_seat=0 WHERE movieId='$movieId' AND date='$date' AND time='$time'";
                    $update_result = $conn->query($update_sql); 
                }                
                
                // reservation 테이블에서 예매내역 삭제
                $del_sql = "DELETE FROM reservation WHERE user_id='".$_GET["user_id"]."' AND movieId='".$_GET["movieId"]."' AND date='".$_GET["date"]."' AND time='".$_GET["time"]."' AND seat='".$_GET["seat"]."'";
                $del_result = $conn->query($del_sql);

                if ($del_result === TRUE) {
                    echo "<p style='
                        font-size: 20px;
                        font-family: initial;
                        font-weight: bold;
                        color: blue;
                    '>예매내역이 삭제되었습니다.<p>";
                } else {
                    echo "오류: " . $del_sql . "<br>" . $conn->error;
                }
            }
            
            // DB Query
            $sql = "SELECT * FROM reservation WHERE user_id = '".$_SESSION['user_id']."' ORDER BY date , time";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $i = 1;
                echo "<table style='width: 500px;'><th>영화 제목</th><th>날짜</th><th>시간</th><th>좌석</th><th>메뉴</th>";
                while($row = $result->fetch_assoc()) {
                    // movieId에 해당하는 영화 제목 읽어오기
                    $movie_titie_query = $conn->query("SELECT title_ko FROM movie_info WHERE movieId = '".$row['movieId']."'");
                    $row2 = $movie_titie_query->fetch_assoc();
                    
                    echo "<tr><td>".$row2["title_ko"]."<td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["seat"]."</td><td><a href=\"confirm_res.php?user_id=".$_SESSION["user_id"]."&movieId=".$row["movieId"]."&date=".$row["date"]."&time=".$row["time"]."&seat=".$row["seat"]."\" onclick=\"return confirm('정말 삭제하시겠습니까?')\">[삭제]</a></td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='
                    font-size: 20px;
                    font-family: initial;
                    font-weight: bold;
                    color: red;
                '>예매 내역이 없습니다.</p>";
            }
            
            // DB Close
            $conn->close();
        ?>
        <div class="menu">
            <a href="../index.html">[메인화면으로]</a>
        </div>
    </div>

    <!--footer-->
    <footer id="footer">
        <div id="footer_sns">
            <div class="container">
                <div class="footer_sns">
                    <div class="tel">
                        <a href="#" onclick="return false">TEL <em>1234-5678</em></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer_infor">
            <div class="container">
                <div class="row">
                    <div class="footer_infor">
                        <ul>
                            <li><a href="#" onclick="return false">회사소개</a></li>
                            <li><a href="#" onclick="return false">이용약관</a></li>
                            <li><a href="#" onclick="return false">개인정보처리방침</a></li>
                            <li><a href="#" onclick="return false">고객센터</a></li>
                        </ul>
                        <address>
                            <p>주소 강원도 원주시 흥업면 남원로 150<br>대표자명 소공3팀 | 개인정보보호 책임자 소공3팀<br></p>
                            <p>Copyright 2023 by GWMU Software_Engineering Team3. All right reserved</p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--javascript-->
</body>
</html>