<?php
require_once('User.Class.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    //validateモード処理
        //Userクラスに引数渡す
        $user_data = new User($_POST['user_name'],$_POST['USERS_ID'],$_POST['email'],$_POST['password']);
        $filter_list=$user_data->filter();
        $user_name = $filter_list['user_name'];
        $USERS_ID = $filter_list['USERS_ID'];
        $email = $filter_list['email'];
        $password = $filter_list['password'];

        $err_msg='';
        if($user_name == ''){
            $err_msg.='ユーザ名が入力されていません。<br>';
        }
        if($USERS_ID == ''){
            $err_msg.='ユーザIDが入力されていません。<br>';
        }
        if($email == ''){
            $err_msg.='メールアドレスが入力されていません。<br>';
        }
        if($password == ''){
            $err_msg.='パスワードが入力されていません。<br>';
        }

        if(isset($_POST['mode'])){
            if($mode=="validate"){
                //modeコンストラクタの使用
                $user_data = new User($_POST['mode']);
                $filter_mode=$user_data->filter_mode();
            }
        }
    }

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
    <header style="padding:"></header>
    <!--main-->
    <main style="margin-top:50px;">
        <form action="register.php?mode=validate" method="post">
            <div class="container text-center">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col" style="text-align:right;">
                        <h1 style="font-weight:100;color:green;text-align:center;">新規登録</h1>
                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col" style="">
                    <!--bootstrapエラーメッセージの表示-->  
                    <?php if(isset($err_msg)){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $err_msg;?>
                        </div>
                    <?php }?>      
                    <table>
                                <tr>
                                    <th>ユーザ名</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="user_name" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($user_name)){ echo $user_name; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ユーザID</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="USERS_ID" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($USERS_ID)){ echo $USERS_ID; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="email" name="email" class="form-control" id="exampleFormControlInput2" value="<?php if(isset($email)){ echo $email; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>パスワード</th>
                                    <td>
                                        <div class="mb-3">
                                            <input type="text" name="password" class="form-control" id="exampleFormControlInput3" value="<?php if(isset($password)){ echo $password; } ?>" >
                                        </div>
                                    </td>
                                </tr>
                            </table>
                    </div>
                    <div class="col">

                    </div>
                </div>
                <div class="card container" style="width: 18rem;display:flex;justify-content:center;">
                    <div class="card-body" >
                    ※パスワードは少なくとも1つの小文字、1つの大文字、1つの数字を含み、8文字以上で作成して下さい。
                    </div>
                </div>
                <br>
                <!--確認ボタン-->
                <div class="container text-center;">
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col" style="text-align:center;">
                            <button type="button" class="btn btn-secondary" onclick="location.href='login.php'">戻る</button>
                            <button type="submit" name="action" class="btn btn-primary" onclick="location.href='register_confirm.php'">確認</button>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <!--main終了-->
</body>
</html>