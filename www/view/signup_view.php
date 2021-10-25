<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ登録ページ</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
        <?php include VIEW_PATH . 'templates/header.php'; ?>
    </header>
    <div class="content">
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
        <div class="register">
            <form method="post" action="signup_processing.php">
                <div>ユーザー名：<input type="text" name="name" placeholder="ユーザー名"></div>
                <div>パスワード：<input type="password" name="password" placeholder="パスワード"></div>
                <div>
                    <input type="submit" value="ユーザーを新規作成する">
                    <input type="hidden" name="token" value="<?php print h($token); ?>">
                </div>
            </form>
            <a href="./login.php">ログインページへ移動</a>
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