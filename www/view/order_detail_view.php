<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>購入履歴明細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'customer.css'); ?>">
</head>
<body>
  <header>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  </header>
  <div class="content">
    <h1>購入明細</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <table>
        <thead>
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php print ($order['order_id']); ?></td>
            <td><?php print ($order['created']); ?></td>
            <td><?php print ($order['total']); ?>円</td>
          </tr>
        </tbody>
      </table>
      <table class='order_detail'>
        <thead>
          <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($order_details as $order_detail){ ?>
          <tr>
            <td><?php print ($order_detail['name']); ?></td>
            <td><?php print ($order_detail['price']); ?>円</td>
            <td><?php print ($order_detail['amount']); ?></td>
            <td><?php print ($order_detail['subtotal']); ?>円</td>
          </tr>
          <?php } ?> 
        </tbody>
      </table>
  </div>
</body>
</html>