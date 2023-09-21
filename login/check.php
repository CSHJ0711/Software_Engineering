<?php
$conn = mysqli_connect('localhost', 'semin1127', 'tpals1528!', 'semin1127');
$uid = $_GET["userid"];  // GET으로 넘긴 userid

if (strlen($uid) > 10) {
    echo "<span style='color:red;'>오류: 아이디는 10자 이하여야 합니다.</span>";?>
    <p><input type="button" value="다른 ID 사용" onclick="opener.parent.change(); window.close()"></p>
    <?php
} else {
    $sql = "SELECT * FROM member where login_id='$uid'";
    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    if (!$result) {
        echo "<span style='color:blue;'>$uid</span>는 사용 가능한 아이디입니다.";
        ?>
        <p><input type="button" value="이 ID 사용" onclick="opener.parent.decide(); window.close();"></p>
        <?php
    } else {
        echo "<span style='color:red;'>$uid</span>는 중복된 아이디입니다.";
        ?>
        <p><input type="button" value="다른 ID 사용" onclick="opener.parent.change(); window.close()"></p>
        <?php
    }
}
?>