<?php require_once('connect.php'); ?>

<!-- 登入成功的使用者發給 session_id -->
<?
if(isset($_POST['user_id']) && isset($_POST['user_password'])){
$user_id = $_POST['user_id'];
$user_password = $_POST['user_password'];

$stmt = $conn->prepare("SELECT * FROM `tingkao_user` WHERE `user_id`=?");
$stmt->bind_param("s",htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'));
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows>0){
    $hash_password = password_hash($user_password, PASSWORD_BCRYPT);
    if (password_verify($user_password , $hash_password)){
        //如果前一天登入的使用者 session_id 過期了(非正常 logout)，如果在隔天再次登入，資料庫會有兩筆同帳號的 session_id
        //如果 session_id 資料庫已有該帳號，則更新 session_id ，如果沒有該帳號則新增 session_id
        $check_session_stmt = $conn->prepare("SELECT * FROM `tingkao_session_id` WHERE `user_id`=?");
        $check_session_stmt->bind_param("s",htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'));
        $check_session_stmt->execute();
        $check_session_result = $check_session_stmt->get_result();
        if($check_session_result->num_rows>0){
            $session_stmt = $conn->prepare("UPDATE `tingkao_session_id` SET `session_id`=? WHERE `user_id`=?");
            $session_id = uniqid();
            $session_stmt->bind_param("ss", $session_id, htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'));
        }else{
            $session_stmt = $conn->prepare("INSERT INTO `tingkao_session_id` (`user_id`, `session_id`) VALUES (?, ?)");
            $session_id = uniqid();
            $session_stmt->bind_param("ss",htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'), $session_id);
        }
        $session_stmt->execute();

        setcookie('session_id', $session_id, time()+3600*24);
        $_COOKIE['session_id'] = $session_id;
        // $user_nickname = $row['user_nickname'];
        // echo $user_nickname;

        header('Location: index.php');
    }
}else{
    header('Location: login.html');
}

}
// $conn->close();
?>