<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
    <style>
        .wrap{
            height: 90vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .content{
            width: 300px;
            border-radius: 15px;
            background-color: rgb(26, 78, 112);
            padding: 40px 20px 20px 20px;
            box-shadow: 0 0 20px -5px;
        }
        .input{
            display: block;
            margin: auto;
            outline: none;
            border: solid 1.5px #fff;
            margin-bottom: 20px;
        }
        .user_id, .user_password, .user_nickname{
            width: 80%;
            height: 25px;
            border-radius: 5px;
        }
        .user_password{
            margin-bottom: 30px;
        }
        #login_btn{
            width: 80px;
            padding: 4px;
            border-radius: 5px;
        }
        #login_btn:hover{
            background-color: rgb(153, 214, 255);
            color: #fff;
            font-weight: 900;
            letter-spacing: 1px;
            cursor: pointer;
            transform: scale(1.1);
        }

        .change_btn{
            text-align: center;
            margin-top: -10px;
            color: #ccc;
        }
        .change_btn:hover{
            cursor: pointer;
            color: #fff;
            transform: scale(1.05);
        }
        .display-none{
            display: none;
        }
    
    </style>
</head>
<body>
    <div class="wrap">
        <div class="content">
            <div class="user_picture"></div>
            <form id="login_form" action="index.php" method="post">
                <input type="text" class= "input user_nickname display-none" name="user_nickname" placeholder= "Nickname">
                <input type="text" class= "input user_id" name="user_id" placeholder= "UserId">
                <input type= "password" class= "input user_password" name="user_password" placeholder= "Password">
                <input id= "login_btn" class="input" type="submit" value="登入">
                <div class="change_btn">我要註冊</div>
            </form>
        </div>
    </div>
</body>

<script>
    document.querySelector('.change_btn').addEventListener('click',function(e){
        console.log(document.querySelector('.change_btn').innerText)
        if(document.querySelector('.change_btn').innerText === '我要註冊'){
            document.querySelector('.change_btn').innerText = '我要登入'
            document.querySelector('#login_btn').value = '註冊'
            document.querySelector('#login_btn').classList.add('signup_btn')
            document.querySelector('#login_form').setAttribute('action','signup.php')
            document.querySelector('.user_id').setAttribute('placeholder','UserId*(必填)')
            document.querySelector('.user_password').setAttribute('placeholder','Password*(必填)')
            document.querySelector('.user_nickname').classList.remove('display-none')
        }else{
            document.querySelector('.change_btn').innerText = '我要註冊'
            document.querySelector('#login_btn').value = '登入'
            document.querySelector('#login_btn').classList.remove('signup_btn')
            document.querySelector('#login_form').setAttribute('action','index.php')
            document.querySelector('.user_id').setAttribute('placeholder','UserId')
            document.querySelector('.user_password').setAttribute('placeholder','Password')
            document.querySelector('.user_nickname').classList.add('display-none')
        }
        
    })

    document.querySelector('#login_btn').addEventListener('click',function(e){
        let oname = document.forms['login_form'];
        let name = oname.elements.user_id.value;
        let opassword = document.forms['login_form'];
        let password = opassword.elements.user_password.value;

        if(name&&password){
            // alert('填寫了帳號密')
            // 到資料端比對資料
        }else{
            e.preventDefault();
            alert('請輸入正確的帳號密碼！')
        }
    })

</script>
</html>