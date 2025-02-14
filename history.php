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
        <div class="container-fluid" style="white-space:nowrap;">
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
                                    <a href="history.php" class="nav-link text-white active">
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
                    <h5><?php echo $_SESSION['user_name'];?>様</h5>
                    <div class="container-fluid" style="padding:20px;">
                        <div class="row">
                            <div class="col ">
                                <h2 style="text-align:left;">購入履歴</h2>
                            </div>
                            <div class="col">
                              
                            </div>
                            <div class="col">
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="display:flex;">
                                <select class="form-select custom-select-width">
                                    <option>2010</option>
                                    <option>2010</option>
                                    <option>2010</option>
                                    <option>2010</option>
                                    <option>2010</option>
                                    <option>2010</option>
                                </select>
                                年
                            </div>
                            <div class="col" style="display:flex;" >
                                <select class="form-select custom-select-width">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    月
                              
                            </div>
                            <div class="col">
                              
                            </div>
                            <div class="col">
                              
                            </div>
                            <div class="col">
                              
                            </div>
                            <div class="col">
                              
                            </div>
                            <div class="col">
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                
                            </div>
                            <div class="col">
                                <br>
                                <form>
                                    <div class="table-responsive-md table-responsive-sm table-responsive-lg table-responsive">
                                        <table class="table table-dark table-striped text-nowrap">
                                            <tr>
                                                <th>何回目</th>
                                                <th>日付</th>
                                                <th>商品名</th>
                                                <th>個数</th>
                                                <th>単価</th>
                                                <th>合計</th>
                                                <th>残高</th>
                                                <th>memo</th>
                                                <th>削除</th>
                                            </tr>
                                            <tr>
                                                <td rowspan="5">1回目</td>
                                                <td>2010-10-10</td>
                                                <td>りんご</td>
                                                <td>2個</td>
                                                <td>100円</td>
                                                <td>200円</td>
                                                <td>30円</td>
                                                <td>個数が足りなかった</td>
                                                <td><input type="submit" value="削除"></td>
                                            </tr>
                                            <tr>
                                                <td>2010-10-10</td>
                                                <td>りんご</td>
                                                <td>2個</td>
                                                <td>100円</td>
                                                <td>200円</td>
                                                <td>30円</td>
                                                <td>個数が足りなかった</td>
                                                <td><input type="submit" value="削除"></td>
                                            </tr>
                                            <tr>
                                                <td>2010-10-10</td>
                                                <td>りんご</td>
                                                <td>2個</td>
                                                <td>100円</td>
                                                <td>200円</td>
                                                <td>30円</td>
                                                <td>個数が足りなかった</td>
                                                <td><input type="submit" value="削除"></td>
                                            </tr>
                                            <tr>
                                                <td>2010-10-10</td>
                                                <td>りんご</td>
                                                <td>2個</td>
                                                <td>100円</td>
                                                <td>200円</td>
                                                <td>30円</td>
                                                <td>個数が足りなかった</td>
                                                <td><input type="submit" value="削除"></td>
                                            </tr>
                                            <tr>
                                                <td>2010-10-10</td>
                                                <td>りんご</td>
                                                <td>2個</td>
                                                <td>100円</td>
                                                <td>200円</td>
                                                <td>30円</td>
                                                <td>個数が足りなかった</td>
                                                <td><input type="submit" value="削除"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </form>
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