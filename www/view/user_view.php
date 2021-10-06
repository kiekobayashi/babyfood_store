<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ユーザ管理ページ</title>
        <style>
        table {
          width: 750px;
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
        <h1>Baby Food Shop 管理ページ</h1>
        <p><a href="./manage.php">商品管理ページ</a></p>
        <p><a href="./logout.php">ログアウト</a></p>
        <table>
            <tr>
                <th>ユーザID</th>
                <th>登録日</th>
            </tr>
<?php foreach ($data as $value) { ?>
            <tr>
                <td class="name_width"><?php print htmlspecialchars($value['user_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td ><?php print $value['createdate']; ?></td>
            </tr>
<?php } ?>
        </table>
    </body>
</html>