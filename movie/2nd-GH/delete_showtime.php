<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
    <link rel="stylesheet" href="../../sm-reservation/css/header-footer.css">
    <link rel="stylesheet" href="../set/manage_movie.css">
    <link rel="stylesheet" href="../../sm-reservation/css/showtime.css">
    <title>상영 정보 삭제 | GW시네마</title>
</head>
<body>
    <!--header-->
    <header>
		<div class="container">
			<div class="row">
				<div class="header clearfix">
					<h1>
                        <a href="../../index.html">
                            <em><img src="../src/gwnu.png" alt="GWNU"></em>
                            <strong><img src="../src/gwnu_long.png" alt="GWNU_Long"></strong>
                        </a>
					</h1>
					<nav class="nav">
						<ul class="clearfix">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                                <li><a href="../../login/logout.php">로그아웃</a></li>
                                <?php }else { ?>
                                <li><a href="../../login/movie_login.php">로그인</a></li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <li><a href="../../login/mypage.php">마이페이지</a></li>
                                <?php }else { ?>
                                    <li><a href="../../login/movie_login.php">마이페이지</a></li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <li><a href="../../sm-reservation/confirm_res.php">예매내역 확인</a></li>
                                <?php }else { ?>
                                    <li><a href="../../login/movie_login.php">예매내역 확인</a></li>
                                    <?php }
                                    ?>
                                <?php if ($_SESSION['user_id'] == 'admin') { ?>
                                <li><a href="./manage_movie.php">영화 관리</a></li>
                                <?php } ?>
                        </ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
    
    <div id="container-main">
        <h1>상영 정보 삭제</h1>

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

        $movie_id = $_GET['id'];

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['date']) && isset($_GET['time'])) {
            $date = $_GET['date'];
            $time = $_GET['time'];
            $conn->query("DELETE FROM reservation WHERE movieId = '$movie_id'");
            $sql = "DELETE FROM schedule WHERE movieId = '$movie_id' AND date = '$date' AND time = '$time'";
            $result = $conn->query($sql);

            if ($result === TRUE) {
                echo "<p style='
                    font-size: 20px;
                    font-family: initial;
                    font-weight: bold;
                    color: blue;
                '>상영 정보가 삭제되었습니다.<p>";
            } else {
                echo "오류: " . $sql . "<br>" . $conn->error;
            }
        }

        // DB Query
        $sql = "SELECT date, time FROM schedule WHERE movieId = '$movie_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $i = 1;
            echo "<table><th>번호</th><th>날짜</th><th>시간</th><th>메뉴</th>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$i++."<td>".$row["date"]."</td><td>".$row["time"]."</td><td><a href=\"delete_showtime.php?id=".$movie_id."&date=".$row["date"]."&time=".$row["time"]."\" onclick=\"return confirm('정말 삭제하시겠습니까?')\">[삭제]</a></td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='
                font-size: 20px;
                font-family: initial;
                font-weight: bold;
                color: red;
            '>상영 정보가 없습니다.</p>";
        }

        // DB Close
        $conn->close();
        ?>

        <div class="menu">
            <a href="./showtimes.php?movieId=<?php echo $movie_id ?>" style="
                background-color: #007BFF;
                color: white;
                border: none;
                text-align: center;
                padding: 10px 20px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 5px;
            ">돌아가기</a>
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
                            <p>주소 강원도 원주시 흥업면 남원로 150<br><span class="bar2">대표자명 소공3팀</span> | 개인정보보호 책임자 소공3팀<br><span class="bar2"></p>
                            <p>Copyright 2023 by GWMU Software_Engineering Team3. All right reserved</p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>