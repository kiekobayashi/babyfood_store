<?php
// 購入完了ページ

$date           = date('Y-m-d H:i:s');
$img_dir        = './img/';
$user_data      = array();
$item_data      = array();
$cart_data      = array();
$err_msg        = array();
$scs_msg        = array();
$total_price    = 0;

$host        = 'localhost';
$username    = 'codecamp47639';   // MySQLのユーザ名
$password    = 'codecamp47639';       // MySQLのパスワード
$dbname      = 'codecamp47639';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
$charset     = 'utf8';   // データベースの文字コード

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = 'SELECT item_id, amount, img, name, price, status, stock
                FROM carts
                INNER JOIN items
                ON carts.item_id = items.id
                WHERE user_id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $user_id,   PDO::PARAM_INT);
        $stmt ->execute();
        $cart_data = $stmt->fetchAll();
        
        // 合計の算出
        foreach ($cart_data as $value) {
            $amount = $value['amount'];
            $price  = $value['price'];
            $total_price += $amount * $price;
        }
        
        // カート内にデータがあるか確認
        if (count($cart_data) > 0) {
            // カート内商品のチェック
            foreach ($cart_data as $value) {
                if ($value['status'] !== 1) {
                    $err_msg[] = 'カート内の商品は購入できません';
                }
                if ($value['stock'] < $value['amount']) {
                    $err_msg[] = 'カート内の商品の在庫が不足しています';
                }
            }
        } else {
            $err_msg[] = 'カート内に商品がありません';
        }
        
        if (count($err_msg) === 0) {
            // トランザクション開始
            $dbh->beginTransaction();
            
            try {
                foreach ($cart_data as $value) {
                    $amount  = $value['amount'];
                    $item_id = $value['item_id'];
                    
                    $sql = 'UPDATE items
                            SET stock = stock - ?,
                                updatedate = ?
                            WHERE id = ?';
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $amount,        PDO::PARAM_INT);
                    $stmt->bindValue(2, $date,          PDO::PARAM_INT);
                    $stmt->bindValue(3, $item_id,       PDO::PARAM_INT);
                    $stmt ->execute();
                }
    
                $sql = 'DELETE
                        FROM carts
                        WHERE user_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $user_id,       PDO::PARAM_INT);
                $stmt ->execute();
    
                // コミット処理
                $dbh->commit();
        
            } catch (PDOException $e) {
                // ロールバック処理
                $dbh->rollback();
                // 例外をスロー
                throw $e;
            }
        } // エラーが０の時の終了
    } else { // POSTの終了
        $err_msg[] = '処理が正しくありません';
    } // GETで来てたらエラー
} catch (PDOException $e) {
    $err_msg[] = '接続できませんでした。理由：' . $e->getMessage();
}

?>