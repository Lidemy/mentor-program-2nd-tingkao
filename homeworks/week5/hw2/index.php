<!-- http://localhost:8080/tingkao/index.php -->

<?php require_once('connect.php'); ?>
<?php require_once('verify.php'); ?>
<?php require_once('add_comment.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
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
<?php require_once('comment_template.php'); ?>
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
    })
</script>
</html>
