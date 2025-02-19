<?php 
session_start();
require_once('Modules/registerCommodity.Class.php');

print_r($_POST);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $amount = htmlspecialchars($_POST['amount']);
    $tax = htmlspecialchars($_POST['tax']);
    $memo = htmlspecialchars($_POST['memo']);
    //画像のディレクトリ
    if(isset($_POST['image_dir'])){
        $image_dir = htmlspecialchars($_POST['image_dir']);
    }

    if(isset($_POST['image'])){
        $image = htmlspecialchars($_POST['image']);
    }
    
    $registerC = new registerCommodity();

    //合計金額
    $total = $registerC->Total($price,$tax,$amount); 

    //戻るボタンが押されたとき
    if(isset($_POST['back'])){
        $back = htmlspecialchars($_POST['back']);
    }

    if(isset($back)){
        //headerで戻る
        $_SESSION['name'] = $name;
        $_SESSION['price'] = $price;
        $_SESSION['amount'] = $amount;
        $_SESSION['tax'] = $tax;
        $_SESSION['image'] = $image;
        $_SESSION['memo'] = $memo;
        $name = $_SESSION['name'];
        $price =  $_SESSION['price'];
        $amount = $_SESSION['amount'];
        $tax = $_SESSION['tax'];
        if(isset($image_dir)){
            $_SESSION['image_dir'] = $image_dir;
        }

        $memo = $_SESSION['memo'];
        $_SESSION['back'] = 1; //戻るボタンのフラグ
        header('location:registerCommodity.php');
        exit();
    }

}
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
                            <?php if(isset($image_dir)){ ?>
                                <img src="<?=$image_dir?>" alt="画像"><br>
                            <?php } ?>
                                
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
                                            <td><?=$name?></td>
                                        </tr>    
                                        <tr>
                                            <td>単価</td>
                                            <td><?=$price?>&nbsp;&nbsp;円</td>
                                        </tr>
                                        <tr>
                                            <td>数量</td>
                                            <td><?=$amount?>&nbsp;&nbsp;個</td>
                                        </tr>
                                        <tr>
                                            <td>税率</td>
                                            <td><?=$tax?>&nbsp;&nbsp;%</td>
                                        </tr>
                                        <tr>
                                            <td>合計金額</td>
                                            <td><?=$total?>&nbsp;&nbsp;円</td>
                                        </tr>
                                        <tr>
                                            <td>memo</td>
                                            <td style ="whitespace:nowrpa;"><?=$memo?></td>
                                        </tr>
                                    </table>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                        <div class="row  flex-no-wrap">
                            <div class="col">
                            </div>
                            <div class="col" style="text-align:center;display:flex;justify-content:center;">
                                <form action="" method="post" id="form1">
                                    <input type="hidden" name="name" value="<?=$name ?>" id="hidden1" name="myform">
                                    <input type="hidden" name="tax" value="<?=$tax ?>" id="hidden2">
                                    <input type="hidden" name="amount" value="<?=$amount ?>" id="hidden3">
                                    <input type="hidden" name="price" value="<?=$price ?>" id="hidden4">
                                    <input type="hidden" name="memo" value="<?=$memo ?>" id="hidden6">
                                    <?php if(isset($image_dir)){?>
                                        <input type="hidden" name="image_dir" value="<?=$image_dir ?>" id="hidden7">
                                    <?php }?>
                                    <?php if(isset($image)){?>
                                        <input type="hidden" name="image" value="<?=$image ?>" id="hidden8">
                                    <?php }?>
                                    <button type="submit" name="back" id="button1" class="btn btn-secondary" value="1">戻る</button>
                                </form>&nbsp;
                              
                                <form action="confirm.php" method="post">
                                    <input type="hidden" name="name" value="<?=$name ?>">
                                    <input type="hidden" name="tax" value="<?=$tax ?>">
                                    <input type="hidden" name="amount" value="<?=$amount ?>">
                                    <input type="hidden" name="price" value="<?=$price ?>">
                                    <input type="hidden" name="memo" value="<?=$memo ?>">
                                    <button type="submit" name="confirm" class="btn btn-primary" onclick="location.href='registerCommodity.php'">候補確定</button>
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