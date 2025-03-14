<?php 

session_start();
require_once('Modules/registerCommodity.Class.php');

//セレクトボックス値作成（taxの作成）
$arlist = array();

for($i=5;$i<=20;$i++){

    array_push($arlist,$i);

}

//セレクトボックス値（settingsテーブルで一括設定したtax値の取得）

$registerC = new registerCommodity();

//$user_idをデータベースから取得

$user_id = $registerC->setUserid($_SESSION['user_name'],$_SESSION['password']);

$user_id = $registerC->getUserid();



//お買い物回数の算出

$shoppingnum = $registerC->shoppingNum($user_id);



//データの登録があるかないか

$dataVerify = $registerC->dataVerify($user_id,$shoppingnum);

if($dataVerify>0){

    //データの登録あるとき

    $tax = $registerC->getTaxData($user_id,$shoppingnum);
}


if($_SERVER['REQUEST_METHOD']=='POST'){

    //商品登録後編集ボタンが押された時
    if(isset($_POST['edit'])){
        $edit = htmlspecialchars($_POST['edit']);
    }

    if(isset($_POST['cid'])){
        $cid = htmlspecialchars($_POST['cid']);
    }

    if(isset($_POST['order_id'])){
        $order_id = htmlspecialchars($_POST['order_id']);
    }

    //更新した時
    if(isset($_POST['update'])){
        $update = htmlspecialchars($_POST['update']);
    }

    if(isset($_POST['name'])){
        $name = htmlspecialchars($_POST['name']);
    }

    if(isset($_POST['price'])){
        $price = htmlspecialchars($_POST['price']);
    }

    if(isset($_POST['amount'])){
        $amount = htmlspecialchars($_POST['amount']);
    }

    if(isset($_POST['tax'])){
        $tax = htmlspecialchars($_POST['tax']);
    }

    if(isset($_POST['delete'])){
        $delete = htmlspecialchars($_POST['delete']);
    }
    if(isset($_POST['memo'])){
        $memo = htmlspecialchars($_POST['memo']);
    }

    if(isset($_POST['uploadTime'])){
        $uploadTime = htmlspecialchars($_POST['uploadTime']);
    }

    if(isset($_POST['image'])){
        $image = htmlspecialchars($_POST['image']);
    }else{
        if(isset($edit)||isset($delete)){
            $image = ""; //画像はimage_dirに入っている
        }else{
            $image = $_FILES['image']['name'];
        }
    }

    //検索ボタンが押された時
    if(isset($_POST['search'])){
        $search = htmlspecialchars($_POST['search']);
    }

    //検索値
    if(isset($_POST['name2'])){
        $name2 = htmlspecialchars($_POST['name2']);
    }

    //検索値がセレクトされたとき
    if(isset($_POST['kensaku'])){
        $kensaku = htmlspecialchars($_POST['kensaku']);
        if(isset($kensaku)){
            //データを取得（$kensakuはcommodity_ID）
            $kensaku_data = $registerC->kensakuData($kensaku,$user_id);
            foreach($kensaku_data as $v){
                $tax = $v['tax'];
                $amount = $v['amount'];
                $price = $v['price'];
                $total = $v['total'];
                $memo = $v['memo'];
                $name = $registerC->kensakuName($kensaku,$user_id);
            }
        }
    }else{
        //検索が押された場合の処理
        if(isset($search) && isset($name2)){
            //検索絞り込み
            $kensaku = $registerC->kensaku($name2,$user_id);
            //情報の取得
        }
    }


    if(isset($_POST['cancel'])){

        $_FILES = array();

        $cancel = htmlspecialchars($_POST['cancel']);

        if(isset($_POST['image_dir'])){

            $_POST['image_dir']="";

            $_POST['uploadTime']="";

        }

    }

    //イメージ画像の写真がアップされていたら

    if(isset($image) && $image!==""){

        //イメージをuploadsフォルダへ移動

        $movefile = $registerC->uploadImage($image);

            //画像を生成後、ディレクトリ含むパスを生成

        $image_dir = 'https://marutani098723.com/new_app/'.$movefile;

    }else{

        //バリデーションをミスした時、postでimage_dirが渡っている

        if(isset($_POST['image_dir'])){
            $image_dir = htmlspecialchars($_POST['image_dir']);
        }
        //始めから画像を渡せたときはpostの時間がアップロード時間のため、input type hidden でその時間を渡している

    }


    //確認ボタンが押された時

    if(isset($_POST['submitC'])){

        $submitC = htmlspecialchars($_POST['submitC']);

    }

    

    //エラーバリデーション
    //編集の時は使用しない
    if(!isset($edit)){
        list($error_1,$error_2,$error_3) = $registerC->validateCommodity($name,$price,$amount);
    }

    //画像バリデーション

    if(!empty($_FILES['image']['name'])){

        $error_4 = $registerC->validateFile();

    }



    //画像キャンセルで送信されないように、確認ボタンがおされてから条件追加

    if(isset($submitC)){

        if(empty($error_4)){

            //エラーなかったらconfirmCommodity.phpへ遷移

            if(isset($error_1) && $error_1=="" && isset($error_2) && $error_2 =="" && isset($error_3) && $error_3=="" ){

                header('location:confirmCommodity.php',true,308);

            }

        }

    }

    //商品編集ボタンが押された時の処理
    if(isset($edit)){
        $error_1="";
        $error_2="";
        $error_3="";
        //orderの特定
        
        $get_edit = $registerC->edit($cid,$order_id,$user_id,$shoppingnum);
        $tax = $get_edit['tax'];
        $amount = $get_edit['amount'];
        $price = $get_edit['price'];
        $total = $get_edit['total'];
        $image_dir = $get_edit['image'];
        $image = "";
        $memo = $get_edit['memo'];
    }
    
    //ボタンが押された時の処理
    if(isset($update)){
        if(!empty($_FILES['image']['name'])){
            $uploadTime = date('YmdHis', $uploadTime);
            $image_dir = "https://marutani098723.com/new_app/uploads/".$uploadTime. "_".$_FILES['image']['name'];
        }else{
            $image_dir = $image_dir;
        }

        $update = $registerC->updateCommodities($name,$price,$amount,$tax,$memo,$image_dir,$order_id,$cid,$shoppingnum,$user_id);
        $message_2 = "更新しました。";
        $_SESSION['message_2'] = $message_2;
        header('location:registerCommodity.php');
        exit();
    }

}
//商品登録一覧を表示する
$commodities = $registerC->getCommodities($user_id,$shoppingnum);
$dlist = array();

