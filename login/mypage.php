<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지 | GW시네마</title>
	<!--<link rel="stylesheet" href="../set/mvinfostyle.css">-->
  <link rel="stylesheet" href="../sm-reservation/css/header-footer.css">
  <link rel="shortcut icon" href="https://nlms.gwnu.ac.kr/theme/image.php/coursemosv2/theme/1677574372/favicon">
  <style>
    /* 기존 스타일 코드 */
    * {
        margin: 0;
        padding: 0;
    }
    body {
      font-family: Arial, sans-serif;
    }
    h1 {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 10px;
    }
    input[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    /* 중앙 정렬 스타일 */
    .container-mypage {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    form {
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
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
                      <li><a href="./logout.php">로그아웃</a></li>
                      <?php }else { ?>
                      <li><a href="./movie_login.php">로그인</a></li>
                      <?php } ?>
                      <li><a href="./mypage.php">마이페이지</a></li>
                      <?php if (isset($_SESSION['user_id'])) { ?>
                      <li><a href="../sm-reservation/confirm-res.php">예매내역 확인</a></li>
                      <?php }else { ?>
                          <li><a href="./movie_login.php">예매내역 확인</a></li>
                          <?php }
                          ?>
                      <?php if ($_SESSION['user_id'] == 'admin') { ?>
                      <li><a href="../movie/2nd-GH/manage_movie.php">영화 관리</a></li>
                      <?php } ?>
              </ul>
					</nav>
				</div>
			</div>
		</div>
	</header>

  <div class="container-mypage">
    <h1>마이페이지</h1>
  
    <h2>회원정보 수정</h2>
    <?php
    // MySQL 데이터베이스 연결 정보
    $servername = "localhost";
    $username = "semin1127";
    $password = "tpals1528!";
    $dbname = "semin1127";

    // 폼으로부터 전송된 데이터 가져오기
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save-button1'])) {
        $name = $_POST['name'];

        // MySQL 데이터베이스에 연결
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("MySQL 연결 실패: " . $conn->connect_error);
        }

        // 회원 정보 수정 쿼리 실행
        $sql = "UPDATE member SET name='$name' WHERE login_id='".$_SESSION['user_id']."'";
        if ($conn->query($sql) === TRUE) {
            echo "회원 정보가 수정되었습니다.";
        } else {
            echo "오류: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <form method="POST">
      <label for="name">이름:</label>
      <input type="text" id="name" name="name" required>    
      <input type="submit" value="저장" name="save-button1">
    </form>
  


    <h2>비밀번호 변경</h2>
    <?php
    // MySQL 데이터베이스에 연결
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("MySQL 연결 실패: " . $conn->connect_error);
    }
    // 비밀번호 변경 쿼리 실행
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save-button2'])) {
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        // 비밀번호 확인
        $sql = "SELECT * FROM member WHERE login_id='".$_SESSION['user_id']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($currentPassword != $row["login_pw"]) {
            echo "현재 비밀번호가 일치하지 않습니다.";
        } else {
            if ($newPassword === $confirmPassword) {
                $sql = "UPDATE member SET login_pw='$newPassword' WHERE login_id='".$_SESSION['user_id']."'";
                if ($conn->query($sql) === TRUE) {
                    echo "비밀번호가 변경되었습니다.";
                } else {
                    echo "오류: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "새 비밀번호와 확인 비밀번호가 일치하지 않습니다.";
            }
        }        
    }

    $conn->close();
    ?>
    <form method="POST">
      <label for="current-password">현재 비밀번호:</label>
      <input type="password" id="current-password" name="current-password" required>
    
      <label for="new-password">새 비밀번호:</label>
      <input type="password" id="new-password" name="new-password" required>
    
      <label for="confirm-password">비밀번호 확인:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>
    
      <input type="submit" value="변경" name="save-button2">
    </form>
  


    <h2>회원탈퇴</h2>
    <?php
    // MySQL 데이터베이스에 연결
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("MySQL 연결 실패: " . $conn->connect_error);
    }
    // 회원 탈퇴 쿼리 실행
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save-button3'])) {
        if (isset($_POST['delete-confirm'])) {
            $sql = "DELETE FROM member WHERE login_id='".$_SESSION['user_id']."'";
            if ($conn->query($sql) === TRUE) {
                session_destroy();
                echo '<script>alert("회원탈퇴가 완료되었습니다."); window.location.href = "../index.html";</script>';
                exit;
            } else {
                echo "오류: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "회원탈퇴를 진행하려면 확인란에 체크하세요.";
        }
    }
    $conn->close();
    ?>
    <form method="POST">
      <label for="delete-confirm">회원탈퇴를 진행하시려면 아래의 확인란에 체크하세요:</label>
      <input type="checkbox" id="delete-confirm" name="delete-confirm" required>
      <input type="submit" value="탈퇴" name="save-button3">
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
                            <p>주소 강원도 원주시 흥업면 남원로 150<br>대표자명 소공3팀 | 개인정보보호 책임자 소공3팀<br></p>
                            <p>Copyright 2023 by GWMU Software_Engineering Team3. All right reserved</p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>