<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <header><img src="image/vegetables.jpg" alt="..."></header>
    <main>
        <div class="container">
            <h1>お買い物管理アプリ</h1>
            <h2>ログイン</h2>
            <form id="form1" class="center">
                <table>
                    <tr>
                        <th>
                            <label for="user_name">ユーザ名：
                        </th>
                            <td>
                            <input type="text" name="user_name">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password">パスワード：
                        </th>
                        <td>
                            <input type="text" name="password">
                        </td>
                    </tr>
                </table>
                <br>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            
                        </div>
                        <div class="col" style="text-align:left;">
                            <button type="button" class="btn btn-info">送信</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer></footer>
</body>
</html>