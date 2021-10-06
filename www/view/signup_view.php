<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ登録ページ</title>
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    <header>
        <div class="header-box">
            <div class="title">
                <a href="./top.php">
                    <img class="titlelogo" src="./image/logo.jpeg" alt="Baby Food Store">Baby Food Store
                </a>
            </div>
        </div>
    </header>
    <div class="content">
<?php if (count($err_msg) > 0) { ?>
    <?php foreach ($err_msg as $value) { ?>
    <p><?php print $value; ?></p>
    <?php } ?>
<?php } ?>
<?php if (count($scs_msg) > 0) { ?>
    <?php foreach ($scs_msg as $value) { ?>
    <p><?php print $value; ?></p>
    <?php } ?>
<?php } ?>
        <div class="register">
            <form method="post">
                <div>ユーザー名：<input type="text" name="user_name" placeholder="ユーザー名"></div>
                <div>パスワード：<input type="password" name="password" placeholder="パスワード"></div>
                <div><input type="submit" value="ユーザーを新規作成する"></div>
            </form>
            <a href="./top.php">ログインページへ移動</a>
        </div>
    </div>
    <footer>
        <ul class="footer">
            <li class="footerlist"><a href="#">サイトマップ</a></li>
            <li class="footerlist"><a href="#">プライバシーポリシー</a></li>
            <li class="footerlist"><a href="#">お問い合わせ</a></li>
            <li class="footerlist"><a href="#">ご利用ガイド</a></li>
        </ul>
        <p class="copyright">Copyright&copy;BabyFoodStore All Rights Reserved.</p>
    </footer>
</body>
</html>