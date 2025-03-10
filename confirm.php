<?php 

session_start();
require_once('Modules/Confirm.Class.php');
require_once('Modules/Settings.Class.php');
//セッション切れリダイレクト

if(isset($_SESSION) && empty($_SESSION)){

    header('Location: https://marutani098723.com/new_app/login.php');

}

$Conf = new Confirm();
$user_id = $Conf->setUserid($_SESSION['user_name'],$_SESSION['password']);
$user_id = $Conf->getUserid();
//お買い物回数の算出

$shoppingnum = $Conf->shoppingNum($user_id);
$dlist = $Conf->getData($user_id,$shoppingnum);

//確定後のエラー回避
if(!empty($dlist)){
    $ar = array();
    foreach($dlist as $k=>$v){
        $cid =  $v['commodity_ID'];
        $CName = $Conf->commodityName($cid,$user_id,$shoppingnum);
        $v['name'] = $CName;
        array_push($ar,$v);
    }
    
    //所持金と目標金額の取得
    $Settings = new Settings();
    $dataGet = $Settings->dataGet($user_id,$shoppingnum);
    if(isset($dataGet)){
        if($dataGet[0]<>""){
            $earnings = $dataGet[0];
        }
        if($dataGet[1]<>""){
            $goal = $dataGet[1];
        }
        //所持金がないとき、アラートを出し、設定の方から設定するよう呼びかけ
        if($earnings==0){
            $alert = "所持金が登録されていません。「設定」メニューから登録し直して下さい。";
        }
       
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['return'])){
            $return = htmlspecialchars($_POST['return']);
        }
        if(isset($_POST['confirm'])){
            $confirm = htmlspecialchars($_POST['confirm']);
        }
        if(isset($_POST['memopad'])){
            $memopad = htmlspecialchars($_POST['memopad']);
        }
        $postData = $_POST;

        if(isset($confirm)){
            //memopadテーブルにメモを追加
            $verify_insert = $Conf->verify_insert_memo($user_id,$shoppingnum,$memopad);
            if($verify_insert == 0){
                $insertmemopad = $Conf->insertMemo($user_id,$shoppingnum,$memopad);
            }
            
            $dlist2 = array();
            //ordersテーブルの更新
            foreach($postData as $k=>$v){
                if (is_numeric($k)) {
                    // htmlspecialcharsを適用して出力
                    $indexvalue = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        
                    //フィルタしたindexvalueとキーを配列にする
                    //値が1のindex配列を配列にまとめる
                    array_push($dlist2,$k);
                }
            }

            foreach($dlist2 as $mec){
            //$mecはorder_id
                $updatepurchase = $Conf->updatePurchase($shoppingnum,$mec); 
            }
        }
    }
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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <header></header>
    <!--main-->
    <main>
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
                <div class="col-12 py-3">
                    <div class="container" style="padding:20px;">
                        <div class="row flex-no-wrap">
                            <div style="display:flex;justify-content:center;">
                                <h3>購入選択・購入確定</h3>
                            </div>
                        </div>
                    <?php if(!empty($dlist)){?>
                        <div class="row flex-wrap">
                        <?php if(isset($return)){?>
                            <div class="col-4"></div>
                            <div class="alert alert-danger col-4" role="alert" style="text-align:center;width:auto;">
                                お手数ですが、もう一度選択し直して下さい。
                            </div>
                            <div class="col-4"></div>
                        <?php }?>
                        <div class="col-12" style="justify-content:center;display:flex;">
                                <span>全選択されている状態です。</span>
                            </div>
                            <div class="col-12" style="justify-content:center;display:flex;">
                                <span>選択解除するもののみ選択し直して下さい。</span>
                            </div>
                        </div>
                    <!--form-->
                    <form action="registerConfirm.php" method="post">
                        <div class="row my-4" style="width:100%;">
                            <div class="col">
                                <div class="swiper-container swiper-name">
                                <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper">
                                    <!-- Slides -->
                                        <?php foreach($ar as $k=>$v){ ?>
                                            <!--slider-->
                                            <div class="swiper-slide">
                                                <!--card-->
                                                <div class="card" style="width: 18rem;">
                                                    <img class="card-img-top" src="<?=$v['image']?>" alt="no image">
                                                    <!--cardbody-->
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            <!--quick start-->
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <th style="text-align:right;">商品名</th>
                                                                    <td><?=$v['name'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right;">単価</th>
                                                                    <td><?=$v['price']?>円</td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right;">数量</th>
                                                                    <td><?=$v['amount']?>個</td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right;">税率</th>
                                                                    <td><?=$v['tax'] ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right;">メモ</th>
                                                                    <td><?=$v['memo'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align:right;">合計</th>
                                                                    <td><?=$v['total'] ?>円</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" style="text-align:center;">
                                                                        <input type="checkbox" data-check="<?=$v['order_id']?>" name="check" class="btn-check" id="btn-check-1-outlined<?=$v['order_id']?>" checked value="<?=$v['total'] ?>" onclick="calculateTotal(<?=$v['order_id']?>)">
                                                                        <label class="btn btn-outline-danger" for="btn-check-1-outlined<?=$v['order_id']?>">選択</label><br>
                                                                        <input type="hidden" id="flag-<?=$v['order_id']?>" name="<?=$v['order_id']?>" value="1">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </p>
                                                    <!--cardbodyends-->
                                                    </div>
                                                    <!--cardends-->
                                                </div>
                                                <!--sliderends-->
                                            </div>
                                        <?php } ?>
                                        <!--slides-->
                                    </div>
                                    <!-- If we need navigation buttons -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <!--additional info-->
                                </div>
                                <script>
                                    const swiper = new Swiper('.swiper-name', {
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                    // スライドの表示枚数：500px未満の場合
                                    slidesPerView: 1,
                                    breakpoints: {
                                        // スライドの表示枚数：500px以上の場合
                                        500: {
                                        slidesPerView: 3,
                                        }
                                    }

                                    });
                                </script>
                                <!--colends-->
                            </div>
                            &nbsp;
                            <div>
                                <!--エラーメッセージ-->
                                <p id="error_1" style="color:red;display:flex;justify-content:center;"></p>
                                <p id="error_2" style="color:red;display:flex;justify-content:center;"></p>
                                <p id="error_3" style="color:green;display:flex;justify-content:center;"></p>
                                <p id="error_4" style="color:green;display:flex;justify-content:center;"></p>
                                <?php if(isset($alert)){?>
                                    <div style="display:flex;justify-content:center; margin: 0 auto;white-space:wrap;">
                                        <div class="alert alert-warning" role="alert" >
                                            <?=$alert?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--合計額算出-->
                            <div  class="py-3 col-12" style="display:flex;justify-content:center;">
                                <table class="table table-striped table-sm" style="width:auto;">
                                    <tr>
                                        <?php if(isset($earnings)){?>
                                        <th><font size="5">所持金</font></th>
                                        <td style="text-align:right;font-size:25px;"><font size="5" id="earnings"><?=$earnings?></font>円</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php if(isset($goal)){ ?>
                                        <th><font size="5">目標金額</font></th>
                                        <td style="text-align:right;font-size:25px;"><font size="5" id="goal"><?=$goal?></font>円</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th><font size="5">合計</font></th>
                                        <div>
                                            <td style="font-size:25px;text-align:right;"><span id="total" style="font-size:25px;"></span>円</td>
                                        </div>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-12" style="display:flex;justify-content:center;">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label"><font size="3">メモ</font></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="memopad" style="width:auto;"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div style="justify-content:center;display:flex;">
                                    <button type="submit" class="btn btn-warning" onclick="location.href='registerConfirm.php'" id="confirmButton">確認</button>
                                </div>
                            </div>
                            <script>
                                //合計金額の算出
                                function calculateTotal(orderId) {
                                const checkboxes = document.querySelectorAll('input[name="check"]');
                                let total = 0;

                                checkboxes.forEach((checkbox) => {
                                    if (checkbox.checked) {
                                        total += parseFloat(checkbox.value);
                                    }
                                    updateFlag(checkbox.dataset.check);
                                });

                                document.getElementById('total').innerText = total;

                                const earnings = parseFloat(document.getElementById('earnings').innerText.replace('円', ''));
                                const goal = parseFloat(document.getElementById('goal').innerText.replace('円', ''));

                                // Check if total exceeds earnings
                                if (earnings - total < 0) {
                                    const money = total - earnings;
                                    document.getElementById('error_1').innerText = money + "円合計金額が所持金を超えています。";
                                } else {
                                    document.getElementById('error_1').innerText = "";
                                }

                                // Check if total exceeds goal
                                if (goal - total < 0) {
                                    const money = total - goal;
                                    document.getElementById('error_2').innerText = money + "円合計金額が目標金額を超えています。";
                                } else {
                                    document.getElementById('error_2').innerText = "";
                                }

                                // Check if earnings are sufficient
                                if (earnings - total >= 0) {
                                    const money = earnings - total;
                                    document.getElementById('error_3').innerText = "所持金残り" + money + "円です";
                                } else {
                                    document.getElementById('error_3').innerText = "";
                                }

                                // Check if goal is sufficient
                                if (goal - total >= 0) {
                                    const money = goal - total;
                                    document.getElementById('error_4').innerText = "目標金額まで残り" + money + "円です";
                                } else {
                                    document.getElementById('error_4').innerText = "";
                                }
                                
                                const confirmButton = document.getElementById('confirmButton');
                                if (document.getElementById('error_1').innerText=="") {
                                    confirmButton.disabled = false;
                                }else{
                                    confirmButton.disabled = true;
                                }

                            }

                            //クリックされたか、されてないかをorder_idで判別
                            function updateFlag(orderId) {
                                const checkbox = document.getElementById(`btn-check-1-outlined${orderId}`);
                                const hiddenInput = document.getElementById(`flag-${orderId}`);
                                hiddenInput.value = checkbox.checked ? "1" : "0";
                            }

                                // Add event listeners to checkboxes
                                document.querySelectorAll('input[name="check"]').forEach((checkbox) => {
                                    checkbox.addEventListener('change', () => calculateTotal(checkbox.dataset.check));
                                });

                                // Initial calculation
                                calculateTotal();
                            </script>
                        </div> 
                        <div class="col-4"></div>    
                    </div>
                </form>
            </div>
            <?php }else{ ?>
                <p style="display:flex;justify-content:center;">登録がありません。</p>
            <?php } ?>
        </div>
    </div>
</main>
</body>
</html>