<?php 
session_start();
print_r($_SESSION);
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
        .search-box {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <header></header>
    <!--main-->
    <main>
        <div class="container-fluid">
            <div class="row flex-no-wrap">
                <div class="bg-dark col-auto col-md-2 min-vh-100">
                    <div class="bg-dark p-2">
                        <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                            <i class="fs-5 fa fa-gauge"></i><span class="fs-4 d-none d-sm-inline">お買い物管理</span>
                        </a>
                        <nav class="nav nav-pills flex-column mt-4">
                            <ul>
                                <li class="nav-item">
                                    <a href="wrapper.php" class="nav-link text-white">
                                        <span class="fs-5 d-none d-sm-inline">アプリ概要</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="settings.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-cog"></i><span class="fs-5 d-none d-sm-inline">設定</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="registerCommodity.php" class="nav-link text-white active">
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
                    <h5>丸谷結衣様</h5>
                    <div class="container" style="padding:20px;">
                        <div class="row  flex-no-wrap">
                            <div class="col"></div>
                            <div class="col">
                                <h3 style="color:red;text-align:center;">確認</h3>
                            </div>
                            <div class="col">
                              
                            </div>
                        </div>
                        <div class="row  flex-no-wrap" style="padding:10px;">
                            <div class="col">
                            </div>
                            <div class="col" style="white-space:nowrap;">
                                <img src="image/vegetables.jpg">
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <div class="row  flex-no-wrap" style="padding:10px;">
                            <div class="col">
                            </div>
                            <div class="col" style="white-space:nowrap;">
                                    <table class="table table-sm table-bordered">
                                        <tr class="table-active table-primary">
                                            <td colspan="2" style="text-align:center;">明細</td>
                                        </tr>
                                        <tr>
                                            <td>商品名</td>
                                            <td>りんご</td>
                                        </tr>    
                                        <tr>
                                            <td>単価</td>
                                            <td>〇円</td>
                                        </tr>
                                        <tr>
                                            <td>数量</td>
                                            <td>〇個</td>
                                        </tr>
                                        <tr>
                                            <td>税率</td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>合計金額</td>
                                            <td>〇円</td>
                                        </tr>
                                    </table>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                        <div class="row  flex-no-wrap">
                            <div class="col">
                            </div>
                            <div class="col" style="text-align:center;">
                                <button type="button" class="btn btn-secondary" onclick="location.href='registerCommodity.php'">戻る</button>
                                <button type="button" class="btn btn-primary" onclick="location.href='registerCommodity.php'">候補確定</button>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                </div>
                <!--右サイド終了-->
            </div>
        </div>
    </main>
</body>
</html>