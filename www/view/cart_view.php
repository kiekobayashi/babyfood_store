<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ショッピングカートページ</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    </header>
    <div class="content">
        <h1 class="title">ショッピングカート</h1>
<?php include VIEW_PATH . 'templates/messages.php'; ?>
<?php if (count($carts) === 0) { ?>
        <p>商品はありません。</p>
<?php } ?>
        <div class="cart-list-title">
            <span class="cart-list-price">価格</span>
            <span class="cart-list-num">数量</span>
        </div>
<?php foreach ($carts as $value) { ?>
        <ul class="cart-list">
            <li>
                <div class="cart_item">
                    <img class="itemimage" src="<?php print(IMAGE_PATH . $value['img']); ?>">
                    <span class="cart-item-name"><?php print h($value['name']); ?></span>
                    <form class="cart-item-del" action="./cart.php" method="post">
                        <input type="submit" value="削除">
                        <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
                        <input type="hidden" name="sql_kind" value="delete_cart">
                    </form>
                    <span class="cart-item-price">¥<?php print $value['price']; ?></span>
                    <form class="form_select_amount" id="form_select_amount4" action="./cart.php" method="post">
                        <input type="text" class="cart-item-num2" min="0" name="amount" value="<?php print $value['amount']; ?>">個&nbsp;<input type="submit" value="変更する">
                        <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
                        <input type="hidden" name="sql_kind" value="change_cart">
                  </form>
                </div>
            </li>
        </ul>
<?php } ?>
        <div class="buy-sum-box">
            <span class="buy-sum-title">合計</span>
            <span class="buy-sum-price">¥<?php print $total_price; ?></span>
        </div>
        <form action="./finish.php" method="post">
            <input class="buy-btn" type="submit" value="購入する">
        </form>
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