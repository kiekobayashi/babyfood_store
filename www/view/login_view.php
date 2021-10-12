<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログインページ</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
        <?php include VIEW_PATH . 'templates/header.php'; ?>
    </header>
    <div class="content">
        <div class="login">
            <form method="post" action="login_processing.php">
                <div><input type="text" name="name" placeholder="ユーザー名"></div>
                <div><input type="password" name="password" placeholder="パスワード"></div>
                <div>
                    <input type="submit" value="ログイン">
                    <input type="hidden" name="token" value="<?php print h($token); ?>"> 
                </div>
            </form>
            <?php include VIEW_PATH . 'templates/messages.php'; ?>
            <div class="account-create">
                <a href="./signup.php">ユーザーの新規作成</a>
            </div>
        </div>
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