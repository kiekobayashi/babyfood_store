<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品情報ページ</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
    <header>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    </header>
    <div class="content">
<?php include VIEW_PATH . 'templates/messages.php'; ?>
        <div class="detail_item">
            <form class="detail_item_form" action="./detail.php" method="post">
                <div class="detail_image"><img src="<?php print(IMAGE_PATH . $item['img']); ?>" ></div>
                <div class="detail_right">
                    <p class="detail_name"><?php print h($item['name']); ?></p>
    <?php if ($item['age'] === 0) { ?>                
                    <p class="detail_age">ごっくん期（５ヶ月〜）</p>
    <?php } else if ($item['age'] === 1) { ?>                
                    <p class="detail_age">【もぐもぐ期（７ヶ月〜）】</p>
    <?php } else if ($item['age'] === 2) { ?>
                    <p class="detail_age">【かみかみ期（９ヶ月〜）】</p>
    <?php } ?>
                    <p class="detail_comment"><?php print h($item['comment']); ?></p>
                    <p class="detail_price"><?php print $item['price']; ?>円</p>
    <?php if ($item['stock'] > 0) { ?>
                    <input class="detail_cart" type="submit" value="カートに入れる">
                    <input type="hidden" name="item_id" value="<?php print $item['id']; ?>">
                    <input type="hidden" name="sql_kind" value="insert">
                    <input type="hidden" name="token" value="<?php print h($token); ?>">
    <?php } else { ?>         
                    <span class="red">SOLD OUT</span>
                </div>
    <?php } ?>
            </form>
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