<?php
require_once('Modules/User.Class.php');
require_once('Modules/Registeruser_db.Class.php');

session_start();
//このページに送られてきたsessionの削除
print_r();
//sessionのデータの受け取り
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
/* if(isset($_SESSION)){
    $user_name = $_SESSION['user_name'];
    $USERS_ID = $_SESSION['USERS_ID'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
} */

//リダイレクトで飛ばしているので遷移しないため一旦同ページで動作確認
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $user_data = new User($_POST['user_name'],$_POST['USERS_ID'],$_POST['email'],$_POST['password']);
    //sessionを作成し、submit値変わりにする
    $_SESSION['form_data_2']=array($user_name,$USERS_ID,$email,$password);
    header("location:register.php"); 
    exit();
}else{
   /*  if(empty($_SESSION['form_data'])){
     
    }else{
        $user_name = $_SESSION['user_name'];
        $USERS_ID = $_SESSION['USERS_ID'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
    }  */
     
}
unset($_SESSION['form_data']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
    <title>新規登録</title>
</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <header style="padding:40px;"></header>
    <!--main-->
    <main>
        <div class="container text-center" style="padding:20px;">
            <div class="row">
                <div class="col">

                </div>
                <div class="col" style="text-align:right;">
                    <h1 style="font-weight:100;color:blue;text-align:center;">登録情報の確認</h1>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
        <div class="container text-center">
            <div class="row">
                <div class="col">

                </div>
                <div class="col" style="display:flex;justify-content:center;">
                    <table class="table table-bordered">
                        <tr>
                            <th>ユーザ名</th>
                            <td>
                                <div class="mb-3">
                                    <?php if(isset($user_name)){echo $username;}?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>ユーザID</th>
                            <td>
                                <div class="mb-3">
                                    <?php if(isset($USERS_ID)){ echo $USERS_ID;}?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>
                                <div class="mb-3">
                                    <?php if(isset($email)){echo $email;} ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>パスワード</th>
                            <td>
                                <div class="mb-3">
                                    <?php if(isset($password)){echo $password;}?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col">

                </div>
            </div>
            <br>
            <!--送信ボタン-->

            <div class="container text-center;">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col" style="text-align:center;display:flex;justify-content:center;">
                    <form action="" method="post">
                        <button type="submit" name="action1" class="btn btn-secondary">戻る</button>
                        <?php if(!empty($_SESSION)){ ?>
                            <input type="hidden" name="user_name" value="<?=$_SESSION['user_name']?>">
                            <input type="hidden" name="USERS_ID" value="<?=$_SESSION['USERS_ID']?>">
                            <input type="hidden" name="email" value="<?=$_SESSION['email']?>">
                            <input type="hidden" name="password" value="<?=$_SESSION['password'] ?>">
                        <?php }?>
                    </form>

                    <form action="registerComplete.php" method="post">
                        <button type="button" name="action2" class="btn btn-primary" onclick="location.href='registerComplete.php'">登録</button>
                    </form>
                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--main終了-->
</body>
</html>