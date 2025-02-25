<?php



require_once('Modules/User.Class.php');

require_once('Modules/Authentification.Class.php');

session_start();

/* print_r($_SESSION); */



//セッション切れリダイレクト

if(isset($_SESSION) && empty($_SESSION)){

    header('Location: https://marutani098723.com/new_app/login.php');

}

?>



<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>サイドメニュー画面</title>
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <header></header>
        <!--main-->
        <main>
            <div class="container-fluid">
                <div class="row">
                    <!--オフキャンバスボタン-->
                    <div class="col">
                        <header style="background-color:#e731fa;justify-content:left;">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDark" aria-controls="offcanvasDark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5"/>
                                    <path d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194z"/>
                                </svg>
                            </button>
                            <h2 style="color:white;">お買い物管理</h2>
                        </header>
                    </div>
                    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDark" aria-labelledby="offcanvasDarkLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasDarkLabel">
                                    <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                                        <i class="fs-5 fa fa-gauge"></i><span class="fs-4 d-sm-inline"><?php echo $_SESSION['user_name'];?>様</span>
                                    </a>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close" style="text-align:left;"></button>
                            </div>
                            <div class="offcanvas-body">
                                <nav class="nav nav-pills flex-column mt-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="wrapper.php" class="nav-link text-white active">
                                                <span class="fs-5">アプリ概要</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="settings.php" class="nav-link text-white">
                                                <i class="fs-5 fa fa-cog"></i><span class="fs-5">設定</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="registerCommodity.php" class="nav-link text-white">
                                                <i class="fs-5 fa fa-registered"></i><span class="fs-5">候補登録</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="confirm.php" class="nav-link text-white">
                                                <i class="fs-5 fa fa-check"></i><span class="fs-5">購入確定</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="history.php" class="nav-link text-white">
                                                <i class="fs-5 fa fa-history"></i><span class="fs-5">購入履歴</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="login.php" class="nav-link text-white">
                                                <i class="fs-5 fa fa-sign-out"></i><span class="fs-5">ログアウト</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!--オフキャンバスのスタイル-->
                    <style>
                        /* Default style */
                        .offcanvas {
                            width: 300px; /* Full width by default */
                            max-width: 300px;
                            overflow-x: hidden;
                        }
                    </style>
                    <!--右サイド-->
                    <div class="row" style="justify-content:center;">
                        <div class="col-12 py-3" >
                            <h3 style="color:pink;">お買い物管理アプリとは</h3>
                            <p class="lead">
                                商品購入前に支払う合計の金額が算出できるアプリです。無駄遣い防止に役立ちます。
                                また、購入確定すると商品の購入履歴が残ります。
                            </p>
                            <ul class="list-unstyled">
                                <li>
                                    <h5 style="color:pink;">ご使用方法</h5>
                                    1.「設定」より所持金や消費税額、目標金額の設定をします。
                                    ここで設定した消費税は一括で登録されますが、「商品登録」より個別で商品の消費税を変更することが可能です。
                                    目標金額は、決まった金額に収めたい時に設定します。使用しない場合は0を入力して下さい。
                                    <div>
                                        <img src="image/settings.png" style="width:80%;height:80%">
                                    </div>
                                </li>
                                <li>
                                    2.「候補登録」にて購入検討中の商品の情報を登録します。
                                    商品登録後、一覧画面下に追加された商品の情報が出ます。
                                    こちらで購入前の商品情報の編集削除ができます。
                                    <div>
                                        <img src="image/registerCommodity.png" style="width:80%;height:80%">
                                    </div>
                                </li>
                                <li>
                                    3.「購入確定」で購入したい商品を確認します。
                                    全選択されており、解除したい商品のみ選択解除します。
                                    右下の残高等の情報を確認しよければ確認ボタンを押します。
                                    「購入確定」の購入確認ボタン押下後「確定ボタン」を押し商品の購入を確定します。
                                    <div>
                                        <img src="image/confirm.png" style="width:80%;height:80%;">
                                    </div>
                                </li>
                                <li>
                                    4.「購入履歴」からお買い物履歴を確認できます。セレクトボックスで年と月を絞り込むと便利です。
                                    <div>
                                        <img src="image/history.png" style="width:80%;height:80%;">
                                    </div>
                                </li>
                            </ul>
                        <!--row終わり-->
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>