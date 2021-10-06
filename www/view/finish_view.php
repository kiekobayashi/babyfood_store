<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入完了ページ</title>
    <link type="text/css" rel="stylesheet" href="./customer.css">
</head>
<body>
    <header>
        <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    </header>
    <div class="content">
<?php if (count($err_msg) > 0) { ?>
    <ul>
    <?php foreach ($err_msg as $value) { ?>
        <li><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
<?php if (count($scs_msg) > 0) { ?>
    <ul>
    <?php foreach ($scs_msg as $value) { ?>
        <li><?php print $value; ?></li>
    <?php } ?>
    </ul>
<?php } ?>
<?php if (count($err_msg) === 0) { ?>
        <div class="finish-msg">ご購入ありがとうございました。</div>
        <div class="cart-list-title">
            <span class="cart-list-price">価格</span>
            <span class="cart-list-num">数量</span>
        </div>
            <ul class="cart-list">
    <?php foreach ($cart_data as $value) { ?>
                <li>
                    <div class="cart_item">
                        <img class="itemimage" src="<?php print $img_dir . htmlspecialchars($value['img'], ENT_QUOTES, 'UTF-8'); ?>">
                        <span class="cart-item-name"><?php print htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8'); ?></span>
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
<?php } ?>
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