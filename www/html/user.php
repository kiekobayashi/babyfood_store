<?php
// ユーザー管理ページ

$data       = array();

$host       = 'localhost';
$username   = 'codecamp47639';   // MySQLのユーザ名
$password   = 'codecamp47639';       // MySQLのパスワード
$dbname     = 'codecamp47639';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
$charset    = 'utf8';   // データベースの文字コード

// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

// user_idがadminかどうかチェック
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if ($user_id !== 'admin') {
// print_r('dd');
// exit;
        header ('Location:./login.php');
        exit;
    }
} else {
// print_r('bb');
// exit;
    header ('Location:./login.php');
    exit;
}
// print_r('cc');
// exit;

try {
    // DB接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // 商品情報読み込み
    $sql = 'SELECT users.id, user_name, createdate 
            FROM users';
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();
    $data = $stmt->fetchAll();
    
}   catch (Exception $e) {
    $err_msg[] = $e->getMessage();
}

?>