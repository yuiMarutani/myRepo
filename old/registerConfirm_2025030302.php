<?php 
require_once('Modules/Confirm.Class.php');
session_start();


if($_SERVER['REQUEST_METHOD']=='POST'){
    // POSTされたデータを取得（変動するデータも含む）
    $postData = $_POST;
    if(isset($_POST['memopad'])){
        $memopad = htmlspecialchars($_POST['memopad']);
    }

    $dlist = array();
    // 数字のキーを持つデータのみを処理
    foreach ($postData as $key => $value) {
        if (is_numeric($key)) {
            // htmlspecialcharsを適用して出力
            $indexvalue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            //フィルタしたindexvalueとキーを配列にする
            if($value==1){
                //値が1のindex配列を配列にまとめる
                array_push($dlist,$key);
            }
        }
    }
    $arlist = array();
    foreach($dlist as $rec){
        $order_id = $rec;//orderidの番号を取得
        $Conf = new Confirm();
        $getDatalist = $Conf->getDatalist($order_id);
        array_push($arlist,$getDatalist);
    }
}

$arlist2 = array();
foreach($arlist as $mec){
    $CID = $mec['commodity_ID'];
    $order_id = $mec['order_id'];
    $user_id = $mec['user_id'];
    $tax = $mec['tax'];
    $amount = $mec['amount'];
    $price = $mec['price'];
    $total = $mec['total'];
    $image = $mec['image'];
    $purchased = $mec['purchased'];
    $shoppingnum = $mec['shoppingnum'];
    $memo = $mec['memo'];
    $commodityName = $Conf->commodityName($CID,$user_id,$shoppingnum);
    $mec['commodityName'] = $commodityName;
    $mec['price'] = $price;
    $mec['amount'] = $amount;
    $mec['total'] = $total;
    $mec['image'] = $image;
    $mec['memo'] = $memo;

    array_push($arlist2,$mec);
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
                                    <a href="registerCommodity.php" class="nav-link text-white">
                                        <i class="fs-5 fa fa-registered"></i><span class="fs-5 d-none d-sm-inline">候補登録</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="confirm.php" class="nav-link text-white active">
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
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <h3 style="text-align:center;">購入品の確認</h3>
                            </div>
                            <div class="col">
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <div class="container" style="justify-content:center;">
                                    <table class="table table-dark table-hover table-responsive text-nowrap" style="">
                                        <tr>
                                            <th>品名</th>
                                            <th>単価</th>
                                            <th>数量</th>
                                            <th>税率</th>
                                            <th>画像</th>
                                            <th>合計金額（税込み）</th>
                                        </tr>
                                        <?php foreach($arlist2 as $rec){?>
                                        <tr>
                                            <td><?=$rec['commodityName']?></td>
                                            <td><?=$rec['price']?></td>
                                            <td><?=$rec['amount']?></td>
                                            <td><?=$rec['tax']?></td>
                                            <td><a href="<?=$rec['image']?>" target="_blank">画像</a></td>
                                            <td><?=$rec['total']?>円</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    <?php if(isset($memopad)){?>
                                        <p>【メモ】<?=$memopad ?></p>
                                    <?php } ?>
                                    <div class="mb-3" style="text-align:center;">
                                        <button type="button" class="btn btn-secondary" onclick="location.href='confirm.php'">戻る</button>
                                        <button type="button" class="btn btn-success" onclick="location.href='confirm.php'">確定</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>