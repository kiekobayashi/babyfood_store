<?php
// ユーザー登録ページ

$data       = array();
$err_msg    = array();
$scs_msg    = array();
$user_name  = '';
$passwd     = '';
$date       = date('Y-m-d H:i:s');

$host       = 'localhost';
$username   = 'codecamp47639';   // MySQLのユーザ名
$password   = 'codecamp47639';       // MySQLのパスワード
$dbname     = 'codecamp47639';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
$charset    = 'utf8';   // データベースの文字コード

// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

try {
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // 入力値、ファイルをチェック
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['user_name']) === TRUE) {
            $user_name = trim($_POST['user_name']);
        }
        if (isset($_POST['password']) === TRUE) {
            $passwd = trim($_POST['password']);
        }
        
        if ($user_name === '') {
            $err_msg[] = 'ユーザー名は6文字以上の文字を入力してください';
        } else if (preg_match('/^[0-9a-z]{6,}$/', $user_name) !== 1) {
            $err_msg[] = 'ユーザー名は6文字以上の文字を入力してください';
        }

        if ($passwd === '') {
            $err_msg[] = 'パスワードは6文字以上の文字を入力してください';
        } else if (preg_match('/^[0-9a-z]{6,}$/', $passwd) !== 1) {
            $err_msg[] = 'パスワードは6文字以上の文字を入力してください';
        }

        // ユーザ名の重複をチェック
        $sql = 'SELECT user_name, password, createdate
                FROM users
                WHERE user_name = :user_name';
        $stmt = $dbh->prepare($sql);
        $stmt ->execute(array(':user_name'=>$user_name));
        $data = $stmt->fetchAll();
        if (count($data) > 0) {
            $err_msg[] = 'このユーザ名は既に登録されています';
        }

        if (count($err_msg) === 0) {
            try {
                // SQL文を作成
                $sql = 'INSERT INTO users (user_name, password, createdate)
                        VALUES(?, ?, ?)';
                // SQL文を実行する準備
                $stmt = $dbh->prepare($sql);
                // SQL文のプレースホルダに値をバインド
                $stmt->bindValue(1, $user_name,         PDO::PARAM_STR);
                $stmt->bindValue(2, $passwd,            PDO::PARAM_STR);
                $stmt->bindValue(3, $date,              PDO::PARAM_STR);
                $stmt->execute();
                
                $scs_msg[] = 'アカウント作成を完了しました';
            } catch (PDOException $e) {
                // ロールバック処理
                $dbh->rollback();
                // 例外をスロー
                throw $e;
            }
        } // エラーが０の時の終了
    }
} catch (PDOException $e) {
  $err_msg[] = '接続できませんでした。理由：'.$e->getMessage();
}

?>