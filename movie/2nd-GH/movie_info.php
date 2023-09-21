<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>영화 정보 | GW시네마</title>
	<link rel="stylesheet" href="../set/mvinfostyle.css">
    <link rel="stylesheet" href="../../sm-reservation/css/header-footer.css">
    <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
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

        // Get the movie ID from the URL or any other source
        $movieId = $_GET['movieId']; // Assuming the ID is passed as a query parameter in the URL

        // DB Query
        $sql = "SELECT * FROM movie_info WHERE movieId = $movieId";
        $result = $conn->query($sql);

        // Print result of Query
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class=\"movie-container\">
                    <div class=\"poster\">
                        <img src=\"".$row["poster_img"]."\" alt=\"영화 포스터\">
                    </div>
                    <div class=\"movie-info\">
                        <div class=\"title-container\">
                            <h1 class=\"movie-title\">".$row["title_ko"]."</h1>
                            <h2 class=\"movie-title-en\">".$row["title_en"]."</h2>
                            <div class=\"title-separator\"></div>
                        </div>
                        <div>상영시간: ".$row["runtime"]."</div>
                        <div>장르: ".$row["genre"]."</div>
                        <div>감독: ".$row["director"]."</div>
                        <div>출연진: ".$row["actors"]."</div>
                        <div>연령제한: ".$row["age"]."세 관람가</div>";
                        if (isset($_SESSION['user_id'])) { echo "<button class=\"booking-btn\" onclick = \"location.href = '../../sm-reservation/reservation.html'\">예매하기</button><br><br>";
                        } else { echo "<button class=\"booking-btn\" onclick = \"location.href = '../../login/movie_login.php'\">예매하기</button><br><br>"; }
                        echo "<div>
                            <h3>영화 설명</h3><br>
                            <p>".nl2br($row["description"])."</p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "0 results";
        }

        // DB 연결 종료
        $conn->close();
    ?>
    
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
</html>
