<?php

require_once('Modules/User.Class.php');
require_once('Modules/Authentification.Class.php');
session_start();
/* print_r($_SESSION); */
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
        <div class="container-fluid" style="white-space:nowrap;">
            <div class="row flex-no-wrap">
                <div class="bg-dark col-auto col-md-2 min-vh-100">
                    <div class="bg-dark p-2">
                        <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                            <i class="fs-5 fa fa-gauge"></i> <span class="fs-4 d-none d-sm-inline">お買い物管理</span>
                        </a>
                        <nav class="nav nav-pills flex-column mt-4">
                            <ul>
                                <li class="nav-item">
                                    <a href="wrapper.php" class="nav-link text-white active">
                                        <span class="fs-5 d-none d-sm-inline">アプリ概要</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="settings.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-cog"></i><span class="fs-5 d-none d-sm-inline">設定</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="registerCommodity.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-registered"></i><span class="fs-5 d-none d-sm-inline">候補登録</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="confirm.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-check"></i><span class="fs-5 d-none d-sm-inline">購入確定</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="history.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-history"></i><span class="fs-5 d-none d-sm-inline">購入履歴</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="login.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-sign-out"></i><span class="fs-5 d-none d-sm-inline">ログアウト</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--右サイド-->
                <div class="col py-3">
                    <h3 style="color:pink;">お買い物管理アプリとは</h3>
                    <p class="lead">
                        商品購入前に支払う合計の金額が算出できるアプリです。無駄遣い防止に役立ちます。<br>
                        また、購入確定すると商品の購入履歴が残ります。
                    </p>
                    <ul class="list-unstyled">
                        <li>
                            <h5 style="color:pink;">ご使用方法</h5>
                            1.「設定」より所持金や消費税額、目標金額の設定をします。
                            <div>
                                <img src="image/settings.png">
                            </div>
                        </li>
                        <li>
                            2.「候補登録」にて購入検討中の商品の情報を登録します。<br>
                            商品登録後、一覧画面下に追加された商品の情報が出ます。<br>
                            こちらで購入前の商品情報の編集削除ができます。
                            <div>
                                <img src="image/registerCommodity.png">
                            </div>
                        </li>
                        <li>
                            3.「購入確定」で購入したい商品を確認します。<br>
                            全選択されており、解除したい商品のみ選択解除します。<br>
                            右下の残高等の情報を確認しよければ確認ボタンを押します。<br>
                            「購入確定」の購入確認ボタン押下後「確定ボタン」を押し商品の購入を確定します。
                            <div>
                                <img src="image/confirm.png">
                            </div>
                        </li>
                        <li>
                            4.「購入履歴」からお買い物履歴を確認できます。セレクトボックスで年と月を絞り込むと便利です。
                            <div>
                                <img src="image/history.png">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>