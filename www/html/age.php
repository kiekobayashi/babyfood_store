<?php
// 月齢別商品一覧画面

$date       = date('Y-m-d H:i:s');
$img_dir    = './img/';
$user_data  = array();
$item_data  = array();
$cart_data  = array();
$err_msg    = array();
$scs_msg    = array();
$item_id    = '';
$age        = '';

$host       = 'localhost';
$username   = 'codecamp47639';   // MySQLのユーザ名
$password   = 'codecamp47639';       // MySQLのパスワード
$dbname     = 'codecamp47639';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
$charset    = 'utf8';   // データベースの文字コード

// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

// セッション開始
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // 非ログインの場合、ログインページへリダイレクト
    header('Location: ./login.php');
    exit;
}

try {
    // DB接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // ユーザー情報読み込み
    $sql = 'SELECT user_name
            FROM users
            WHERE users.id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_id,     PDO::PARAM_INT);
    $stmt ->execute();
    $user_data = $stmt->fetchAll();
    
    // ユーザ名を取得できたか確認
    if (isset($user_data[0]['user_name'])) {
        $user_name = $user_data[0]['user_name'];
    } else {
        // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
        header('Location: ./logout.php');
        exit;
    }
    
    // 入力値、ファイルをチェック
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id']) === TRUE) {
            $item_id = trim($_POST['id']);
        }
        if ($item_id === '') {
            $err_msg[] = '商品が見つかりません';
        } else if (preg_match('/^[1-9][0-9]*$/', $item_id) !== 1) {
            $err_msg[] = '商品が見つかりません';
        }
        if (isset($_POST['sql_kind']) === TRUE) {
            $sql_kind = trim($_POST['sql_kind']);
        }
        if ($sql_kind === 'insert') {
            if (count($err_msg) === 0) {
                // 同一データがあるか確認
                $sql = 'SELECT  item_id
                        FROM    carts
                        WHERE   user_id = ?
                        AND     item_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $user_id,   PDO::PARAM_INT);
                $stmt->bindValue(2, $item_id,   PDO::PARAM_INT);
                $stmt ->execute();
                $cart_data = $stmt->fetchAll();

                try {
                    if (count($cart_data) === 0) {
                        // SQL文を作成
                        $sql = 'INSERT INTO carts (user_id, item_id, amount, createdate)
                                VALUES(?, ?, ?, ?)';
                        // SQL文を実行する準備
                        $stmt = $dbh->prepare($sql);
                        // SQL文のプレースホルダに値をバインド
                        $stmt->bindValue(1, $user_id,           PDO::PARAM_INT);
                        $stmt->bindValue(2, $item_id,           PDO::PARAM_INT);
                        $stmt->bindValue(3, 1,                  PDO::PARAM_INT);
                        $stmt->bindValue(4, $date,              PDO::PARAM_STR);
                        $stmt->execute();
                        $scs_msg[] = 'カートに登録しました';
                    } else {
                        $sql = 'UPDATE  carts
                                SET     amount = amount + 1
                                WHERE   item_id = ?';
                        $stmt = $dbh->prepare($sql);
                        // SQL文のプレースホルダに値をバインド
                        $stmt->bindValue(1, $item_id,           PDO::PARAM_INT);
                        $stmt->execute();
                        $scs_msg[] = 'カートに追加しました';
                    }
                } catch (PDOException $e) {
                    // 例外をスロー
                    $err_msg[] = 'カートの登録に失敗しました。理由：' . $e->getMessage();
                }
            } // エラーが０の時の終了
        } // insertの終了
    } // POSTの終了
    
    if (isset($_GET['age']) === TRUE) {
        $age = trim($_GET['age']);
    }
    if ($age !== '') {
        if (preg_match('/^[012]$/', $age) !== 1) {
            $age = '';
        }
    }

    // 商品情報読み込み
    $sql = 'SELECT  id, name, price, img, status, stock 
            FROM    items
            WHERE   status = 1';
    if ($age !== '') {
        $sql .= ' AND     age = ' . $age;
    }
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();
    $item_data = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $err_msg[] = '接続できませんでした。理由：' . $e->getMessage();
}

?>