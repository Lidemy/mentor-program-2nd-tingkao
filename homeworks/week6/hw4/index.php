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
        <header class="header">CHAT BOARD</header>
        <div class="main_comment">
            <h1 class="title">我要留言</h1>
            <p class="commenter"><? echo $user_nickname; ?></p>
            <form action="handle_comment.php" method="post">
                <textarea class="comment_text" name="comment_text" id="" cols="30" rows="6" placeholder="comment..."></textarea>
                <input class="comment_btn" type="submit" value="留言">
            </form>
        </div>
<?
$sql = "SELECT COUNT(*) as sum FROM `tingkao_main` WHERE deleted=0";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_comment = $row['sum'];
$comment_num = $total_comment + 1;
if(is_int($row['sum']/10)){
    $pages = $row['sum']/10;
}else{
    $pages = ceil($row['sum']/10);
};
//取出資料數量/10，來判斷總共有幾頁

$page = 1;//現在在第幾頁，一開始進來的時候在第一頁．後面隨著點選頁數，$page 會改變數值．
if(isset($_GET['page'])){
    $page = $_GET['page'];
};
if($page === 1){
    $sql = "SELECT * FROM tingkao_main WHERE deleted=0 ORDER BY created_at DESC LIMIT 10"; 
    // DESC 顛倒順序，讓新留言在最上面，LIMIT 10，只取十筆資料在一頁
}else{
    $number = 10*($page - 1);
    $sql = "SELECT * FROM tingkao_main WHERE deleted=0 ORDER BY created_at DESC LIMIT $number, 10"; 
    $comment_num = $total_comment + 1 - $number;
    // DESC 顛倒順序，讓新留言在最上面，LIMIT 參數一, 參數二，參數一：略過前面幾個，參數二：取幾個。
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $comment_num -= 1;
        $id = $row['id'];
        $main_commenter_user_id = $row['user_id'];
        $main_commenter = $row['main_commenter'];
        $main_comment = $row['main_comment'];
        $created_at = $row['created_at'];

        $sum_sql = "SELECT COUNT(*) as sum FROM `tingkao_sub` WHERE parent_id = '$id' AND `deleted`=0"; // 撈出每個主留言 id 下的子留言數量
        $sum_result = $conn->query($sum_sql);
        $sum_row = $sum_result->fetch_assoc();
        $sum = $sum_row['sum'];  //$sum 為每個主留言下的子留言數量
?>
        <section class="content">
            <div class="main_message">
                <div class="message_num"><? echo '#0'.$comment_num ; ?></div>
                <div class="message_pic"></div>
            <?
            if($main_commenter_user_id === $user_id){ //登入者的留言才會出現 message_edit_option
            ?>
                <div class="message_edit">
                    <p class="message_edit_btn">...</p>
                    <form class="message_edit_option display-none" action="handle_edit_comment.php" method="post">
                        <input type="hidden" name="message_edit" value="<? echo $id ;?>">
                        <input class="message_edit_comment" type="submit" value="編輯留言">
                        <hr>
                        <input type="hidden" name="message_delete" value="<? echo $id ;?>">
                        <input class="message_delete_comment" type="submit" value="刪除留言">
                    </form>
                </div>
            <?
            } //登入者的留言才會出現 message_edit_option
            ?>
                <div class="message_info">
                    <div class="message_commenter"><? echo $main_commenter; ?></div>
                    <div class="message_created_at"><? echo $created_at; ?></div>
                </div>
                <div class="message_text"><? echo $main_comment; ?></div>
                <div class="message_sum"><? echo $sum; ?> 則回應</div>
                <hr>
                <div class="message_btn">我要留言 ►</div>
            </div>
            <div class="sub_content display-none">
<?
$sub_sql = "SELECT * FROM `tingkao_sub` WHERE `deleted`=0";
$sub_result = $conn->query($sub_sql);
if ($sub_result->num_rows > 0) {
    while($sub_row = $sub_result->fetch_assoc()) {
        $ind = $sub_row['ind'];
        $parent_id = $sub_row['parent_id'];
        $sub_commenter_user_id = $sub_row['user_id'];
        $sub_commenter = $sub_row['sub_commenter'];
        $sub_comment = $sub_row['sub_comment'];
        $sub_created_at = $sub_row['created_at'];
        if($parent_id === $id && $main_commenter_user_id === $user_id){ //父留言是登入者的留言
?>
                <div class="sub_message own_color"> <!-- 自己的留言加了 own_color -->
                    <div class="message_pic"></div>

                    <div class="message_edit"> <!-- 自己的子留言可以編輯與刪除 -->
                        <p class="message_edit_btn">...</p>
                        <form class="message_edit_option display-none" action="handle_edit_comment.php" method="post">
                            <input type="hidden" name="sub_message_edit" value="<? echo $ind ;?>">
                            <input class="message_edit_comment" type="submit" value="編輯子留言">
                            <hr>
                            <input type="hidden" name="sub_message_delete" value="<? echo $ind ;?>">
                            <input class="message_delete_comment" type="submit" value="刪除子留言">
                        </form>
                    </div> <!-- 自己的子留言可以編輯與刪除 -->

                    <div class="message_info">
                        <div class="message_commenter"><? echo $sub_commenter; ?></div>
                        <div class="message_created_at"><? echo $sub_created_at; ?></div>
                    </div>
                    <div class="message_text"><? echo $sub_comment; ?></div>
                </div>
<?  
        }else if($parent_id === $id){ //父留言不是登入者的留言
?>
                <div class="sub_message">
                    <div class="message_pic"></div>
                <?
                if($sub_commenter_user_id === $user_id){ //如果子留言是自己的留言，可以編輯與刪除
                ?>
                    <div class="message_edit"> 
                        <p class="message_edit_btn">...</p>
                        <form class="message_edit_option display-none" action="handle_edit_comment.php" method="post">
                            <input type="hidden" name="sub_message_edit" value="<? echo $ind ;?>">
                            <input class="message_edit_comment" type="submit" value="編輯子留言">
                            <hr>
                            <input type="hidden" name="sub_message_delete" value="<? echo $ind ;?>">
                            <input class="message_delete_comment" type="submit" value="刪除子留言">
                        </form>
                    </div>
                <?
                } //如果子留言是自己的留言，可以編輯與刪除
                ?>
                    <div class="message_info">
                        <div class="message_commenter"><? echo $sub_commenter; ?></div>
                        <div class="message_created_at"><? echo $sub_created_at; ?></div>
                    </div>
                    <div class="message_text"><? echo $sub_comment; ?></div>
                </div>
<?
        }
    };
}
?>
                    <div class="sub_comment">
                        <p class="commenter"><? echo $user_nickname; ?></p>
                        <form action="handle_comment.php" method="post">
                            <textarea class="comment_text" name="sub_comment_text" id="" cols="30" rows="4" placeholder="comment..."></textarea>
                            <input name="parent_id" type="hidden" value=<? echo $id; ?>>
                            <input class="comment_btn sub_comment_btn" type="submit" value="留言">
                        </form>
                    </div>
            </div>
        </section>
<?
    
    }
}
?>
    </div>
    <div class="sidebar">
        <a class="login" href="login.php">login</a>
        <a class="signup" href="signup.html">signup</a>
        <a class="logout display-none" href="logout.php">logout</a>
    </div>
    <footer class="pages">
        <form class="page-form" action="" method="get">
            <!-- <input class="page-btn" type="submit" name="page" value="1">
            <input class="page-btn" type="submit" name="page" value="2">
            <input class="page-btn" type="submit" name="page" value="3"> -->
        </form>
    </footer>
