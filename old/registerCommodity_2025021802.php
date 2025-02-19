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

//$_POSTで渡ってきている時
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $amount = htmlspecialchars($_POST['amount']);
    $tax = htmlspecialchars($_POST['tax']);
    $image = htmlspecialchars($_POST['image']);
    $memo = htmlspecialchars($_POST['memo']);

    list($error_1,$error_2,$error_3,$error_4) = $registerC->validateCommodity($name,$price,$amount,$image);
    print_r($error_1);
    
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
    <main>
        <div class="container-fluid" style="white-space:nowrap;">
            <div class="row flex-nowrap">
                <div class="bg-dark col-auto col-md-3 min-vh-100">
                    <div class="bg-dark p-2">
                        <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                            <i class="fs-5 fa fa-gauge"></i><span class="fs-4  d-sm-inline">お買い物管理</span>
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
                <!--右サイド-->
                <div class="col py-3">
                    <h5><?php echo $_SESSION['user_name'];?>様</h5>
                    <div class="container" style="padding:20px;">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <h3>商品候補登録</h3>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                        <div class="row" style="padding:10px;">
                            <div class="col">
                                
                              
                            </div>
                            <div class="col" style="white-space:nowrap;"> 
                            <!--javascriptで切り替え（検索フォーム）-->
                                <div class="container mt-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="formSwitch" onclick="toggleForms()">
                                        <label class="form-check-label" for="formSwitch">過去の履歴から検索</label>
                                    </div>
                                    <form id="form1" action="search.php">
                                        <tr>
                                            <td>
                                                <div class="input-group" id="searchinput" style="display:flex;justify-content:center;">
                                                    <input type="text" name="name" class="form-control" placeholder="商品名の入力" aria-label="" aria-describedby="button-addon2">
                                                    <button class="btn btn-outline-secondary" type="button">検索</button>
                                                </div>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="sel1" name="name" class="form-select" size="10" style="width:500px;">
                                                    <option value="1">1</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </form>
                                </div>
                                <script>
                                    window.onload=function(){
                                        var form1 = document.getElementById('form1');
                                        var formSwitch = document.getElementById('formSwitch');    
                                        form1.style.display = 'none';
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
                                </script>   
                                <form action ="" method="post" class="row g-3">
                                    <tr>
                                        <td>
                                        <div class="col-md-4">
                                            <label for="validationServer01" class="form-label">First name</label>
                                            <input type="text" class="form-control is-valid" id="validationServer01" value="Mark" required>
                                            <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                       <!--      <label for="name">商品名</label>
                                            <div class="input-group" style="display:flex; justify-content:center; align-items:center;">
                                                <input type="text" name="name" class="form-control is-valid" id="exampleFormControlInput1" value="<?php if(isset($name)){ echo $name; }?>" style="flex: 1;"required>
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div> -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="tax">税率</label>
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
                                            <label for="amount">個数</label>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="amount" id="exampleFormControlInput1" value="<?php if(isset($amount)){echo $amount;} ?>">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="price">単価(１つ当たりの金額)</label>
                                            <div class="mb-3">
                                                <input type="text" name="price" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($price)){echo $price;}?>">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="image">画像アップロード</label>
                                            <div class="mb-3">
                                                <input type="file" name="image" class="form-control" id="exampleFormControlInput1" value="<?php if(isset($image)){ echo $image;}?>">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="mb-3">
                                                <label for="memo">メモ欄</label>
                                                <textarea name="memo" size="20" class="form-control"><?php if(isset($memo)){ echo $memo; }?></textarea>
                                            </div>      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="mb-3" style="text-align:center;padding:10px;">
                                                <button type="submit" class="btn btn-warning" onclick="location.href='confirmCommodity.php'">確認</button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            </div>
                            <div class="col">
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    
                                </div>
                                <div class="col">
                            <!--登録されたものがここに表示されるので、ここから編集削除、購入確定は確定のみ-->
                            <!-- <ul class="list-group">
                                <li class="list-group-item">
                                    <div style="display:flex;justify-content:center;">
                                        リンゴ&nbsp;&nbsp;
                                        <button type="button" class="btn btn-success" onclick="location.href='registerCommodity.php'">編集</button>
                                        <button type="button" class="btn btn-dark" onclick="location.href='registerCommodity.php'">削除</button>
                                    </div>    
                                </li>
                                <li class="list-group-item">
                                    <div style="display:flex;justify-content:center;">
                                        みかん&nbsp;&nbsp;
                                        <button type="button" class="btn btn-success" onclick="location.href='registerCommodity.php'">編集</button>
                                        <button type="button" class="btn btn-dark" onclick="location.href='registerCommodity.php'">削除</button>
                                    </div>    
                                </li>
                                <li class="list-group-item">
                                    <div style="display:flex;justify-content:center;">
                                        ブドウ&nbsp;&nbsp;
                                        <button type="button" class="btn btn-success" onclick="location.href='registerCommodity.php'">編集</button>
                                        <button type="button" class="btn btn-dark" onclick="location.href='registerCommodity.php'">削除</button>
                                    </div>    
                                </li>
                            </ul> -->
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
</body>
</html>