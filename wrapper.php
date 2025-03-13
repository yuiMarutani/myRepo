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
        <style>
            /* 外部テンプレート無料 specialthanks https://cpp-learning.com/readme/#README-3 */
            /* https://cpp-learning.com/wp-content/uploads/2019/06/README_Template.html */
            /*---------------------------------------------------------------------------------------------
            *  Copyright (c) Microsoft Corporation. All rights reserved.
            *  Licensed under the MIT License. See License.txt in the project root for license information.
            *--------------------------------------------------------------------------------------------*/
            body {
                font-family: "Segoe WPC", "Segoe UI", "SFUIText-Light", "HelveticaNeue-Light", sans-serif, "Droid Sans Fallback";
                font-size: 14px;
                padding: 0 12px;
                line-height: 22px;
                word-wrap: break-word;
            }
        </style>
        <style>
        /* Tomorrow Theme */
        /* http://jmblog.github.com/color-themes-for-google-code-highlightjs */
        /* Original theme - https://github.com/chriskempson/tomorrow-theme */


            /*
            * Markdown PDF CSS
            */

            body {
                font-family:  "Meiryo", "Segoe WPC", "Segoe UI", "SFUIText-Light", "HelveticaNeue-Light", sans-serif, "Droid Sans Fallback";
            }

            pre {
                background-color: #f8f8f8;
                border: 1px solid #cccccc;
                border-radius: 3px;
                overflow-x: auto;
                white-space: pre-wrap;
                overflow-wrap: break-word;
            }

            pre:not(.hljs) {
                padding: 23px;
                line-height: 19px;
            }

            blockquote {
                background: rgba(127, 127, 127, 0.1);
                border-color: rgba(0, 122, 204, 0.5);
            }

            .emoji {
                height: 1.4em;
            }

            /* for inline code */
            :not(pre):not(.hljs) > code {
                color: #C9AE75; /* Change the old color so it seems less like an error */
                font-size: inherit;
            }

            /* Page Break : use <div class="page"/> to insert page break
            -------------------------------------------------------- */
            .page {
                page-break-after: always;
            }
            </style>
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
                        <header style="background-image: linear-gradient(to right, #d4af37, #ffd700, #d4af37);justify-content:left;">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDark" aria-controls="offcanvasDark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5"/>
                                    <path d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194z"/>
                                </svg>
                            </button>
                            <h2 style="color:white;">
                                お買い物管理
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                    <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </h2>
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
                    <div class="row">
                       <div class="col">
                            <h2 id="name%EF%BC%88%E3%83%AA%E3%83%9D%E3%82%B8%E3%83%88%E3%83%AA%E3%83%97%E3%83%AD%E3%82%B8%E3%82%A7%E3%82%AF%E3%83%88oss%E3%81%AA%E3%81%A9%E3%81%AE%E5%90%8D%E5%89%8D%EF%BC%89" style="font-family: sans-serif;text-align:left;">お買い物管理アプリ概要</h1>
                            <p>このアプリではお買い物の履歴の管理やお買い物前の購入の確認ができます。レスポンシブ対応により携帯とパソコンで利用可能。</p>
                            <h2 id="demo" style="font-family: sans-serif;text-align:left;">Environment</h1>
                            <p>言語：PHP 8.3 </p>
                            <p>サーバ：お名前.com</p>
                            <p>データベース: phpMyAdmin(MySQL)</p>
                            <p>その他：Bootstrap5,jQuery,JavaScript,PHPMailer,OPP(オブジェクト指向),PokemonAPI,Compressor.js</p>
                            <h2 id="usage" style="font-family: sans-serif;text-align:left;">Usage</h1>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p>【ご使用方法】<br>
                                    1. 左上灰色のアイコンをタップ、メニューを選びます。<br>
                                    2.「設定」：所持金、消費税、目標金額の設定をします。
                                    所持金とは、お買い物金額の限度の事です。
                                    消費税は一括で登録、「商品候補登録」メニューから商品の個別の設定が可能です。
                                    目標金額とは、金額を抑えたい際に設定します。ない場合は0を設定します。<br>
                                    3.「商品購入登録」：候補になる商品情報を登録します。
                                    登録後トップのフォーム下に購入候補の商品が登録されます。
                                    そちらより商品の編集や削除が行えます。<br>
                                    4.「購入確定」：3.で登録した商品一覧、合計金額、所持金や目標金額との差が確認できます。全選択されている状態
                                    で個別に選択を外すと合計金額等もそれに伴って変化します。確認へ進み、確定を押下後、履歴として登録されます。<br>
                                    5. お買い物履歴：お買い物が確定された商品の履歴が表示されます。メモ等登録情報も確認可能です。
                                </p>
                                </div>
                            </div>
                            
                            <h2 id="features" style="font-family: sans-serif;text-align:left;">Features</h1>
                            <p>子どもからお年寄りまで使用できるように、操作を簡単に開発しました。所持金が少なく外出先で合計金額の計算が微妙な時があったため同じように困っている人の助けになればと思い開発しました。</p>
                            
                            <h2 id="author" style="font-family: sans-serif;text-align:left;">Author</h1>
                            <p>作成者情報</p>
                            <ul>
                            <li>作成者:丸谷結衣</li>
                            <li>所属:個人</li>
                            </ul>
                            <h2 id="license" style="font-family: sans-serif;text-align:left;">License</h1>
                            <p>LGPL 2.1 license</p>
                            <p>for public use</p>
                       </div>
                        <!--row終わり-->
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>