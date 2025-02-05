<?php
require_once('User.Class.php');

$user_data = new User();
//postデータのフィルタリング
$filter_list=$user_data->filter($_POST);
//配列で取得
$user_name = $filter_list['user_name'];
$USERS_ID = $filter_list['USERS_ID'];
$email = $filter_list['email'];
$password = $filter_list['password'];

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
        <form>
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
                                        <?=$user_name?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>ユーザID</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$USERS_ID?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$email ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>パスワード</th>
                                <td>
                                    <div class="mb-3">
                                        <?=$password?>
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
                        <div class="col" style="text-align:center;">
                            <button type="button" class="btn btn-secondary" onclick="location.href='register.php'">戻る</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='registerComplete.php'">登録</button>
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