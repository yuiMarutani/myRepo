<?php
require_once('Modules/User.Class.php');
require_once('Modules/Authentification.Class.php');

//ログインの認証
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_data = new User(null,$_POST['USERS_ID'],null,$_POST['password'],null);
    $filter_list = $user_data->filter();
    $USERS_ID = $filter_list['USERS_ID'];    
    $password = $filter_list['password'];
    if(!empty($USERS_ID) && !empty($password)){
        $auth = new Authentification();
        $msg = $auth->authentification($USERS_ID,$password);
    }
    
  
    
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <header><img src="image/vegetables.jpg" alt="..."></header>
    <!--main-->
    <main>
        <div class="container">
            <h1>お買い物管理アプリ</h1>
            <h2>ログイン</h2>
           
            <form id="form1" class="center" action="" method="post">
                <table>
                    <tr>
                        <td></td>
                        <td>
                            <?php if(isset($msg) && !empty($msg)){?>
                                <span style="text-align:center;color:red;">ログインに失敗しました。</span>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="user_name">ユーザID：
                        </th>
                            <td>
                            <input type="text" name="USERS_ID">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password">パスワード：
                        </th>
                        <td>
                            <input type="text" name="password">
                        </td>
                    </tr>
                </table>
                <br>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            
                        </div>
                        <div class="col" style="text-align:left;">
                            <button type="submit" class="btn btn-info">ログイン</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        
                    </div>
                    <div class="col"  style="text-align:left;">
                        <a href="register.php">新規登録</a>
                    </div>
                    <div class="col">
                            
                    </div>
                </div>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        
                    </div>
                    <div class="col"  style="text-align:left;">
                        <a href="forgotPassword.php">パスワードをお忘れの場合</a>
                    </div>
                    <div class="col">
                            
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--main ends-->
    <footer></footer>
</body>
</html>