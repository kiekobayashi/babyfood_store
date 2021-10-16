<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品購入履歴</title>
  <link type="text/css" rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
  <style>
    table {
      width: 960px;
      border-collapse: collapse;
    }
    table, tr, th, td {
      border: solid 1px;
      padding: 10px;
      text-align: center;
    }
    td img {
        max-height: 120px;
    }
  </style>
</head>
<body>
  <header>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  </header>
  <div class="content">
    <h1 class="title">購入履歴</h1>
      <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <?php if(!empty($orders)){ ?>
        <table>
          <thead>
            <tr>
              <th>注文番号</th>
              <th>購入日時</th>
              <th>合計金額</th>
              <th>購入明細</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $order){ ?>
            <tr>
              <td><?php print $order['order_id']; ?></td>
              <td><?php print $order['created']; ?></td>
              <td><?php print $order['total']; ?>円</td>
              <td>
                  <form method="post" action="order_detail.php">
                    <input class="btn btn-block btn-primary" type="submit" value="表示">
                    <input type="hidden" name="order_id" value="<?php print($order['order_id']); ?>">
                  </form>
              </td>
            </tr>
            <?php } ?> 
          </tbody>
        </table>
      <?php } else { ?>
        <p>購入履歴はありません。</p>
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