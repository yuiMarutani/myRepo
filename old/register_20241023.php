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
                <div class="col" style="display:flex;justify-content:center;">
                    <form>
                        <table>
                            <tr>
                                <th>ユーザ名</th>
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>パスワード</th>
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
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
                        <button type="button" class="btn btn-primary" onclick="location.href='register_confirm.php'">確認</button>
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