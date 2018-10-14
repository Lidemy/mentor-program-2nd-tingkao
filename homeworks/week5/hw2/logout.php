<?php
    setcookie("user_id","", time()-3600);
    setcookie("user_password","", time()-3600);
    echo '登出！';
    echo '<a href="login.php">回登入頁面</a>';
    // header('Location: index.php');
?>