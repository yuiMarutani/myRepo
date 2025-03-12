<?php
require_once('Modules/User.Class.php');
require_once('Modules/Registeruser_db.Class.php');

//同ページでvalidate処理
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_data = new User($_POST['user_name'],$_POST['USERS_ID'],$_POST['email'],$_POST['password'],$_REQUEST['mode']);
    $filter_list = $user_data->filter();
    $user_name = $filter_list['user_name'];
    $USERS_ID = $filter_list['USERS_ID'];
    $email = $filter_list['email'];
    $password = $filter_list['password'];
    $mode = $filter_list['mode'];

    if($mode =="validate"){
        //同ページでvalidation
        $err_msg = $user_data->registerValidation();
        $duplicate= new Registeruser_db();
        $err_msg_dup= $duplicate->validate_duplicate($USERS_ID, $user_name, $email, $password);

        //validationでエラーがなかったらconfirmモードへ
        if(isset($err_msg) && empty($err_msg) && isset($err_msg_dup) && empty($err_msg_dup)){
           $mode="confirm";
        }
    }elseif($mode == "confirm"){
     //戻るボタンが押された時
      if(isset($_POST['flg']) && $_POST['flg'] == 1){
        //flgをフィルタリング
        $flg = $user_data->filter_param($_POST['flg']);
        //戻るモード
        $mode="return";
      }
    }elseif($mode == "return"){
        
    }elseif($mode == "registercomplete"){
        //データベース接続、挿入モード
        $insertdatabase = new Registeruser_db();
        //正常に登録できたか、または重複でできなかったかのメッセージ
        $msg = $insertdatabase->checkduplicates($USERS_ID, $user_name, $email, $password);
    }
  
}else{
    //最初のページはvalidateモード
    $mode = "validate";
    $user_name = '';
    $USERS_ID = '';
    $email = '';
    $password = '';
}

?>
<?php if($mode  == "validate" || $mode == "return"){ ?>
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
    <header style="padding:"></header>
    <!--main-->
    <main style="margin-top:50px;">
        <form action="register.php?mode=validate" method="post">
            <div class="container text-center">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col mb-3" style="text-align:right;">
                        <h1 style="font-weight:100;color:green;text-align:center;white-space:nowrap;">新規登録</h1>
                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-12" style="text-align:center;white-space:nowrap;">
                        <!--bootstrapエラーメッセージの表示-->  
                        <?php if(isset($err_msg) && $err_msg!=''){ ?>
                            <div style="display:flex;justify-content:center;white-space:nowrap;">
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $err_msg;?>
                                </div>
                            </div>
                        <?php }?>
                        <?php if(isset($err_msg_dup) && $err_msg_dup!=''){ ?>
                            <div style="display:flex;justify-content:center;white-space:wrap;">
                                <div class="alert alert-dark" role="alert">
                                    <?php echo $err_msg_dup;?>
                                </div>
                            </div>
                        <?php } ?>      
                            <table style="display:flex;justify-content:center;">
                                <tr>
                                    <th style="white-space:nowrap;">ユーザ名</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="user_name" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($user_name)){ echo $user_name; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="white-space:nowrap;">ユーザID</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="USERS_ID" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($USERS_ID)){ echo $USERS_ID; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="white-space:nowrap;">メールアドレス</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="email" name="email" class="form-control" id="exampleFormControlInput2" value="<?php if(isset($email)){ echo $email; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="white-space:nowrap;">パスワード</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="password" class="form-control" id="exampleFormControlInput3" value="<?php if(isset($password)){ echo $password; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <div class="card container" style="width: 18rem;display:flex;justify-content:center;text-align:left;">
                    <div class="card-body">
                        ※パスワードは少なくとも1つの小文字、1つの大文字、1つの数字を含み、8文字以上24文字以下で作成して下さい。
                    </div>
                </div>
                <br>
                <!--確認ボタン-->
                <div class="container text-center;">
                    <div class="row">
                        <div class="col-12" style="text-align:center;">
                            <button type="button" class="btn btn-secondary" onclick="location.href='login.php'">戻る</button>
                            <input type="submit" class="btn btn-primary"  value="確認">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <!--main終了-->
</body>
</html>
<?php }elseif($mode == "confirm"){ ?>
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
                <div class="col-12">
                    <h1 style="font-weight:100;color:blue;text-align:center;">登録情報の確認</h1>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
        <div style="display:flex;justify-content:center;">
            <table class="table table-bordered" style="display:flex;justify-content:center;">
                <tr>
                    <th style="white-space:nowrap;">ユーザ名</th>
                    <td>
                        <div class="mb-3">
                            <?=$user_name;?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="white-space:nowrap;">ユーザID</th>
                    <td>
                        <div class="mb-3">
                            <?=$USERS_ID;?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="white-space:nowrap;">メールアドレス</th>
                    <td>
                        <div class="mb-3">
                            <?=$email; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="white-space:nowrap;">パスワード</th>
                    <td>
                        <div class="mb-3">
                            <?=$password;?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <!--送信ボタン-->
            <div style="display:flex;justify-content:center;">
                <form action="register.php?mode=return" method="post">
                    <input type="hidden" name="user_name" value="<?=$user_name?>">
                    <input type="hidden" name="USERS_ID" value="<?=$USERS_ID?>">
                    <input type="hidden" name="email" value="<?=$email?>">
                    <input type="hidden" name="password" value="<?=$password ?>">
                    <button type="submit" name="flg" class="btn btn-secondary" value="1">戻る</button>
                </form>
                &nbsp;
                <form action="register.php?mode=registercomplete" method="post">
                    <input type="hidden" name="user_name" value="<?=$user_name?>">
                    <input type="hidden" name="USERS_ID" value="<?=$USERS_ID?>">
                    <input type="hidden" name="email" value="<?=$email?>">
                    <input type="hidden" name="password" value="<?=$password ?>">
                    <button type="submit" name="complete" class="btn btn-primary" value="1">登録</button>
                </form>
            </div>
    </main>
    <!--main終了-->
</body>
</html>
<?php }elseif($mode=="registercomplete"){ ?>
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
        <header style="padding:40px;">
        <?php if(isset($msg) && $msg == "ユーザID、メールアドレス、パスワードのいずれかが登録されているので登録できません。"){?>
        <font size="5" style="color:blue;">
            <?php echo $msg;?>
            <br>
            ログイン画面からもう一度やり直してください。
            <br>
            <a href="login.php">トップへ</a>
        </font>
        </header>
        <?php }else{?>
        <font size="5" style="color:green;">
            <?php echo $msg;?>
        </font>
        <br>
        </header>
        <!--main-->
        <main>
            <div class="container text-center">
                <span style="text-align:center;color:red;white-space:nowrap;">※登録した情報は忘れないようにメモなどに控えて下さい。</span>
            </div>
            <!--戻るボタン-->
            <div class="container text-center;">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col" style="justify-content:center; text-align:center;">
                        <table class="table table-bordered">
                            <tr>
                                <th style="white-space:nowrap;">ユーザ名</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$user_name;?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap;">ユーザID</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$USERS_ID;?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap;">メールアドレス</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$email; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap;">パスワード</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$password;?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <a href="login.php">ログイントップへ</a>
                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
            </div>
        </main>
        <!--main終了-->
        <?php }?>
        </header>
        
    </body>
    </html>

<?php }else{ }?>

   
