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
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="商品名の入力" aria-label="" aria-describedby="button-addon2">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">検索</button>
                                                </div>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <select name="result" size="10" style="width:200px;">
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>  
                                            </td>
                                        </tr>
                                    </form>
                                </div>
                                <script>
                                    function toggleForms() {
                                        var form1 = document.getElementById('form1');
                                        if (form1.style.display === 'none') {
                                            form1.style.display = 'block';
                                        } else {
                                            form1.style.display = 'none';
                                        }
                                    }
                                </script>   
                                <form>
                                    <tr>
                                        <td>
                                            <label for="name">商品名</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="tax">税率</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" aria-label="percentage">
                                                <span class="input-group-text">%</span>
                                            </div>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="amount">個数</label>
                                            <div class="mb-3">
                                                <input type="email" class="form-control" id="exampleFormControlInput1">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="price">単価</label>
                                            <div class="mb-3">
                                                <input type="text" name="price" class="form-control" id="exampleFormControlInput1">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="price">画像アップロード</label>
                                            <div class="mb-3">
                                                <input type="file" name="price" class="form-control" id="exampleFormControlInput1">
                                            </div>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="mb-3" style="text-align:center;">
                                                <button type="button" class="btn btn-warning" onclick="location.href='confirmCommodity.php'">確認</button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
</body>
</html>