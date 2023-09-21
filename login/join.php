<!doctype html>
<?php session_start(); ?>
<html>
<head>
    <!--<link rel="stylesheet" href="css.css">-->
    <link rel="stylesheet" href="../movie/set/reset.css">
    <link rel="stylesheet" href="../movie/set/style.css">
    <link rel="stylesheet" href="../movie/set/swiper.css">
    <meta charset="UTF-8">
    <title>회원가입 | GW시네마</title>
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
                <nav id="mNav">
                    <h2 class="ir_so">전체메뉴</h2>
                    <a href="#" class="ham"><span></span></a>
                </nav>
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
<section class= "login">
    <div class="center">
        <h3>회원가입</h3>
<form method="POST" action="join_ok.php" autocomplete="off">
    <p>&nbsp&nbsp이름&nbsp&nbsp: <input type="text" name="join_name" required></p><br>
    <p>아이디&nbsp: <input type="text" name="join_id" id="uid" required></p>
    <input type="hidden" name="decide_id" id="decide_id">
    <p>
        <span id="decide" style='color:red;'>ID 중복 여부를 확인해주세요.</span>
        <input type="button" id="check_button" value="ID 중복 검사" onclick="checkid();">
    </p><br>
    <p>
        비밀번호: <input type="password" name="join_pw" required>
        비밀번호 확인: <input type="password" name="join_pw2" required>
    </p>
    <p><input type="submit" id="join_button" value="가입하기" disabled=true></p>
</form>
<small><a href="movie_login.php">이미 회원이신가요?</a></small>
        <?php } else {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
            echo "<p>$user_name($user_id)님은 이미 로그인되어 있습니다.";
            echo "<p><button onclick=\"window.location.href='../index.php'\">메인으로</button> <button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        } ?>
    </div>
</section>

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
<script>
    function checkid(){
        var userid = document.getElementById("uid").value;
        if(userid)  //userid로 받음
        {
            var xPos = (document.body.offsetWidth/2) - (400/2); // 가운데 정렬
            xPos += window.screenLeft; // 듀얼 모니터일 때
            var yPos = (document.body.offsetHeight/2) - (200);

            url = "check.php?userid="+userid;
            window.open(url,"chkid","width=400,height=200, left="+xPos+", top="+yPos);
        } else {
            alert("아이디를 입력하세요.");
        }
    }
    function decide(){
        document.getElementById("decide").innerHTML = "<span style='color:red;'>ID 중복 여부를 확인해주세요.</span>"
        document.getElementById("decide_id").value = document.getElementById("uid").value
        document.getElementById("uid").disabled = true
        document.getElementById("join_button").disabled = false
        document.getElementById("check_button").value = "다른 ID로 변경"
        document.getElementById("check_button").setAttribute("onclick", "change()")
    }
    function change(){
        document.getElementById("decide").innerHTML = "<span style='color:red;'>ID 중복 여부를 확인해주세요.</span>"
        document.getElementById("uid").disabled = false
        document.getElementById("uid").value = ""
        document.getElementById("join_button").disabled = true
        document.getElementById("check_button").value = "ID 중복 검사"
        document.getElementById("check_button").setAttribute("onclick", "checkid()")
    }
</script>
</html>