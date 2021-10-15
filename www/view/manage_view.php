<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品情報</title>
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
    div {
        border-top: solid 1px;
        border-bottom: solid 1px;
    }
    td img {
        max-height: 120px;
    }
    .status_false {
        background-color: #A9A9A9;
    }
    </style>
</head>
<body>
    <h1>Baby Food Store 管理ページ</h1>
    <p><a href="./user.php">ユーザ管理ページ</a></p>
    <p><a href="./logout.php">ログアウト</a></p>
    <h2>新規商品追加</h2>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <form method="post" enctype="multipart/form-data">
        <p>名前：<input type="text" name="name"></p>
        <p>商品情報：<input type="text" name="comment"></p>
        <p>値段：<input type="text" name="price"></p>
        <p>個数：<input type="text" name="stock"></p>
        <p><input type="file" name="image" value="ファイルを選択"></p>
        <p>
            <select name="status">
                <option value="close">非公開</option>
                <option value="open">公開</option>
            </select>
        </p>
        <p>
            <select name="age">
                <option value="first">ごっくん期</option>
                <option value="second">もぐもぐ期</option>
                <option value="last">かみかみ期</option>
            </select>
        </p>
        <p><input type="submit" name="submit" value="■□■□■商品追加■□■□■"></p>
        <input type="hidden" name="sql_kind" value="insert">
    </form>
</div>
    <h2>商品情報変更</h2>
    <table>
        <thread>
            <p>商品一覧</p>
            <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>商品情報</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>ステータス</th>
            <th>月齢</th>
            <th>操作</th>
            </tr>
        </thread>
        <tbody>
<?php foreach ($items as $value) { ?>
    <?php if ($value['status'] === 1) { ?>
        <tr>
    <?php } else { ?>
        <tr class="status_false">
    <?php } ?>
            <td><img src="<?php print(IMAGE_PATH . $value['img']); ?>"></td>
            <td><?php print h($value['name']); ?></td>
            <td><?php print h($value['comment']); ?></td>
            <td><?php print $value['price']; ?>円</td>
            <td>
                <form method="post">
                    <input type="text" name="stock" value="<?php print $value['stock']; ?>">個
                    <input type="submit" value="変更">
                    <input type="hidden" name="sql_kind" value="update">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
            <td>
                <form method="post">
    <?php if ($value['status'] === 1) { ?>
                    <input type="submit" value="公開 → 非公開">
                    <input type="hidden" name="status" value="0">
    <?php } else { ?>
                    <input type="submit" value="非公開 → 公開">
                    <input type="hidden" name="status" value="1">
    <?php } ?>
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="hidden" name="sql_kind" value="change">
                </form>
            </td>
            <td>
                <form method="post">
                    <select name="age">
                        <option value="0" <?php if ($value['age'] === 0) { print 'selected'; } ?>>ごっくん期</option>
                        <option value="1" <?php if ($value['age'] === 1) { print 'selected'; } ?>>もぐもぐ期</option>
                        <option value="2" <?php if ($value['age'] === 2) { print 'selected'; } ?>>かみかみ期</option>
                    </select>
                    <input type="submit" value="変更">
                    <input type="hidden" name="sql_kind" value="change_age">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
            <td>
                <form method="post">
                    <input type="submit" value="削除">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="hidden" name="sql_kind" value="delete">
                </form>
            </td>
        </tr>
<?php } ?>
        </tbody>
    </table>
</body>
</html>