<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ユーザ管理ページ</title>
        <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'manage.css'); ?>">
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
<?php foreach ($users as $value) { ?>
            <tr>
                <td class="name_width"><?php print h($value['name']); ?></td>
                <td ><?php print $value['createdate']; ?></td>
            </tr>
<?php } ?>
        </table>
    </body>
</html>