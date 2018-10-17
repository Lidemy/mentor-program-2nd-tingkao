<?php
// set cookie
if(!(empty($_POST['user_id']) && empty($_POST['user_password']))){
    setcookie("user_id",$_POST["user_id"], time()+3600*24);
    setcookie("user_password",$_POST["user_password"], time()+3600*24);
    $_COOKIE['user_id'] = $_POST["user_id"];
    $_COOKIE['user_password'] = $_POST['user_password'];
};
?>

<?php
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_password'])){
    $userId = $_COOKIE['user_id'];
    $userPassword = $_COOKIE['user_password'];   
    //這邊的 $POST['user_id'] 和 $POST['user_password'] 改為 $_COOKIE['user_id'] 和 $_COOKIE['user_password']
    //在每次留言完後，才不用再登入一次，因為按 submit 就會重新載入網頁一次，重新載入的 post 裡面是空的，所以用 $_COOKIE 或 $_COOKIE 來記錄

    // echo $userId;
    // echo $userPassword;
    $login_sql = "SELECT * FROM tingkao_user WHERE userId = '$userId'";
    $login_result = $conn->query($login_sql);
    if ($login_result->num_rows > 0) {
        while($row = $login_result->fetch_assoc()){
            if($row['userPassword'] === $userPassword){
                echo $userId.'，你好！';
            }else{
                echo '密碼錯誤';
                header('Location: login.php');
            };
        };
    }else{
        echo '查無此帳號';
        header('Location: login.php');
    };
}else{
    echo '請輸入帳號密碼';
    header('Location: login.php');
    // 這一層在 login 的地方用 js 判斷過了
};
?>

<?php
    $sql = "SELECT userNickname FROM tingkao_user WHERE userId = '$userId'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['userNickname']){
        $value = $row['userNickname'];
    }else{
        $value = $_COOKIE['user_id'];
    }
    //$value 為一個變數，為登入者的 nickname，把 $value 直接放入暱稱 input 標籤中的 value
    //如果註冊時沒有填入暱稱，則 $value 為帳號
?>