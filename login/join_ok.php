<?php
if (!isset($_POST['join_name']) || !isset($_POST['decide_id']) || !isset($_POST['join_pw'])) {
    header("Content-type: text/html; charset=UTF-8");
    echo "<script>alert('기입하지 않은 정보가 있거나 잘못된 접근입니다.')";
    echo "window.location.replace('join.php');</script>";
    exit;
}
$join_name = $_POST['join_name'];
$join_id = $_POST['decide_id'];
$join_pw = $_POST['join_pw'];
$join_pw2 = $_POST['join_pw2'];
$conn = mysqli_connect('localhost', 'semin1127', 'tpals1528!', 'semin1127');

if(!$check = false){ //사용가능ID
    if($join_pw != $join_pw2){ //비밀번호 불일치
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    } else { //비밀번호 일치
        //신규 회원정보 삽입 + ID 재정렬
        $multi = "
        INSERT INTO member(name, login_id, login_pw, created) VALUES ('{$join_name}', '{$join_id}', '{$join_pw}', now());
        SET @COUNT = 0;
        UPDATE member SET id = @COUNT:=@COUNT+1;
        ";
        $res = mysqli_multi_query($conn,$multi);
        if($res){
            echo "<script>alert('회원가입이 완료되었습니다.');";
            echo "window.location.replace('movie_login.php');</script>";
            exit;
        }
        else { //쿼리문의 결과가 없으면 로그인 fail을 출력한다.
            echo "<script>alert('저장에 문제가 생겼습니다. 관리자에게 문의해주세요.');";
            echo mysqli_error($conn);
        }
    }
}
else{
    echo "<script>alert('저장에 문제가 생겼습니다. 관리자에게 문의해주세요.');";
    echo mysqli_error($conn);
}
?>
<meta http-equiv="refresh" content="0;url=main.php">