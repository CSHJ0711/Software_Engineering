<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
    <link rel="stylesheet" href="../set/manage_movie.css">
    <link rel="stylesheet" href="../../sm-reservation/css/header-footer.css">
    <title>영화 관리 | GW시네마</title>
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
        <h1>영화 목록</h1>
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

        // 새 영화 추가하면 실행되는 부분
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "INSERT INTO movie_info VALUES ('".$_POST["movieId"]."', '".$_POST["title_ko"]."', '".$_POST["title_en"]."','".$_POST["poster_img"]."', '".$_POST["director"]."', '".$_POST["actors"]."', '".$_POST["genre"]."', '".$_POST["age_limit"]."', '".$_POST["description"]."', '".$_POST["runtime"]."')";
            $result = $conn->query($sql);
        }

        // DB Query
        $sql = "SELECT movieId, title_ko FROM movie_info";
        $result = $conn->query($sql);

        // Query 결과를 '영화 목록'에 추가
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<p><a href=\"movie_info.php?movieId=".$row["movieId"]."\">".$row["title_ko"]."</a>";
                echo " <a href=\"edit_movie.php?movieId=".$row["movieId"]."\">[수정]</a>";
                echo " <a href=\"delete_movie.php?movieId=".$row["movieId"]."\" onclick=\"return confirm('정말 삭제하시겠습니까?')\">[삭제]</a>";
                echo " <a href=\"showtimes.php?movieId=".$row["movieId"]."\">[상영 정보 보기]</a></p>";
            }
        } else {
            echo "0 results";
        }

        // DB 연결 종료
        $conn->close();
        ?>

        <h1>새 영화 추가</h1>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onsubmit="return validateForm()">
            <label for="movieId">영화 ID(001~999) :</label><br>
            <input type="text" id="movieId" name="movieId"><br>
            <label for="title_ko">영화 제목 (한국어):</label><br>
            <input type="text" id="title_ko" name="title_ko"><br>
            <label for="title_en">영화 제목 (영어):</label><br>
            <input type="text" id="title_en" name="title_en"><br>
            <label for="poster_img">포스터 이미지(파일 위치):</label><br>
            <input type="text" id="poster_img" name="poster_img"><br>
            <label for="director">감독:</label><br>
            <input type="text" id="director" name="director"><br>
            <label for="runtime">상영시간:</label><br>
            <input type="text" id="runtime" name="runtime"><br>
            <label for="actors">출연진:</label><br>
            <input type="text" id="actors" name="actors"><br>
            <label for="genre">장르:</label><br>
            <input type="text" id="genre" name="genre"><br>
            <label for="age_limit">연령 제한:</label><br>
            <input type="text" id="age_limit" name="age_limit"><br>
            <label for="description">영화 설명:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <input type="submit" value="추가하기">
        </form>
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
    
    <!--script-->
    <script>
    function validateForm() {
        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value === '') {
                alert('모든 필드를 입력해야 합니다.');
                return false;
            }
        }
        var textarea = document.getElementById('description');
        if (textarea.value === '') {
            alert('모든 필드를 입력해야 합니다.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
