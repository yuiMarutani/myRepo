<?php 

session_start();

require_once('Modules/registerCommodity.Class.php');

$registerC = new registerCommodity();



//user_idの設定

$user_id = $registerC->setUserid($_SESSION['user_name'],$_SESSION['password']);
$user_id = $registerC->getUserid();



//お買い物回数の算出

$shoppingnum = $registerC->shoppingNum($user_id);
if($_SERVER['REQUEST_METHOD']=='POST'){

    //商品名
    $name = htmlspecialchars($_POST['name']);

    //金額
    $price = htmlspecialchars($_POST['price']);

    //量
    $amount = htmlspecialchars($_POST['amount']);


    //税金
    $tax = htmlspecialchars($_POST['tax']);

    //メモ
    $memo = htmlspecialchars($_POST['memo']);

    //合計金額
    $total = $registerC->Total($price,$tax,$amount); 


    //ファイル名
    if(isset($_POST['file_name'])){
        $file_name = htmlspecialchars($_POST['file_name']);
    }



    if(isset($_POST['image_dir'])){
        $image_dir = htmlspecialchars($_POST['image_dir']);
    }

    //確定ボタン押された時
    if(isset($_POST['confirm'])){
        $confirm = htmlspecialchars($_POST['confirm']);
        //確定処理
        //画像がなかった時のimage_dir
        if(!isset($image_dir) || empty($image_dir)){
            $image_dir = "";
        }

        //2重登録防止
        $verify_insert = $registerC->verify_insert($user_id,$tax,$amount,$price,$total,$image_dir,$shoppingnum,$memo,$name);
        if($verify_insert==0){
            //データがないときは登録、他登録せずリダイレクト
            $confirm_method = $registerC->confirm($user_id,$tax,$amount,$price,$total,$image_dir,$shoppingnum,$memo,$name);
            //商品を登録メッセージ
            $_SESSION['message'] = "商品を登録しました。";
        }

        //headerで最初の画面に戻る
        header('location:registerCommodity.php');

    }



    //戻るボタンが押されたとき
      if(isset($_POST['back'])){
        $back = htmlspecialchars($_POST['back']);
    }



    //バリデーションにひっかかった時
    //1回目で画像が渡った時のタイムスタンプ
    if(isset($_POST['uploadTime']) && $_POST['uploadTime']!==""){
        $uploadTimeInt = (int)htmlspecialchars($_POST['uploadTime']);
        $uploadTimeFloat = (float)htmlspecialchars($_POST['uploadTime']);
    
        // タイムスタンプの整数部分から作成
        $uploadTime = new DateTime("@$uploadTimeInt");
    
        // 更新されたUnixのタイムスタンプに時差を追加
        $updatedUnixTimestamp = $uploadTime->getTimestamp() + ($uploadTimeFloat - $uploadTimeInt);
    
    }



    //ファイルの日付生成
    if(isset($uploadTime)){
        //日付をフォーマットする
        $date = date('YmdHis', $updatedUnixTimestamp);
        
    }

    //画像が再選択されたとき
    if(isset($_POST['image'])){
        $image = htmlspecialchars($_POST['image']);
    }


    //画像のディレクトリ
    if(isset($image_dir) && $image_dir!==""){
        if(isset($file_name) && $file_name==""){
            //再選択されていないとき
        }else{
            //再選択されているとき
            if(isset($date)&&$file_name){
                $image_dir = "https://marutani098723.com/new_app/uploads/".$date."_".$file_name;
            }
        }
    }else{
        //バリデーションパスして1回目で画像が渡った時
        if(!empty($_FILES['image']['name'])){
            if(isset($date) && $date!==""){
                $image_dir = "https://marutani098723.com/new_app/uploads/".$date."_".$_FILES['image']['name'];
            }
        }else{
            if(isset($date) && $date !=="" && isset($file_name)&& $file_name!==""){
                //バリデーションで引っかかった時
                $image_dir = "https://marutani098723.com/new_app/uploads/".$date."_".$file_name;
            }
        }

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
        if(isset($image_dir) && $image_dir<>""){
            $_SESSION['back'] = 1; //戻るボタンのフラグ
        }

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

    <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit='no'>

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
                <!--オフキャンバスボタン-->
                <div class="col">
                    <header style="background-image: linear-gradient(to right, #d4af37, #ffd700, #d4af37);justify-content:left;">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDark" aria-controls="offcanvasDark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5"/>
                                <path d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194z"/>
                            </svg>
                        </button>
                        <h2 style="color:white;">お買い物管理</h2>
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

                    <div class="container-fluid">

                        <div class="row  flex-no-wrap">

                            <div class="col-md-4"></div>

                            <div class="col-md-4">

                                <h3 style="color:red;text-align:center;">確認</h3>

                            </div>

                            <div class="col-md-4">

                              

                            </div>

                        </div>

                        <div class="row  flex-no-wrap" style="padding:10px;">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4" style="white-space:nowrap;display:flex;justify-content:center;">

                                <?php if(isset($image_dir)&& $image_dir!==""){ ?>

                                    <img src="<?=$image_dir?>" alt="画像" style="width:auto;"><br>

                                <?php } ?>

                            </div>

                            <div class="col-md-4">

                            </div>

                        </div>

                        <div class="row  flex-no-wrap" style="padding:10px;">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4" style="white-space:nowrap;display:flex;justify-content:center;">

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

                                            <td style ="whitespace:nowrap;"><?=$memo?></td>

                                        </tr>

                                    </table>

                            </div>

                            <div class="col-md-4">

                                

                            </div>

                        </div>

                        <div class="row  flex-no-wrap">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4" style="text-align:center;display:flex;justify-content:center;">

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

                                    <button type="submit" name="back" id="button1" class="btn btn-primary" value="1">戻る</button>

                                </form>&nbsp;

                                <form action="" method="post">

                                    <input type="hidden" name="name" value="<?=$name ?>">

                                    <input type="hidden" name="tax" value="<?=$tax ?>">

                                    <input type="hidden" name="amount" value="<?=$amount ?>">

                                    <input type="hidden" name="price" value="<?=$price ?>">

                                    <?php if(isset($memo)){?>

                                        <input type="hidden" name="memo" value="<?=$memo ?>">

                                    <?php }?>

                                    <input type="hidden" name="total" value="<?=$total ?>">

                                    <?php if(isset($image_dir)){?>

                                        <input type="hidden" name="image_dir" value="<?=$image_dir ?>">

                                    <?php } ?>

                                    <?php if(isset($date)){?>

                                        <input type="hidden" name="date" value="<?=$date?>">

                                    <?php }?>

                                    <?php if(isset($file_name)){?>

                                        <input type="hidden" name="file_name" value="<?=$file_name?>">

                                    <?php }?>

                                    <button type="submit" name="confirm" class="btn btn-warning">候補確定</button>

                                </form>

                            </div>

                            <div class="col-md-4">

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