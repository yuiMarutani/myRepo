<?php 
require_once('Modules/History.Class.php');
require_once('Modules/Settings.Class.php');
require_once('Modules/registerCommodity.Class.php');

session_start();
$Settings = new Settings();

//$user_idをデータベースから取得

$user_id = $Settings->setUserid($_SESSION['user_name'],$_SESSION['password']);
$user_id = $Settings->getUserid();

//1月から12月
$arlist = array();
for($i=1;$i<=12;$i++){
    array_push($arlist,$i);
}

$history = new History();

$regi = new registerCommodity();

$year_get = $history->Year($user_id);
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['monthselect'])){
        $monthselect = htmlspecialchars($_POST['monthselect']);
    }

    if(isset($_POST['yearselect'])){
        $yearselect = htmlspecialchars($_POST['yearselect']);
    }

    if(isset($_POST['condition'])){
        $condition = htmlspecialchars($_POST['condition']);
    }

    if(isset($monthselect) && isset($yearselect)&& isset($condition)){
        //一覧データの取得
        $datalist = $history->datalist($monthselect,$yearselect,$condition,$user_id);
       
        $ar = array();
        //一覧データとcommodity_IDを紐づけてcommodities表から取得
        foreach($datalist as $rec){
            $CID = $rec['commodity_ID'];
            $shoppingnum = $rec['shoppingnum'];
            $commodity_name = $regi->commodityName($CID,$user_id,$shoppingnum);
            $rec['cname'] = $commodity_name;
            array_push($ar,$rec);
        }
    }
}else{
    //postされていないときもテーブルを表示させたい
    $monthselect="";
    $yearselect="";
    $condition=1;
    $datalist = $history->datalist($monthselect,$yearselect,$condition,$user_id);
    $ar = array();
    //一覧データとcommodity_IDを紐づけてcommodities表から取得
    foreach($datalist as $rec){
        $CID = $rec['commodity_ID'];
        $shoppingnum = $rec['shoppingnum'];
        $commodity_name = $regi->commodityName($CID,$user_id,$shoppingnum);
        $rec['cname'] = $commodity_name;
        array_push($ar,$rec);
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

    <main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <div class="container-fluid" style="white-space:nowrap;">

            <div class="row flex-nowrap">

            <div class="container-fluid" style="white-space:nowrap;">
            <div class="row flex-no-wrap">
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
                                        <a href="confirm.php" class="nav-link text-white">
                                            <i class="fs-5 fa fa-check"></i><span class="fs-5">購入確定</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="history.php" class="nav-link text-white active">
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
                <style>
                    /* Default style */
                    .offcanvas {
                        width: 300px; /* Full width by default */
                        max-width: 300px;
                        overflow-x: hidden;
                    }
                  
                </style>


                <!--右サイド-->

                <div class="col py-3">

                    <div class="container-fluid" style="padding:20px;">

                        <div class="row">

                            <div class="col-12">

                                <h2 style="text-align:center;">購入履歴</h2>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3" style="display:flex;justify-content:center;">
                                <form action="" method="post" id="form1" style="display:flex;">
                                    <select name="yearselect" class="form-select" style="width:auto;" id="year" onchange="this.form.submit()">
                                        <option value=""></option>    
                                    <?php foreach ($year_get as $rec){ ?>
                                            <?php if($yearselect==$rec){?>
                                                <option value="<?= $yearselect ?>" selected><?= $yearselect ?></option>
                                            <?php }else{ ?>
                                                <option value="<?= $rec ?>"><?= $rec ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    年
                                    <select name="monthselect" class="form-select custom-select-width" style="width:auto;"id="month" onchange="this.form.submit()">
                                        <option value=""></option>    
                                        <?php foreach($arlist as $rec){ ?>
                                            <?php if($rec==$monthselect){ ?>
                                                <option value="<?=$monthselect?>" selected><?=$monthselect?></option>
                                            <?php }else{?>
                                                <option value="<?=$rec?>"><?=$rec?></option>
                                            <?php }?>
                                        <?php } ?>
                                    </select>
                                    月
                            </div>
                            <div class="col-12 mb-3" style="display:flex;justify-content:center;">
                                    <select name="condition" class="form-select custom-select-width" style="width:auto;"id="condition" onchange="this.form.submit()">
                                    <?php if(isset($condition) && $condition==1){?>
                                            <option value="1" selected>購入済みのみ</option>
                                            <option value="2">購入検討品・購入済み</option>
                                        <?php }elseif(isset($condition) && $condition==2){ ?>
                                            <option value="1">購入済みのみ</option>
                                            <option value="2" selected>購入検討品・購入済み</option>
                                        <?php }else{?>
                                            <option value="1">購入済みのみ</option>
                                            <option value="2" selected>購入検討品・購入済み</option>
                                        <?php }?>
                                    </select>
                                </form>
                            </div>
                        &nbsp;&nbsp;
                        <div class="row">
                            <div class="col-12" style="display:flex;justify-content:center;width:100%;">
                                <button class="btn btn-primary" onclick="location.href='memopad.php'">お買い物ごとのメモ一覧</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <br>
                                <?php if(empty($ar)){?>
                                <p style="text-align:center;">データがありません。</p>
                                <?php }else{?>
                                    <div class="table-responsive-md table-responsive-sm table-responsive-lg table-responsive">
                                        <table class="table table-dark table-striped text-nowrap">
                                            <tr>
                                                <th>何回目</th>
                                                <th>日付</th>
                                                <th>商品名</th>
                                                <th>個数</th>
                                                <th>単価</th>
                                                <th>合計</th>
                                                <th>memo</th>
                                                <th>画像</th>
                                            </tr>
                                            <tr>
                                            <?php foreach($ar as $rec){?>
                                                <td><?=$rec['shoppingnum']?>回目</td>
                                                <td><?=$rec['date']?></td>
                                                <td><?=$rec['cname']?></td>
                                                <td><?=$rec['amount']?> 個</td>
                                                <td><?=$rec['price']?> 円</td>
                                                <td><?=$rec['total']?> 円</td>
                                                <td><?=$rec['memo']?></td>
                                                <td>
                                                    <?php if($rec['image']<>""){?>
                                                        <a href="<?=$rec['image']?>" target="_blank">画像</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php }?>  
                                        </table>
                                    </div>
                                <?php }?>
                                   
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