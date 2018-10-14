<?php 
    require_once('connect.php');
?>
<?php
if(isset($_POST['user_id']) && isset($_POST['user_password'])){
    $userId = $_POST['user_id'];
    $userPassword = $_POST['user_password'];
    $userNickname = $_POST['user_nickname'];

    $sql = "INSERT INTO tingkao_user (userNickname, userId, userPassword)  VALUES ('$userNickname', '$userId', '$userPassword')";
    if ($conn->query($sql) === TRUE) {
        echo '註冊成功';
        echo '<a href="login.php">回登入頁面</a>';
    } else {
        // echo 'Error: ' . $sql . '<br>' . $conn->error; >>>> 用來除錯
        echo '此帳號有人申請過囉！ <a href="login.php">回登入頁面</a>';
        //die('此帳號有人申請過囉！'); //die() 的後面程式碼都不執行！！
    };
};
?>