</body>
<?
$isLogin = 0;
// 如果擁有 session_id 表示有登入，就可以留言
if(isset($_COOKIE['session_id'])){
    $stmt = $conn->prepare("SELECT `session_id` FROM `tingkao_session_id` WHERE `session_id`=?");
    $stmt->bind_param("s", $_COOKIE['session_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        $isLogin = true;
    }
}
?>
<script>
    let isLogin = <? echo $isLogin; ?>;
    if(isLogin){
        document.querySelector('.login').classList.add('display-none')
        document.querySelector('.signup').classList.add('display-none')
        document.querySelector('.logout').classList.remove('display-none')
    }
    document.querySelectorAll('.message_btn').forEach(function(element){
        element.addEventListener('click', function(e){
            let sub_content = e.target.parentNode.parentNode.querySelector('.sub_content')
            sub_content.classList.toggle('display-none')
            if(e.target.innerText === '我要留言 ►'){
                e.target.innerText = '關閉留言 ▼'
            }else{
                e.target.innerText = '我要留言 ►'
            }
        })
    })
    document.querySelectorAll('.comment_text').forEach(function(element){
        element.addEventListener('click', function(e){
            if(!isLogin){
                e.preventDefault
                alert('請先登入會員！')
            }else{
                // alert('歡迎留言')
            }
        })
    })
    let pages = <?php echo $pages ;?>; //有幾頁 
    let fragment = document.createDocumentFragment();
    function createInput(){
        let newInput = null
        for(i=1; i<=pages; i++){
            newInput = document.createElement('input');
            newInput.className = "page-btn";
            newInput.setAttribute('value', i );
            newInput.setAttribute('name', 'page');
            newInput.setAttribute('type', 'submit');
            fragment.appendChild(newInput);
            document.querySelector('.page-form').appendChild(fragment); 
        }
    }
    createInput()

    document.querySelectorAll('.message_edit').forEach(function(element){
        element.addEventListener('click', function(e){
            console.log(e.target)
            e.target.parentNode.querySelector('.message_edit_option').classList.toggle('display-none')
        })
    })
    document.querySelectorAll('.message_delete_comment').forEach(function(element){
        element.addEventListener('click', function(e){
            alert('刪除留言')
            if(e.target.parentNode.querySelector('input[name="message_edit"]')){
                e.target.parentNode.querySelector('input[name="message_edit"]').setAttribute("value", "");
            }else{
                e.target.parentNode.querySelector('input[name="sub_message_edit"]').setAttribute("value", "");
            }
            
        })
    })
    document.querySelectorAll('.message_edit_comment').forEach(function(element){
        element.addEventListener('click', function(e){
            alert('編輯留言')
            if(e.target.parentNode.querySelector('input[name="message_delete"]')){
                e.target.parentNode.querySelector('input[name="message_delete"]').setAttribute("value", "");
            }else{
                e.target.parentNode.querySelector('input[name="sub_message_delete"]').setAttribute("value", "");
            }
            
        })
    })
</script>
</html>