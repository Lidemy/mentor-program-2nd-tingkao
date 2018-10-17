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