foreach($commodities as $k=>$v){
    $CID = $v['commodity_ID'];
    $order_id = $v['order_id'];
    //shoppingnumがなかったら、新に挿入する
    $CName = $registerC->commodityName($CID,$user_id,$shoppingnum);
    $value['cid'] = $CID;
    $value['cname'] = $CName;
    $value['order_id'] = $order_id;
    array_push($dlist,$value);
}

//戻るボタンで返ってきたとき

if(isset($_SESSION['name'])){

    $name = $_SESSION['name'];

    unset($_SESSION['name']);

}

if(isset($_SESSION['price'])){

    $price = $_SESSION['price'];

    unset($_SESSION['price']);

}

if(isset($_SESSION['amount'])){

    $amount = $_SESSION['amount'];

    unset($_SESSION['amount']);

}

if(isset($_SESSION['tax'])){

    $tax = $_SESSION['tax'];

    unset($_SESSION['tax']);

}



if(isset($_SESSION['memo'])){

    $memo = $_SESSION['memo'];

    unset($_SESSION['memo']);

}

//商品を登録しました。メッセージ
if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
}


if(isset($_SESSION['back'])){
    $again_msg = "お手数ですが、<br>もう一度画像をアップロードして下さい。";
}

//削除が押された時の処理
if(isset($delete)){
    $price = "";
    //ordersテーブルをdel_flg=1にする
    $order_id = htmlspecialchars($_POST['order_id']);
    $delete_db = $registerC->deleteData($order_id);
    $name = ""; //nameが入力されてしまうため、空にする
    $error_1 = "";
    $error_2 = "";
    $error_3 = "";
    $error_4 = "";
    $_SESSION['message_2']="正常に削除しました。";
    header('location:registerCommodity.php');
    exit();
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
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <header></header>

    <main>

    <!--jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <div class="container-fluid" style="white-space:nowrap;">

            <div class="row flex-nowrap">
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
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
                                        <a href="registerCommodity.php" class="nav-link text-white active">
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

                    <div class="container" style="padding:20px;">

                        <div class="row">

                            <div class="col"></div>

                            <div class="col">
                                <?php if(isset($_SESSION['message'])){?>
                                    <div class="alert alert-success" role="alert">
                                        <?=$_SESSION['message']?>
                                        <?php unset($_SESSION['message']); ?>
                                    </div>
                                <?php }?>
                                <h3>商品候補登録</h3>
                            </div>

                            <div class="col">

                                

                            </div>

                        </div>

                        <div class="row" style="padding:10px;">

                            <div class="col-md-4">

                                

                              

                            </div>

                            <div class="col-md-4" style="white-space:nowrap;"> 

                            <!--javascriptで切り替え（検索フォーム）-->

                                <div class="row g-3">
                                    <!--商品編集ボタンが押された時以外-->
                                    <?php if(!isset($edit)){?>
                                        <div class="form-check form-switch">
                                            <?php if(isset($search) || isset($kensaku)){?>
                                                <input class="form-check-input" type="checkbox" checked id="formSwitch" onclick="toggleForms()">
                                            <?php }else{?>
                                                <input class="form-check-input" type="checkbox" id="formSwitch" onclick="toggleForms()">
                                            <?php }?>
                                            <label class="form-check-label" for="formSwitch" style="display: block;">過去の履歴から検索</label>
                                        </div>

                                        <!--検索フォーム-->
                                        <form id="form1" action="" method="post">
                                            <tr>
                                                <td>
                                                    <div class="input-group" id="searchinput" style="display:flex;justify-content:center;">
                                                        <input type="text" name="name2" class="form-control" placeholder="商品名の入力" aria-label="" aria-describedby="button-addon2" value="<?php if(isset($name2)){echo $name2;}?>">
                                                        <?php if(isset($name)){?>
                                                            <input type="hidden" name="name" value="<?=$name?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="name" value="">
                                                        <?php }?>
                                                        <?php if(isset($price)){?>
                                                            <input type="hidden" name="price" value="<?=$price?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="price" value="">
                                                        <?php }?>
                                                        <?php if(isset($amount)){?>
                                                            <input type="hidden" name="amount" value="<?=$amount?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="amount" value="">
                                                        <?php }?>
                                                        <?php if(isset($tax)){?>
                                                            <input type="hidden" name="tax" value="<?=$tax?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="tax" value="">
                                                        <?php }?>
                                                        <?php if(isset($image)){?>
                                                            <input type="hidden" name="image" value="<?=$image?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="image" value="">
                                                        <?php }?>
                                                        <?php if(isset($memo)){?>
                                                            <input type="hidden" name="memo" value="<?=$memo?>">
                                                        <?php }else{?>
                                                            <input type="hidden" name="memo" value="">
                                                        <?php }?>
                                                        <?php if(isset($image_dir)){?>
                                                            <input type="hidden" name="image_dir" value="<?=$image_dir?>">
                                                        <?php }else{ ?>
                                                            <input type="hidden" name="image_dir" value="">
                                                        <?php } ?>
                                                        <?php if(isset($uploadTime)){?>
                                                            <input type="hidden" name="uploadTIme" value="<?=$uploadTime ?>">
                                                        <?php }else{ ?>
                                                            <input type="hidden" name="uploadTime" value="">
                                                        <?php } ?>
                                                        <button class="btn btn-outline-secondary" type="submit" name="search">検索</button>
                                                    </div>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select name="kensaku" class="form-select" multiple onchange="this.form.submit()">
                                                    <?php if(isset($kensaku)){?> 
                                                        <option value="" disabled selected>ここを押して選択肢から選んで下さい。</option>
                                                    <?php }else{?>
                                                        <option value="" disabled selected>選択なし</option>
                                                    <?php }?>    
                                                        <?php foreach($kensaku as $k=>$rec){?>
                                                            <option value="<?=$rec['commodity_ID']?>"><?=$rec['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                  
                                                </td>
                                            </tr>
                                        </form>
                                        <!--検索フォーム-->
                                    <?php }?>
                                </div>
                                <script>
                                    window.onload=function(){
                                        var form1 = document.getElementById('form1');

                                        var formSwitch = document.getElementById('formSwitch');    
                                        if (formSwitch.checked) {
                                            form1.style.display = 'block';
                                        } else {
                                            form1.style.display = 'none';
                                        }
                                    }

                                    function toggleForms() {

                                        var form1 = document.getElementById('form1');

                                        var formSwitch = document.getElementById('formSwitch');    

                                        if (formSwitch.checked) {

                                            form1.style.display = 'block';

                                        } else {

                                            form1.style.display = 'none';

                                        }

                                    }
                                    $('.selectpicker').selectpicker('refresh');
                                </script>
                                <form action ="" method="post" id="form2" class="row g-3" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <!--再アップロードのメッセージ表示-->
                                            <?php if(isset($_SESSION['back']) && isset($_SESSION['image_dir'])){ ?>
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:auto;">
                                                    <?=$again_msg?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>   
                                            <?php }?>
                                            <?php unset($_SESSION['image_dir']);?>
                                            <?php unset($_SESSION['back']);?>
                                            <?php unset($_SESSION['image']);?>
                                            <label for="name" style="display: block;">商品名</label>
                                            <div style="color:red;">
                                                <?php if(isset($error_1)){echo $error_1;}?>
                                            </div>
                                            <div class="input-group" style="display:flex; justify-content:center; align-items:center;">
                                                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($name)){ echo $name; }?>" style="flex: 1;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="price" style="display: block;">単価(１つ当たりの金額)</label>
                                            <div style="color:red;">
                                                <?php if(isset($error_2)){echo $error_2;}?>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">￥</span>
                                                <input type="text" name="price" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($price)){echo $price;}?>">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="amount" style="display: block;">個数</label>
                                            <div style="color:red;">
                                                <?php if(isset($error_3)){echo $error_3;}?>
                                            </div>
                                            <div class="mb-3 input-group">
                                                <input type="text" class="form-control" name="amount" id="exampleFormControlInput1" value="<?php if(isset($amount)){echo $amount;} ?>">
                                                <span class="input-group-text">個</span>
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="tax" style="display: block;">税率</label>
                                            <div class="mb-3">
                                                <select class="form-select" name="tax">
                                                    <?php foreach($arlist as $rec){?>
                                                        <?php if($tax == $rec){ ?>
                                                            <option value="<?=$rec?>" selected><?=$tax?>%</option>
                                                        <?php }else{ ?>
                                                            <option value="<?=$rec?>"><?=$rec?>%</option>
                                                        <?php }?>
                                                    <?php }?>   
                                                </select>         
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="image" style="display: block;">画像アップロード</label>
                                            <div style="color:red;">
                                                <?php if(isset($error_4)){echo $error_4;}?>
                                            </div>
                                            <div class="mb-3">
                                                <?php if(isset($image_dir) && $image_dir!==""){?>
                                                    <img id="image" src="<?=$image_dir?>" alt="画像イメージ" style="width:100%;">
                                                <?php }?>
                                                <div class="input-group mb-3">
                                                    <?php if(isset($image_dir) && $image_dir!==""){?>
                                                        <!--プレビュー-->
                                                        <div class="preview">
                                                            <div class="file">
                                                                <label class="file__label">
                                                                    <input type="file" name="image" class="form-control" id="fileInput" style="display:none;">
                                                                    <input type="hidden" name="image_dir" id="image_dir" value="<?=$image_dir?>">
                                                                    <input type="hidden" name="uploadTime" id="uploadTime">
                                                                </label>
                                                                <p class="file__none"></p>
                                                            </div>
                                                            <div class="preview-img"></div>
                                                        </div>
                                                        <!--プレビュー終了-->
                                                        <label class="input-group-text" for="fileInput">ファイルの再選択</label>
                                                        <!--画像がキャンセルされた時-->
                                                        <input type="text" class="form-control" id="fileName" name="file_name">
                                                        <?php if(isset($edit)){?>
                                                        <?php }else{?>
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm" id="cancel2" name="cancel2" >キャンセル</button>
                                                        <?php }?>
                                                    <?php }else{?>
                                                        <!--画像プレビュー-->
                                                        <div class="preview">
                                                            <div class="file">
                                                                <label class="file__label">
                                                                    <div class="input-group mb-3">
                                                                        <input type="file" name="image" class="form-control" id="fileInput">
                                                                        <!--画像がキャンセルされた時-->
                                                                        <button class="btn btn-outline-secondary btn-sm" type="submit" id="cancel" name="cancel" onclick="cancel();">キャンセル</button>
                                                                    </div>    
                                                                    <input type="hidden" name="uploadTime" id="uploadTime">
                                                                </label>
                                                                <p class="file__none"></p>
                                                            </div>
                                                            <div class="preview-img"></div>
                                                        </div>
                                                    <?php }?>
                                                </div>

                                                <!--画像プレビューjquery-->    

                                                <script>

                                                    $(function () {

                                                        $(document).on("change", ".preview input[type=file]", function () {

                                                            let elem = this;

                                                            if (elem.files.length === 0) {

                                                                $(elem).closest(".preview").find(".preview-img").html('');

                                                                $(elem).closest(".preview").find(".file__none").text('');

                                                                return;

                                                            }

                                                            let fileReader = new FileReader();

                                                            fileReader.readAsDataURL(elem.files[0]);

                                                            fileReader.onload = function () {

                                                                let imgUrl = fileReader.result;

                                                                let fileNames = Array.from(elem.files).map(file => file.name);

                                                                let imgTag = `<img src='${imgUrl}'>`;

                                                                $(elem).closest(".preview").find(".preview-img").html(imgTag);

                                                                $(elem).closest(".preview").find(".file__none").text(fileNames.join());

                                                            };

                                                        });

                                                    });
                                                </script>

                                                <!--イメージ画像の大きさを指定-->

                                                <style>

                                                    .preview-img img {

                                                        max-width: 450px; /* 画像の最大幅を100pxに設定 */

                                                        max-height: 450px; /* 画像の最大高さを100pxに設定 */

                                                    }

                                                </style>

                                                <!--ファイルの再選択-->

                                                <script>
                                                        document.getElementById('fileInput').addEventListener('change', async function(event) {
                                                        var fileName = this.files.length ? this.files[0].name : '';
                                                        document.getElementById('fileName').value = fileName;

                                                        const file = event.target.files[0];
                                                        const chunkSize = 1024 * 1024; // 1MB
                                                        const totalChunks = Math.ceil(file.size / chunkSize);
                                                        const originalTimestamp = Math.floor(file.lastModified / 1000); // 元のタイムスタンプを取得

                                                        let allChunksUploaded = true;

                                                        for (let i = 0; i < totalChunks; i++) {
                                                            const start = i * chunkSize;
                                                            const end = Math.min(start + chunkSize, file.size);
                                                            const chunk = file.slice(start, end);

                                                            const formData = new FormData();
                                                            formData.append('file', chunk, fileName);
                                                            formData.append('fileName', fileName);
                                                            formData.append('uploadTime', originalTimestamp); // 元のタイムスタンプを追加
                                                            formData.append('chunkIndex', i);
                                                            formData.append('totalChunks', totalChunks);

                                                            try {
                                                                const response = await fetch('https://marutani098723.com/new_app/uploads', {
                                                                    method: 'POST',
                                                                    body: formData
                                                                });

                                                                if (!response.ok) {
                                                                    throw new Error(`Upload failed: ${response.statusText}`);
                                                                }

                                                                const data = await response.json();
                                                                console.log(`Chunk ${i + 1}/${totalChunks} uploaded successfully:`, data);
                                                            } catch (error) {
                                                                console.error(`Error uploading chunk ${i + 1}/${totalChunks}:`, error);
                                                                allChunksUploaded = false;
                                                                break;
                                                            }
                                                        }

                                                        if (allChunksUploaded) {
                                                            console.log('All chunks uploaded successfully.');
                                                        } else {
                                                            console.log('Some chunks failed to upload.');
                                                        }
                                                    });

                                                // ボタンが押されたら空にする
                                                document.getElementById('fileInput').addEventListener('click', function(event) {
                                                    event.stopPropagation();
                                                    var imageElement = document.getElementById('image');
                                                    if (imageElement) {
                                                        imageElement.remove();
                                                    }
                                                });

                                                // ファイルのタイムスタンプ
                                                document.getElementById('form2').addEventListener('submit', function() {
                                                    var uploadTime = new Date().getTime() / 1000; // Unixタイムスタンプ（秒）
                                                    document.getElementById('uploadTime').value = uploadTime;
                                                });

                                                // ファイルキャンセル
                                                document.getElementById('cancel').addEventListener('click', function() {
                                                    document.getElementById('fileInput').value = "";
                                                    document.getElementById('fileName').value = "";
                                                    document.getElementById('uploadTime').value = "";
                                                });
                                                </script>
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="mb-3">
                                                <label for="memo" style="display: block;">メモ欄</label>
                                                <textarea name="memo" class="form-control"><?php if(isset($memo)){ echo $memo; }?></textarea>
                                            </div>      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="mb-3" style="text-align:center;padding:10px;">
                                                <?php if(isset($edit)){ ?>
                                                    <div style="display:flex;justify-content:center;">
                                                        <form action="" method="post">
                                                            <button type="button" name="return" class="btn btn-primary" id="return" onclick="location.href='registerCommodity.php'">戻る</button>
                                                            &nbsp;&nbsp;
                                                            <input type="hidden" name="cid" value="<?=$cid?>">
                                                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($_POST['order_id']); ?>">
                                                            <button type="submit" name="update" class="btn btn-warning" id="btn_confirm">更新</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <?php }else{?>
                                                    <button type="button" name="clear" class="btn btn-primary" onclick="location.href='registerCommodity.php'" id="btn-2">クリア</button>&nbsp;
                                                    <button type="submit" name="submitC" class="btn btn-warning" onclick="location.href='confirmCommodity.php'" id="btn">確認</button>
                                                <?php }?>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            </div>
                            <div class="col-4">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                <!--商品編集の時は表示させない-->
                                <?php if(!isset($edit)){?>
                                    <?php if(empty($CName)){?>
                                        <span style="display:flex;justify-content:center;">データがありません。</span>
                                    <?php }else{ ?>
                                        <?php if(isset($_SESSION['message_2'])){ ?>
                                            <div class="row">
                                                <div class="col-12" style="display:flex;justify-content:center;">
                                                    <div class="alert alert-success" role="alert" style="width:auto;">
                                                        <?php echo $_SESSION['message_2']; ?>
                                                        <?php unset($_SESSION['message_2']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                         <!--登録されたものがここに表示されるので、ここから編集削除、購入確定は確定のみ-->
                                        <table class="table table-bordered" style="display:flex;justify-content:center;">
                                            <tr>
                                                <th style="background-color:pink;text-align:center;">商品名</th>
                                                <th style="background-color:pink;text-align:center;">編集</th>
                                                <th style="background-color:pink;text-align:center;">削除</th>
                                            </tr>
                                            <?php foreach($dlist as $rec){?>
                                            <tr>
                                                <td style="text-align:center;"><?=$rec['cname'] ?></td>
                                                <td style="text-align:center;">
                                                <!--編集ボタン-->
                                                    <form action="" method="post">
                                                        <input type="hidden" name="cid" value="<?=$rec['cid']?>">
                                                        <input type="hidden" name="name" value="<?=$rec['cname']?>">
                                                        <input type="hidden" name="order_id" value="<?=$rec['order_id'] ?>">
                                                        <button type="submit" class="btn btn-success" name="edit">編集</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <!--削除ボタン-->
                                                    <form action="" method="post" onsubmit="return confirmDelete()">
                                                        <input type="hidden" name="cid" value="<?=$rec['cid']?>">
                                                        <input type="hidden" name="name" value="<?=$rec['cname']?>">
                                                        <input type="hidden" name="order_id" value="<?=$rec['order_id'] ?>">
                                                        <input type="hidden" name="price" value="">
                                                        <input type="hidden" name="amount" value="">
                                                        <button type="submit" class="btn btn-dark" name="delete">削除</button>
                                                    </form>
                                                    <script>
                                                        function confirmDelete() {
                                                            return confirm('本当に削除しますか？');
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } ?>
                                <?php } ?>
                                <!--商品リスト終了-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</body>
</html>