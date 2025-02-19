<?php 
session_start();
print_r($_SESSION);
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
        <div class="container-fluid" style="white-space:nowrap;">
            <div class="row flex-nowrap">
                <div class="bg-dark col-auto col-md-3 min-vh-100">
                    <div class="bg-dark p-2">
                        <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                            <i class="fs-5 fa fa-gauge"></i><span class="fs-4 d-none d-sm-inline">お買い物管理</span>
                        </a>
                        <nav class="nav nav-pills flex-column mt-4">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="wrapper.php" class="nav-link text-white">
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
                                    <a href="confirm.php" class="nav-link text-white active">
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
                <!--右サイド-->
                <div class="col py-3">
                    <h5><?php echo $_SESSION['user_name'];?>様</h5>
                    <div class="container" style="padding:20px;">
                        <div class="row flex-no-wrap">
                            <div class="col"></div>
                            <div class="col" style="min-width:550px;">
                                <h3 style="text-align:center;">購入選択</h3>
                                <span>全選択されている状態です。選択解除するもののみ選択ボタンを押してください。</span>
                            </div>
                            <div class="col">
                              
                            </div>
                        </div>
                        <div class="row my-4" style="width:100%;">
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0" style="display:flex;justify-content:center;">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="image/apple.jpeg" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text" style="">
                                            <!--quick start-->
                                            <table class="table table-sm">
                                                <tr>
                                                    <th style="text-align:right;">商品名</th>
                                                    <td>りんご</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">単価</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">数量</th>
                                                    <td>〇個</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">税率</th>
                                                    <td>〇%</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">合計</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;">
                                                        <input type="checkbox" class="btn-check" id="btn-check-1-outlined" checked autocomplete="off">
                                                        <label class="btn btn-outline-danger" for="btn-check-1-outlined">選択</label><br>
                                                    </td>
                                                </tr>
                                            </table>    
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0" style="display:flex;justify-content:center;">
                                <div class="card"  style="width: 18rem;">
                                    <img class="card-img-top" src="image/apple.jpeg" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text" style="">
                                            <!--quick start-->
                                            <table class="table table-sm">
                                                <tr>
                                                    <th style="text-align:right;">商品名</th>
                                                    <td>りんご</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">単価</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">数量</th>
                                                    <td>〇個</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">税率</th>
                                                    <td>〇%</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">合計</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;">
                                                        <input type="checkbox" class="btn-check" id="btn-check-2-outlined" checked autocomplete="off">
                                                        <label class="btn btn-outline-danger" for="btn-check-2-outlined">選択</label><br>
                                                    </td>
                                                </tr>
                                            </table>    
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0" style="display:flex;justify-content:center;">
                                <div class="card"  style="width: 18rem;">
                                    <img class="card-img-top" src="image/apple.jpeg" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text">
                                            <!--quick start-->
                                            <table class="table table-sm">
                                                <tr>
                                                    <th style="text-align:right;">商品名</th>
                                                    <td>りんご</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">単価</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">数量</th>
                                                    <td>〇個</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">税率</th>
                                                    <td>〇%</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">合計</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;">
                                                        <input type="checkbox" class="btn-check" id="btn-check-3-outlined" checked autocomplete="off">
                                                        <label class="btn btn-outline-danger" for="btn-check-3-outlined">選択</label><br>
                                                    </td>
                                                </tr>
                                            </table>    
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0" style="display:flex;justify-content:center;">
                                <div class="card"  style="width: 18rem;">
                                    <img class="card-img-top" src="image/apple.jpeg" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text" style="">
                                            <!--quick start-->
                                            <table class="table table-sm">
                                                <tr>
                                                    <th style="text-align:right;">商品名</th>
                                                    <td>りんご</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">単価</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">数量</th>
                                                    <td>〇個</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">税率</th>
                                                    <td>〇%</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:right;">合計</th>
                                                    <td>〇円</td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;">
                                                        <input type="checkbox" class="btn-check" id="btn-check-4-outlined" checked autocomplete="off">
                                                        <label class="btn btn-outline-danger" for="btn-check-4-outlined">選択</label><br>
                                                    </td>
                                                </tr>
                                            </table>    
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <!--row終了-->
                        </div>
                        <!--card終了-->
                        <!--合計額算出-->
                       <div style="display:flex;justify-content:right;">
                            <!--form開始-->
                            <form>     
                                <table class="table table-striped">
                                    <tr>
                                        <th><font size="5">合計</font></th>
                                        <td><font size="5">〇円</font></td>
                                    </tr>
                                    <tr>
                                        <th><font size="5">登録金額との残高</font></th>
                                        <td><font size="5">〇円</font></td>
                                    </tr>
                                    <tr>
                                        <th><font size="5">目標金額との残高</font></th>
                                        <td><font size="5">〇円</font></td>
                                    </tr>
                                    <tr>
                                        <td width="300">
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label"><font size="3">メモ</font></label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="10"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;">
                                            <button type="button" class="btn btn-warning" onclick="location.href='registerConfirm.php'">確認</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <!--form終了-->
                        </div>     
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>