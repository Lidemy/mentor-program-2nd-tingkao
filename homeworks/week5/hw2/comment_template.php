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
}
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
    }
    // 下面還有 php 時不可以加 $conn->close(); 加 $conn->close() 的用意是??
?>