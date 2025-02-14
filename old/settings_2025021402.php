<?php 
require_once('Modules/User.Class.php');
require_once('Modules/Authentification.Class.php');
require_once('Modules/Settings.Class.php');

session_start();
print_r($_SESSION);
//今日の日付
$date = new DateTime('now');
$today = $date->format('Y年m月d日');
//$user_idをデータベースから
$settings = new Settings();
$user_id = $settings->setUserid($_SESSION['user_name'],$_SESSION['password']);
$user_id = $settings->getUserid();
print_r($user_id);
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
                                    <a href="settings.php" class="nav-link text-white active">
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
                    <h5><?php echo $_SESSION['user_name'];?>様</h5>
                    <span><?php echo $today;?></span><br>
                    <span>〇回目のお買い物</span>
                    <div class="container" style="padding:20px;">
                        <div class="row  flex-no-wrap">
                            <div class="col"></div>
                            <div class="col">
                                <h3>金額の登録設定</h3>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                        <div class="row  flex-no-wrap">
                            <div class="col">
                              
                            </div>
                            <div class="col" style="padding:100px;">
                            <form>
                                <table class="table table-borderless" style="white-space:nowrap;">
                                    <tr>
                                        <td><font style="color:red;">所持金、目標金額、消費税の設定をお願いします。</font></td>
                                    </tr>
                                    
                                        <tr>
                                            <td><span style="color:red;">※</span>所持金を登録する（必須）</td>
                                            <td><input type="text">&nbsp;円</td>
                                        </tr>
                                        <tr>
                                            <td>目標金額の設定（任意）</td>
                                            <td><input type="text">&nbsp;円</td>
                                        </tr>
                                        <tr>
                                            <td><span style="color:red;">※</span>消費税額の設定</td>
                                            <td>
                                                <select style="width:60px;">
                                                    <option>5%</option>
                                                    <option>6%</option>
                                                    <option>7%</option>
                                                    <option>8%</option>
                                                    <option>9%</option>
                                                    <option>10%</option>
                                                    <option>11%</option>
                                                    <option>12%</option>
                                                    <option>13%</option>
                                                    <option>14%</option>
                                                    <option>15%</option>
                                                    <option>16%</option>
                                                    <option>17%</option>
                                                    <option>18%</option>
                                                    <option>19%</option>
                                                    <option>20%</option>
                                                    <option>21%</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button type="button" class="btn btn-primary">登録</button></td>
                                        </tr>
                                        
                                </table>
                            </form>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>