<?php require_once('connect.php'); ?>
<?
if(isset($_COOKIE['session_id'])){
$session_id = htmlspecialchars($_COOKIE['session_id'], ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare("SELECT `user_id` FROM `tingkao_session_id` WHERE `session_id`=?");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows>0){
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    $sql = "SELECT * FROM `tingkao_user` WHERE `user_id`='$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user_nickname = $row['user_nickname'];
    
}
}

?>

<?

if(!empty($_POST['comment_text'])){
    echo $user_nickname;
    $main_comment = htmlspecialchars($_POST['comment_text'], ENT_QUOTES, 'UTF-8');
    $stmt = $conn->prepare("INSERT INTO `tingkao_main` (`user_id`, `main_commenter`, `main_comment`) VALUES (?, ?, ?);");
    $stmt->bind_param("sss", $user_id, $user_nickname, $main_comment);
    if($stmt->execute()){
        echo '父留言成功';
        header('Location: index.php');
    }else{
        echo '留言失敗';
        // header('Location: login.html');
    }
}

if(!empty($_POST['sub_comment_text'])){
    $parent_id = htmlspecialchars($_POST['parent_id'], ENT_QUOTES, 'UTF-8');
    $sub_comment = htmlspecialchars($_POST['sub_comment_text'], ENT_QUOTES, 'UTF-8');
    $stmt = $conn->prepare("INSERT INTO `tingkao_sub` (`parent_id`, `user_id`, `sub_commenter`, `sub_comment`) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("ssss", $parent_id, $user_id, $user_nickname, $sub_comment);
if($stmt->execute()){
    echo '子留言成功';
    header('Location: index.php');
}else{
    echo '留言失敗';
    // header('Location: login.html');
}
}


if(!empty($_POST['edited_comment'])){
    $edited_comment_id = $_POST['edited_comment_id'];
    $edited_comment = htmlspecialchars($_POST['edited_comment'], ENT_QUOTES, 'UTF-8');
    $stmt = $conn->prepare("UPDATE `tingkao_main` SET `main_comment`=? WHERE `id`=?");
    $stmt->bind_param("si", $edited_comment, $edited_comment_id);
    if($stmt->execute()){
        echo '編輯留言成功';
        header('Location: index.php');
}
}

if(!empty($_POST['edited_sub_comment'])){
    $edited_sub_comment_id = $_POST['edited_sub_comment_id'];
    $edited_sub_comment = htmlspecialchars($_POST['edited_sub_comment'], ENT_QUOTES, 'UTF-8');
    $stmt = $conn->prepare("UPDATE `tingkao_sub` SET `sub_comment`=? WHERE `ind`=?");
    $stmt->bind_param("si", $edited_sub_comment, $edited_sub_comment_id);
    if($stmt->execute()){
        echo '編輯子留言成功';
        header('Location: index.php');
}
}

?>