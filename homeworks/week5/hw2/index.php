<!-- http://localhost:8080/ttest/index.php -->
<?php
// set cookie
if(!(empty($_POST['user_id']) && empty($_POST['user_password']))){
    setcookie("user_id",$_POST["user_id"], time()+3600*24);
    setcookie("user_password",$_POST["user_password"], time()+3600*24);
    $_COOKIE['user_id'] = $_POST["user_id"];
    $_COOKIE['user_password'] = $_POST['user_password'];
}
?>

<?php
require_once('connect.php');
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
if(isset($_GET['comment__name']) && isset($_GET['comment__text'])){
    //這裡的 isset($_GET['comment__name'] 原本改為 $_GET['comment__name']!== '' 來讓空白訊息無法送出
    //但是這邊如果改成上述，為什麼會出現按了子留言的 submit，主留言也跟著送出的情況？？

    $deleteID = "ALTER TABLE `tingkao_main` DROP column `id` ";
    $conn->query($deleteID);
    $addID = "ALTER TABLE `tingkao_main` ADD column `id` INT(10) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)";
    $conn->query($addID); 
    // 讓 id 排序連續，每次都刪除欄位再新增欄位

    $sql = "INSERT INTO tingkao_main ( mainCommenter, mainComment)  VALUES ( '$_GET[comment__name]', '$_GET[comment__text]')";
    // $conn->query($sql); =>如果 if 裡面已經有 $conn->query($sql) 這邊就不用再執行一次，此為“執行查詢操作”
    if ($conn->query($sql) === TRUE) {
        echo "留言成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
};// 主留言新增資料
?>

<?php
if(isset($_GET['sub-message__form-name']) && isset($_GET['sub-message__form-text'])){
    $commentId = $_GET['comment_id'];
    $subMessageFormName = $_GET['sub-message__form-name'];
    $subMessageFormText = $_GET['sub-message__form-text'];
    $sql = "INSERT INTO tingkao_sub ( id, subCommenter, subComment)  VALUES ( '$commentId', '$subMessageFormName', '$subMessageFormText')";
    if ($conn->query($sql) === TRUE) {
        echo "回覆留言成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };
}// 次留言新增資料
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            font-family: 微軟正黑體;
            vertical-align: middle;
        }
        .wrap{
            max-width: 700px;
            margin: auto;
            margin-top: 100px;
        }
        .title{
            margin-bottom: 10px;
        }
        .comment, .message{
            background-color: #eee;
            padding: 10px 10px;
            margin-bottom: 20px;
        }
        .comment__name, .comment__text, .sub-message__form-name,.sub-message__form-text{
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 5px;
            border: none;
            box-shadow: 0 0 10px -5px;
            outline: none;
        }
        .comment__text{
            text-align: left;
            padding-top: 2px;
            margin-top: 10px;
            resize: none;
        }
        .message__bg{
            position: relative;
            background-color: #fff;
            padding: 15px 60px 5px 60px;
            box-shadow: 0 0 10px -5px;

        }
        .message__index{
            position: absolute;
            left: 10px;
            top: 15px;
            font-size: 12px;

        }
        .message__pic, .sub-message__pic{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #aaa;
            display: inline-block;
        }
        .message__info, .sub-message__info{
            display: inline-block;
            margin-left: 8px;
            font-size: 12px;
        }
        .message__text{
            margin-top: 15px;
            padding-bottom: 40px;
        }
        .sub-message{
            margin-top: 10px;
        }
        .sub-message__text{
            margin-top: 15px;
            padding-bottom: 10px;
        }
        
        .sub-message__sum{
            margin-bottom: 5px;
            font-size: 12px;
        }
        .sub-message__form-text{
            margin-top: 10px;
        }
        .sub-message__form, .sub-message{
            background-color: rgb(189, 213, 245);
            padding: 10px;
            margin-bottom: 10px;
        }
        .comment__btn, .message__btn{
            padding: 5px 10px;
            background: rgb(26, 78, 112);
            margin-top: 10px;
            border-radius: 5px;
            color: #fff;
        }
        .comment__btn:hover, .message__btn:hover{
            transform: scale(1.1);
            cursor: pointer;
        }
        .comment_id{
            display: none;
        }
        .go-message_btn{
            display: inline-block;
            padding: 5px 10px;
            background: #ddd;
            font-size: 12px;
            letter-spacing: 1px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .display-none{
            display: none;
        }
        .logout{
            display: inline-block;
            position: absolute;
            top: 10px;
            right: 10px;
            border: solid 1px;
            padding: 10px 20px;
            transition: all 0.2s;
        }
        .logout:hover{
            transform: scale(0.9);
            cursor: pointer;
            background: #9e212d;
            color: #fff;
            border: none;
        }
        .pages{
            text-align: center;
        }
        .page{
            display: inline-block;
            margin: 10px;
            cursor: pointer;
        }
        .page--clicked{
            color: red;
            transform: scale(1.2);
        }
        .form_pages{
            text-align: center;
        }
        .form_pages-input{
            display: inline-block;
            width: 25px;
            cursor: pointer;
            font-size: 18px;
            margin: 5px;
            border: none;
        }

    </style>
</head>
<body>
    <div class="logout">我要登出</div>
    <div class="wrap">
        <header class="header">CHAT BOARD</header>
        <section class="comment">
            <h1 class="title">我要留言</h1>
            <form action="" method="get">
                <input type= "text" class= "comment__name" name="comment__name" placeholder= "name" value="<?php echo $value; ?>">
                <!-- 此處的 value 設為 $value，讓名稱預設為登入者的暱稱或 userId -->
                <textarea class= "comment__text" name="comment__text" placeholder= "comment..." rows= "6" cols= "50" ></textarea>
                <input class= "comment__btn" type="submit" value="留言">
            </form>
        </section>
<?php
$sql = "SELECT COUNT(*) as sum FROM tingkao_main";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if(is_int($row['sum']/10)){
    $pages = $row['sum']/10;
}else{
    $pages = ceil($row['sum']/10);
};
//取出資料數量/10，來判斷總共有幾頁

$page = 1;//現在在第幾頁，一開始進來的時候在第一頁．後面隨著點選頁數，$page 會改變數值．
if(isset($_GET['form_page'])){
    $page = $_GET['form_page'];
};
if($page === 1){
    $sql = "SELECT * FROM tingkao_main ORDER BY id DESC LIMIT 10"; 
    // DESC 顛倒順序，讓新留言在最上面，LIMIT 10，只取十筆資料在一頁
}else{
    $number = 10*($page - 1);
    $sql = "SELECT * FROM tingkao_main ORDER BY id DESC LIMIT $number, 10"; 
    // DESC 顛倒順序，讓新留言在最上面，LIMIT 參數一, 參數二，參數一：略過前面幾個，參數二：取幾個。
}
$result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id']; //一頁中被 select 出來的 id
            $sum_sql = "SELECT COUNT(*) as sum FROM tingkao_sub WHERE id = $id"; // 撈出每個主留言 id 下的子留言數量
            $sum_result = $conn->query($sum_sql);
            $sum_row = $sum_result->fetch_assoc();
            $sum = $sum_row['sum'];  //$sum 為每個主留言下的子留言數量
?>
        <section class="message">
            <div class="message__bg">
                <h2 class= "message__index" >#0<?php echo $row["id"]?></h2>
                <div class="message__pic"></div>
                <div class="message__info">  
                    <p class="message__name"><?php echo $row["mainCommenter"]?></p>
                    <p class="message__time"><?php echo $row["created_at"]?></p>
                </div>
                <p class="message__text"><?php echo $row["mainComment"]?></p>
                <p class="sub-message__sum"><?php echo $sum?> 則回應</p>
                <hr>
                <div class="go-message_btn">我要留言 ▶ </div>
        <?php
        $sub_sql = "SELECT * FROM tingkao_sub";
        $sub_result = $conn->query($sub_sql);
        if ($sub_result->num_rows > 0 ) {
            while($sub_row = $sub_result->fetch_assoc()) {
                if($row['id']===$sub_row['id']){
        ?>                    
                        <div class="sub-message display-none">
                            <div class="sub-message__pic"></div>
                            <div class="sub-message__info">  
                                <p class="sub-message__name"><?php echo $sub_row["subCommenter"]?></p>
                                <p class="sub-message__time"><?php echo $sub_row["created_at"]?></p>
                            </div>
                            <p class="sub-message__text"><?php echo $sub_row["subComment"]?></p>
                        </div>
        <?php
                };
            };
        } else {
            echo "0 结果";
        };
        ?>
                        <div class="sub-message__form display-none">
                            <form action="" method="get">
                                <input type="text" class= "comment_id" name="comment_id" value="<?php echo $row['id']?>">
                                <!-- 此部分為資料儲存，頁面不顯示，從這個 id 來比對這個子留言隸屬哪個父留言 -->
                                <input type= "text" class= "sub-message__form-name" name="sub-message__form-name" placeholder= "name" value="<?php echo $value?>">
                                <!-- 此處的 value 設為 $_COOKIE['user_id'] 或暱稱，讓名稱預設為登入的 userId 或暱稱 -->
                                <textarea class= "sub-message__form-text" name="sub-message__form-text" placeholder= "comment..." rows= "3" cols= "50" ></textarea>
                                <input class= "message__btn" type="submit" value="回覆">
                            </form>
                        </div>
                </section>
<?php
        };
    } else {
        echo "0 结果";
    };
    // 下面還有 php 時不可以加 $conn->close(); 加 $conn->close() 的用意是??
