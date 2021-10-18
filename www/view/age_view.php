<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品一覧ページ</title>
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    <header>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
        <ul class="select_age"> 
            <a href="./age.php?age=0"><li class="age_list age_0">ごっくん期</li></a>
            <a href="./age.php?age=1"><li class="age_list age_1">もぐもぐ期</li></a>
            <a href="./age.php?age=2"><li class="age_list age_2">かみかみ期</li></a>
        </ul>
    </header>
    <div class="content">
<?php if ($age === '0') { ?>
        <h2>ごっくん期（５ヶ月〜）</h2>
<?php } ?>
<?php if ($age === '1') { ?>
        <h2>もぐもぐ期（７ヶ月〜）</h2>
<?php } ?>
<?php if ($age === '2') { ?>
        <h2>かみかみ期（９ヶ月〜）</h2>
<?php } ?>
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
        <ul class="item-list">
            <li>
<?php foreach ($item_data as $value) { ?>
                <div class="item">
                    <form method="post">
                        <a href="./detail.php?id=<?php print $value['id']; ?>"><img class="itemimage" src="<?php print $img_dir . htmlspecialchars($value['img'], ENT_QUOTES, 'UTF-8'); ?>" ></a>
                        <div>
                            <p><?php print htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8'); ?></p>
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
