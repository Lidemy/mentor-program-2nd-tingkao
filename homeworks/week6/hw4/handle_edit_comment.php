<?php require_once('connect.php'); ?>
<?
//父留言編輯
if(!empty($_POST['message_edit'])){
    $id = $_POST['message_edit'];
    $stmt = $conn->prepare("SELECT * FROM `tingkao_main` WHERE `id`=? ");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $main_comment = $row['main_comment'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/index.css">
    <style>

    </style>
</head>
<body>
    <div class="wrap">
        <div class="main_comment">
            <p class="commenter">編輯留言內容：</p>
            <form action="handle_comment.php" method="post">
                <input type="hidden" name="edited_comment_id" value="<? echo $id;?>">
                <textarea class="comment_text" name="edited_comment" id="" cols="30" rows="6"><? echo $main_comment ;?></textarea>
                <input class="comment_btn" type="submit" value="送出">
            </form>
        </div>
    </div>
</body>
</html>

<?
}
//子留言編輯
if(!empty($_POST['sub_message_edit'])){
    $ind = $_POST['sub_message_edit'];
    $stmt = $conn->prepare("SELECT * FROM `tingkao_sub` WHERE `ind`=? ");
    $stmt->bind_param("s", $ind);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $sub_comment = $row['sub_comment'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/index.css">
    <style>

    </style>
</head>
<body>
    <div class="wrap">
        <div class="main_comment">
            <p class="commenter">編輯留言內容：</p>
            <form action="handle_comment.php" method="post">
                <input type="hidden" name="edited_sub_comment_id" value="<? echo $ind;?>">
                <textarea class="comment_text" name="edited_sub_comment" id="" cols="30" rows="6"><? echo $sub_comment ;?></textarea>
                <input class="comment_btn" type="submit" value="送出">
            </form>
        </div>
    </div>
</body>
</html>

<?
}
//刪除父留言
if(!empty($_POST['message_delete'])){
    echo $_POST['message_delete'];
    $id = $_POST['message_delete'];
    $stmt = $conn->prepare("UPDATE `tingkao_main` SET `deleted`=1 WHERE `id`=? ");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    header('Location: index.php');
}

//刪除子留言
if(!empty($_POST['sub_message_delete'])){
    $ind = $_POST['sub_message_delete'];
    $stmt = $conn->prepare("UPDATE `tingkao_sub` SET `deleted`=1 WHERE `ind`=? ");
    $stmt->bind_param("s", $ind);
    $stmt->execute();
    header('Location: index.php');
}


?>