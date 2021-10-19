<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品一覧ページ</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    </header>
    <div class="content">
<?php include VIEW_PATH . 'templates/messages.php'; ?>
<?php if ($age === '0') { ?>
        <h2>ごっくん期（５ヶ月〜）</h2>
<?php } ?>
<?php if ($age === '1') { ?>
        <h2>もぐもぐ期（７ヶ月〜）</h2>
<?php } ?>
<?php if ($age === '2') { ?>
        <h2>かみかみ期（９ヶ月〜）</h2>
<?php } ?>
        <ul class="item-list">
            <li>
<?php foreach ($items as $value) { ?>
                <div class="item">
                    <form method="post">
                        <a href="./detail.php?id=<?php print $value['id']; ?>"><img class="itemimage" src="<?php print(IMAGE_PATH . $value['img']); ?>" ></a>
                        <div>
                            <p><?php print h($value['name']); ?></p>
                            <p><?php print $value['price']; ?>円</p>
                        </div>
    <?php if ($value['stock'] > 0) { ?>
                        <input class="cart-btn" type="submit" value="カートに入れる">
                        <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                        <input type="hidden" name="sql_kind" value="insert">
    <?php } else { ?>         
                        <span class="red">SOLD OUT</span>
    <?php } ?>
                    </form>
                </div>
              </li>
<?php } ?>
        </ul>
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
