<?php

require_once('Modules/User.Class.php');

require_once('Modules/Passwordreset.Class.php');



$passwordreset = new Passwordreset();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $user_data = new User(null,null,$_POST['email'],null,null);

    $filter_list = $user_data->filter();

    $email= $filter_list['email'];    


    //csrftokenの作成

    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));

    $msg = $passwordreset->authorize($email,$_SESSION['_csrf_token']);
    $mailsend = 1;
    

}



?>

<!DOCTYPE html>

<html lang="ja">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>パスワードを忘れた場合</title>

    <link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <header style="padding:"></header>

    <!--main-->

    <main style="margin-top:50px;">

    <?php if(isset($msg)){ ?>

            <div style="text-align:center;color:red;"><?=$msg?></div>

    <?php }?>

        <form action="" method="post">

            <div class="container text-center">

                <div class="row">

                    <div class="col">



                    </div>

                    <div class="col" style="text-align:right;">

                        <h1 style="font-weight:30;text-align:center;"><font size="5">パスワードリセット</font></h1>

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

                            <table>

                                <tr>

                                    <td>メールアドレスを入力して送信ボタンを押して下さい。</td>

                                </tr>

                                <tr>

                                    <td>

                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="exampleFormControlInput1" name="email">

                                        </div>

                                    </td>

                                </tr>

                            </table>

                        

                    </div>

                    <div class="col">



                    </div>

                </div>

                <span>送信されたメールから新規パスワードを登録して下さい。</span>

                <!--メール送信-->

                <br>

                <br>

                <div class="container text-center;">

                    <div class="row">

                        <div class="col">



                        </div>

                        <div class="col" style="text-align:center;">

                            <button type="button" class="btn btn-secondary" onclick="location.href='login.php'">戻る</button>
                            <?php if(isset($mailsend)&& $msg=="メール宛てにパスワードのリセット用リンクを送信しました。<br>24時間以内にリセットして下さい。"){?>
                                <button type="submit" class="btn btn-primary" disabled>送信</button>
                            <?php }else{?>
                                <button type="submit" class="btn btn-primary">送信</button>
                            <?php }?>
                        </div>

                        <div class="col">



                        </div>

                    </div>

                </div>

            </div>

            <input type="hidden" name="_csrf_token" value="
            <?php 
            if(isset($_SESSION['_csrf_token'])){
             $_SESSION['_csrf_token']; 
            }
            ?>
            ">
    </form>

    </main>

    <!--main終了-->

    

</body>

</html>