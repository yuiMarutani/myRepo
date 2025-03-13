<?php 

require_once('Modules/User.Class.php');

require_once('Modules/Authentification.Class.php');

require_once('Modules/Settings.Class.php');



session_start();

//今日の日付

$date = new DateTime('now');

$today = $date->format('Y年m月d日');



//$user_idをデータベースから取得

$settings = new Settings();

$user_id = $settings->setUserid($_SESSION['user_name'],$_SESSION['password']);

$user_id = $settings->getUserid();



//お買い物回数の算出

$shoppingnum = $settings->shoppingNum($user_id);

//pokemonの取得
// PokeAPIのエンドポイント
$apiUrl = "https://pokeapi.co/api/v2/pokemon/";

//500回まではポケモンを出す（ポケモンが足りなくなるため）
if($shoppingnum<=500){
// 取得したいポケモンの名前またはID
    $pokemonNameOrId = "{$shoppingnum}"; // 例: "pikachu" または "25"

    // APIリクエストを送信
    $response = file_get_contents($apiUrl . $pokemonNameOrId);

    // レスポンスをJSONとしてデコード
    $pokemonData = json_decode($response, true);

    // 画像URLを取得
    $imageUrl = $pokemonData['sprites']['front_default'];

    $pokemon = $imageUrl;
}



//金額のセレクトボックス値

$selectData = array();

for($i=5;$i<=20;$i++){

    array_push($selectData,$i);

}





//POSTされた時

if($_SERVER['REQUEST_METHOD']=='POST'){

    //$earnings

    if(isset($_POST['earnings'])){

        $earnings = htmlspecialchars($_POST['earnings']);

        $earnings = $settings->setEarnings($earnings);

        $earnings = $settings->getEarnings($earnings);

    }



    if(isset($_POST['goal'])){

        $goal = htmlspecialchars($_POST['goal']);

        $goal = $settings->setGoal($goal);

        $goal = $settings->getGoal($goal);

    }



    if(isset($_POST['tax'])){

        $tax = htmlspecialchars($_POST['tax']);

        $tax = $settings->setTax($tax);

        $tax = $settings->setTax($tax);

    }



    if(isset($_POST['submit1'])){

        $submit1 = htmlspecialchars($_POST['submit1']);

    }



    //編集ボタン

    if(isset($_POST['edit'])){

        $edit = htmlspecialchars($_POST['edit']);

    }

    

    //登録ボタン

    if(isset($_POST['register'])){

        $register = htmlspecialchars($_POST['register']);

    }



    //更新ボタン

    if(isset($_POST['updatedb'])){

        $updatedb = htmlspecialchars($_POST['updatedb']);

    }



    //リセットボタン

    if(isset($_POST['reset'])){

        $reset = htmlspecialchars($_POST['reset']);

    }



    //登録ボタンが押された時

    if(isset($register)){

        //エラーの表示

        $error_list = $settings->Validation($user_id,$earnings,$goal);

        $error_1 = $error_list[0];//所持金

        $error_2 = $error_list[1];//目標金額

        $error_3 = $error_list[2];//消費税の設定



        //エラーの中身がそれぞれ空なら、settingsテーブルに登録

        if($error_1=="" && $error_2=="" && $error_3==""){

            //挿入

            $InsertDB = $settings->settingsDBinsert($user_id,$earnings,$goal,$tax,$shoppingnum);

            $msg = "正常に登録できました。";

        }

    }



    //更新ボタンが押された時

    if(isset($updatedb)){

        $error_list = $settings->Validation($user_id,$earnings,$goal);

        $error_1 = $error_list[0];//所持金

        $error_2 = $error_list[1];//目標金額

        $error_3 = $error_list[2];//消費税の設定

        //エラーの中身がそれぞれ空なら、settingsテーブルに更新

        if($error_1=="" && $error_2=="" && $error_3==""){

            //更新

            $updateDB = $settings->dbUpdate($user_id,$goal,$earnings,$tax,$shoppingnum);

            $msg = "正常に更新しました。";

        }

        

    }



    //リセットボタンが押された時

    if(isset($reset)){

        //データベースの情報を削除

        $dbdelete = $settings->deleteDB($user_id,$shoppingnum);

        $msg = "リセットしました。";

    }



}else{

    //デフォルトで既にデータの登録があるとき

    $data_verify = $settings->dataVerify($user_id,$shoppingnum);

    if($data_verify>0){

    //登録でなく、更新できる状態にする　（updateDB==1 updatedb=""）id等の情報get

        $updatedb = "";

        $updateDB = 1;

        //データゲット

        $data_get = $settings->dataGet($user_id,$shoppingnum);

        $earnings = $data_get[0];

        

        $goal = $data_get[1];

        $tax = $data_get[2];

    }

}

//セッション切れはheaderでlogin.phpに飛ばす

if(isset($_SESSION) && empty($_SESSION)){

    header('Location: https://marutani098723.com/new_app/login.php');

}

