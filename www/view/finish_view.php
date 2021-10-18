<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入完了ページ</title>
    <link type="text/css" rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    </header>
    <div class="content">
<?php include VIEW_PATH . 'templates/messages.php'; ?>
        <div class="finish-msg">ご購入ありがとうございました。</div>
        <div class="cart-list-title">
            <span class="cart-list-price">価格</span>
            <span class="cart-list-num">数量</span>
        </div>
            <ul class="cart-list">
<?php foreach ($carts as $value) { ?>
                <li>
                    <div class="cart_item">
                        <img class="itemimage" src="<?php print (IMAGE_PATH . $value['img']); ?>">
                        <span class="cart-item-name"><?php print h($value['name']); ?></span>
                        <span class="cart-item-price">¥<?php print $value['price']; ?></span>
                        <span class="cart-item-num"><?php print $value['amount']; ?></span>
                        <span class="finish-item-price"></span>
                    </div>
                </li>
<?php } ?>
          </ul>
        <div class="buy-sum-box">
            <span class="buy-sum-title">合計</span>
            <span class="buy-sum-price">¥<?php print $total_price; ?></span>
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