?>
            <form action="" method="get" class="form_pages">
                <!-- <input type="submit" class="form_pages-input" value="[1]"> -->
            </form>
</div>    
</body>
<script>
    let pages = <?php echo $pages ;?>; //有幾頁 
    let fragment = document.createDocumentFragment();
    function createInput(){
        let newInput = null
        for(i=1; i<=pages; i++){
            newInput = document.createElement('input');
            newInput.className = "form_pages-input";
            newInput.setAttribute('data-num', i);
            newInput.setAttribute('value', i );
            newInput.setAttribute('name', 'form_page');
            newInput.setAttribute('type', 'submit');
            document.querySelector('.form_pages').appendChild(newInput); 
            fragment.appendChild(newInput);
        }
    }
    createInput()
    document.querySelector('.form_pages').appendChild(fragment); 

    document.querySelectorAll('.message__bg').forEach(function(element){
        //把事件綁在父層
        element.addEventListener('click', function(e){
        //用 e.tatget 可以得到該元素
            if(e.target.classList.contains('go-message_btn') === true){
                //判斷按下的是 'go-message_btn' 這個按鈕
                if(element.querySelector('.sub-message')!==null){
                    element.querySelectorAll('.sub-message').forEach(
                        function(el){ 
                            el.classList.toggle('display-none')
                        })
                }//此處為如果有子留言就顯示子留言
                element.querySelector('.sub-message__form').classList.toggle('display-none')
            }//不管有沒有子留言都要顯示留言表單
        })
    })

    document.querySelectorAll('.go-message_btn').forEach(function(element){
        element.addEventListener('click', function(e){
            if(element.classList.contains('message--opened') !== true){
                element.innerText = '關閉留言 ▼'
                element.classList.add('message--opened')
            }else{
                element.innerText = '我要留言 ▶'
                element.classList.remove('message--opened')
            }
        })
    })
    document.querySelector('.logout').addEventListener('click',function(){
        document.location.href="logout.php";
        // 如過使用 SESSION 的話會有以下疑問（已改為使用 COOKIE）
        // unset($_SESSION['user_password']); >>> 刪除指定的 session
        // session_destroy(); >>> 刪除全部的 session
        // 不能在這邊設置，會在沒有 click 登出按鈕的情況下就刪除 SESSION（送出 submit 的時候）
        // 把 unset($_SESSION['user_password']); 改為到 login.php 頁面時刪除
        // 這裡有沒有更好的，放 unset($_SESSION['user_password']); 的地方？
        // 因爲目前如果按回登入頁面等同於登出了！
        // 但應該要按 “登出” 的時候才清除 SESSION，所以應該不是設置在登入頁面上
        // 但是放在 addEventListener 裡面，會無法限制他在被 click 的時候才啟用？
    })

</script>
    <!-- 疑問：
    在回覆留言後，要怎麼讓該留言的子留言仍保持在開啟的狀態？ 還是必須使用不同步(不更新頁面)的狀況才能達到？
    目前想到的辦法1：
        如果是取資料庫子留言的最後一筆資料的父留言 id，就可以知道哪個父留言的子留言要打開為顯示的狀態，
        但那在第一次留言前也會有最後一筆資料，就會有留言的子留言是顯示狀態
    目前想到的辦法2：
        在回覆留言之後，取該子留言的父留言 id，並存取在 COOKIE 裡面，在 submit 之後(重新載入)，
        就可以知道哪個父留言的子留言要打開為顯示的狀態，這個方法好像可行？
    
    或是還有其它方式可以達到這個目的嗎？
    想要一開始進去的時候子留言都是未顯示的，但在某父留言留了子留言後(submit 重載後)，該留言的子留言仍是顯示的狀態？-->
</html>