//ログアウト処理されたとき



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
    <!--main-->
    <main>
   
    <div class="container-fluid flex-nowrap" style="white-space:nowrap;">
        <div class="row" style="white-space:nowrap;">
        <!--オフキャンバスボタン-->
            <div class="col-12">
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
                            <a href="settings.php" class="nav-link text-white active">
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
    <!--オフキャンバスのスタイル-->
    <style>
        /* デフォルトスタイル */
        .offcanvas {
            width: 300px;
            max-width: 300px;
            overflow-x: hidden;
        }
    </style>
    <!--右サイド-->
    <div class="row flex-nowrap">
        <div class="col"></div>
        <div class="col-10 py-3">
            <span><?php echo $today;?></span><br>
            <span><?= $shoppingnum;?>回目のお買い物</span>
            <?php if(isset($pokemon)){?>
                <img src="<?= $pokemon;?>" alt="noimage" style="width:80px;height:80px;">
            <?php }?>
        </div>
        <div class="col"></div>
    </div>
    <div class="row">
        <div class="col-12" style="display:flex;justify-content:center;">
            <h3>金額の登録設定</h3>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row flex-wrap">
        <div class="col-12" style="padding:100px;">
            <form action="" method="post">
                <table class="table table-borderless table-sm" style="display:flex;justify-content:center;">
                    <tr>
                        <td>
                            <?php if(isset($msg)){ ?>
                                <font style="color:green;display:flex;justify-content:center;">
                                    <div class="alert alert-success" role="alert">
                                        <?=$msg ?>
                                    </div>
                                </font>
                            <?php }?>
                                <font style="color:red;display:flex;justify-content:center;"><?php if(isset($error_3)){ echo $error_3;}?></font>
                                <font style="color:blue;display:flex;">　所持金、目標金額、消費税の設定</font>
                        </td>
                    </tr>
                    <tr>
                        <td style="white-space:nowrap;display:flex;"><span style="color:red;">　※</span>所持金を登録する（必須）</td>
                        <td style="white-space:nowrap;">
                            <?php if(isset($InsertDB) && $InsertDB==1 || isset($updatedb) && isset($updateDB) && $updateDB==1 ){ ?>
                                <?=$earnings ?>円 &nbsp;&nbsp;&nbsp;
                                <!--更新ボタンが再度押された時hiddenで最初のページに送信-->
                                <?php if(isset($updatedb) && isset($updateDB)&& $updateDB==1 ){ ?>
                                <form action="" method="post">
                                    <input type="hidden" name="earnings" value="<?=$earnings?>">
                                    <input type="hidden" name="goal" value="<?=$goal?>">
                                    <input type="hidden" name="tax" value="<?=$tax?>">
                                <?php }?>
                                <!--formで編集　押されたら、ここだけ切り替え-->
                            <?php }else{?>
                                <div style="display:flex;">
                                    <input type="text" name="earnings" class="form-control" value="<?php if(isset($earnings)){ echo $earnings;}?>">&nbsp;円<span style="color:red;"><?php if(isset($error_1)){echo $error_1;}?></span>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="white-space:nowrap;display:flex;">　目標金額の設定（設定ないときは0入力）</td>
                        <td style="white-space:nowrap;">
                            <?php if(isset($InsertDB) && $InsertDB==1 || isset($updatedb) && isset($updateDB) && $updateDB==1){ ?>
                                <?=$goal?>円&nbsp;&nbsp;&nbsp;
                            <?php }else{ ?>
                                <div style="display:flex;">
                                    <input type="text" style="white-space:nowrap;" class="form-control" name="goal" value="<?php if(isset($goal)){ echo $goal;} ?>">&nbsp;円<span style="color:red;"><?php if(isset($error_2)){echo $error_2;}?></span>
                                </div>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td style="white-space:nowrap;display:flex;"><span style="color:red;">　※</span>消費税額の設定</td>
                        <td style="white-space:nowrap;">
                            <?php if(isset($InsertDB) && $InsertDB==1 || isset($updatedb) && isset($updateDB) &&  $updateDB==1){ ?>
                                <?=$tax?> %
                            <?php }else{ ?>
                                <select style="width:auto;" name="tax"class="form-select">
                                    <?php foreach($selectData as $data){ ?>
                                        <?php if(isset($tax)&& $tax==$data){?>
                                            <option value="<?=$tax ?>" selected><?=$tax?>%</option>
                                        <?php }else{?>
                                            <option value="<?=$data?>"><?=$data ?>%</option>
                                        <?php } ?>
                                    <?php }?>
                                </select>
                            <?php }?>
                        </td>
                    </tr>
                    <tr style="display:flex;justify-content:center;">
                        <?php if(isset($InsertDB) && $InsertDB==1 || isset($updatedb) && isset($updateDB) &&  $updateDB==1){?>
                            <td>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="edit">編集</button>
                                        <input type="hidden" name="goal" value="<?=$goal?>">
                                        <input type="hidden" name="earnings" value="<?=$earnings ?>">
                                        <input type="hidden" name="tax" value="<?= $tax ?>">
                                        <input type="hidden" name="edit" value="1">
                                    </div>
                                </form>
                            </td>
                            <td> 
                                <form action="" method="post">
                                    <div class="form-group">
                                        <input type="hidden" name="goal" value="">
                                        <input type="hidden" name="earnings" value="">
                                        <input type="hidden" name="reset" value="1">
                                        <button type="submit" class="btn btn-primary" style="white-space:nowrap;" name="reset">リセット</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php }else{ ?>
                        <tr style="display:flex;justify-content:center;">
                            <?php if(isset($edit)|| isset($updatedb) || isset($updateDB) && $updateDB==1){ ?>
                                <td style="white-space:nowrap;" align="right">
                                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;" name="updatedb">更新</button>
                                </td>
                                <td style="white-space:nowrap;">
                                    <button type="button" class="btn btn-primary" style="white-space:nowrap;" name="cancel" onclick="location.href='settings.php'">キャンセル</button>
                                </td>
                            <?php }else{ ?>
                                <td></td>
                                <td style="white-space:nowrap;">
                                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;"name="register">登録</button>
                                </td>
                            <?php }?>
                        <?php } ?>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
<!--右サイド終了-->
    </div>
</div>
</div>
</main>

</body>

</html>