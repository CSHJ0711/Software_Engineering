<!doctype html>
<?php session_start(); ?>
<html>
<head>
	<!--<link rel="stylesheet" href="css.css">-->
	<link rel="stylesheet" href="../movie/set/reset.css">
	<link rel="stylesheet" href="../movie/set/style.css">
	<link rel="stylesheet" href="../movie/set/swiper.css">
	<meta charset="UTF-8">
	<title>로그인 | GW시네마</title>
    <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
</head>
<body>
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
                            <li><a href="movie_login.php">로그인</a></li>
                            <li><a href="movie_login.php">마이페이지</a></li>
                            <li><a href="movie_login.php">예매내역 확인</a></li>
                            <?php if ($_SESSION['user_id'] == 'admin') { ?>
                            <li><a href="../movie/2nd-GH/manage_movie.php">영화 관리</a></li>
                            <?php } ?>
                        </ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
    <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
    <section class = "login">
        <div class="center">
        <h3>로그인</h3>
        <form action="login_ok.php" method="POST" autocomplete="off">
            <label for="id">아이디:&nbsp&nbsp&nbsp</label>
            <input type="text" name="user_id" required>
            <br><br>
            <label for="pw">비밀번호:</label>
            <input type="password" name="user_pw" required>
            <br><br>
            <input type="submit" value="로그인">
        </form>
        <small><a href="join.php">처음 오셨나요?</a></small>
        <?php } else {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
            echo "<p>$user_name($user_id)님은 이미 로그인되어 있습니다.";
            echo "<p><button onclick=\"window.location.href='../index.html'\">메인으로</button> <button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        } ?>
        </div>
    </section>
	    <!-- //help -->

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
    <!-- //footer -->
</body>
</html>