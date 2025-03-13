<?php
require_once ('Modules/Passwordreset.Class.php');

//ログインの認証

$passre = new Passwordreset();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $password1 = htmlspecialchars($_POST['password1']);
    $password2 = htmlspecialchars($_POST['password2']);
    $csrfToken = htmlspecialchars($_REQUEST['csrfToken']);
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
    }elseif($_REQUEST['email']){
        $email = htmlspecialchars($_REQUEST['email']);
    }
    //$password1がテーブルに存在しない
    $err_msg = $passre->passwordVerify($email,$password1,$password2,$csrfToken);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードのリセット</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
<header style="padding:50px;"></header>
<main>
    <div class="container">
            <h1></h1>
            <p style="text-align:center;font-size:20px;">お買い物アプリ：パスワードリセット</p>
           
            <form id="form1" class="center" action="" method="post">
                <table>
                    <tr>
                        <td></td>
                        <td>
                            <?php if(isset($err_msg) && !empty($err_msg)){?>
                                <span style="text-align:center;color:red;"><?php echo $err_msg; ?></span>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password1">パスワード:
                        </th>
                            <td>
                            <input type="text" name="password1">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password2">パスワード再入力：
                        </th>
                        <td>
                            <input type="text" name="password2">
                        </td>
                    </tr>
                </table>
                <br>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            
                        </div>
                        <div class="col" style="text-align:left;">
                            <button type="submit" class="btn btn-warning">送信</button>
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