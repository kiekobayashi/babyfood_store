<?php
// 商品管理ページ

$date       = date('Y-m-d H:i:s');
$img_dir    = './img/';
$data       = array();
$err_msg    = array();
$scs_msg    = array();
$sql_kind   = '';
$name       = '';
$price      = '';
$comment    = '';
$stock      = '';
$age        = '';
$id         = '';
$status     = '';
$img        = '';   // アップロードした新しい画像ファイル名

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
    // データベースに接続
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
    // 入力値、ファイルをチェック
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['sql_kind']) === TRUE) {
            $sql_kind = trim($_POST['sql_kind']);
        }
        if ($sql_kind === 'insert') {
            if (isset($_POST['name']) === TRUE) {
                $name = trim($_POST['name']);
            }
            if (isset($_POST['comment']) === TRUE) {
                $comment = trim($_POST['comment']);
            }
            if (isset($_POST['price']) === TRUE) {
                $price = trim($_POST['price']);
            }
            if (isset($_POST['stock']) === TRUE) {
                $stock = trim($_POST['stock']);
            }
            if (isset($_POST['age']) === TRUE) {
                $age = trim($_POST['age']);
            }
            if (isset($_POST['status']) === TRUE) {
                $status = trim($_POST['status']);
            }
            if ($name === '') {
                $err_msg[] = '名前を入力してください';
            }
            if ($comment === '') {
                $err_msg[] = '商品情報を入力してください';
            }
            if ($price === '') {
                $err_msg[] = '値段を入力してください';
            } else if (preg_match('/^([1-9][0-9]*|0)$/', $price) !== 1) {
                $err_msg[] = '値段は０以上の整数を入力してください';
            }
            if ($stock === '') {
                $err_msg[] = '個数を入力してください';
            } else if (preg_match('/^([1-9][0-9]*|0)$/', $stock) !== 1) {
                $err_msg[] = '個数は０以上の整数を入力してください';
            }
            if ($age === '') {
                $err_msg[] = '月齢を入力してください';
            } else if (preg_match('/^[012]$/', $age) !== 1) {
                $err_msg[] = '月齢を入力できませんでした';
            }
            if ($status === '') {
                $err_msg[] = 'ステータスを入力してください';
            } else if (preg_match('/^[01]$/', $status) !== 1) {
                $err_msg[] = 'ステータスを入力できませんでした';
            }
            if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE ) {
                $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
                if (preg_match('/^(jpeg|jpg|png)$/', $extension) === 1) {
                    $img = sha1(uniqid(mt_rand(), true)) . '.' . $extension;
                    if (is_file ($img_dir . $img) !== TRUE) {
                        if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $img) !== TRUE) {
                            $err_msg[] = 'ファイルアップロードに失敗しました';
                        }
                    } else {
                        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                    }
                } else {
                    $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEGかPNGのみ利用可能です。';
                }
            } else {
                $err_msg[] = 'ファイルを選択してください';
            }
            
            if (count($err_msg) === 0) {
                try {
                    // SQL文を作成
                    $sql = 'INSERT INTO items (name, price, img, status, stock, age, comment, createdate)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
                    // SQL文を実行する準備
                    $stmt = $dbh->prepare($sql);
                    // SQL文のプレースホルダに値をバインド
                    $stmt->bindValue(1, $name,              PDO::PARAM_STR);
                    $stmt->bindValue(2, $price,             PDO::PARAM_INT);
                    $stmt->bindValue(3, $img,               PDO::PARAM_STR);
                    $stmt->bindValue(4, $status,            PDO::PARAM_INT);
                    $stmt->bindValue(5, $stock,             PDO::PARAM_INT);
                    $stmt->bindValue(6, $age,               PDO::PARAM_INT);
                    $stmt->bindValue(7, $comment,           PDO::PARAM_STR);
                    $stmt->bindValue(8, $date,              PDO::PARAM_STR);
                    $stmt->execute();
                    
                    $scs_msg[] = 'データが登録できました';
                } catch (PDOException $e) {
                    // ロールバック処理
                    $dbh->rollback();
                    // 例外をスロー
                    throw $e;
                }
            } // エラーが０の時の終了
        } // インサートの終了
        
        if ($sql_kind === 'update') {
            if (isset($_POST['stock']) === TRUE) {
                $stock = trim($_POST['stock']);
            }
            if (isset($_POST['id']) === TRUE) {
                $id = trim($_POST['id']);
            }
            if ($stock === '') {
                $err_msg[] = '個数を入力してください';
            } else if (preg_match('/^([1-9][0-9]*|0)$/', $stock) !== 1) {
                $err_msg[] = '個数は０以上の整数を入力してください';
            }
            if ($id === '') {
                $err_msg[] = '商品を選択してください';
            } else if (preg_match('/^[1-9][0-9]*$/', $id) !== 1) {
                $err_msg[] = '商品が見つかりません';
            }
            if (count ($err_msg) === 0) {
                try {
                    $sql = 'UPDATE items
                            SET stock = ?,
                                updatedate = ?
                            WHERE id = ?';
                            
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $stock,         PDO::PARAM_INT);
                    $stmt->bindValue(2, $date,          PDO::PARAM_STR);
                    $stmt->bindValue(3, $id,            PDO::PARAM_INT);
    
                    $stmt ->execute();
                    $scs_msg[] = '在庫変更成功';
    
                } catch (PDOException $e) {
                    $err_msg[] = '更新できませんでした　理由：'.$e->getMessage();
                }
            } // エラーが０の時終了
        } // アップデートの終了

        if ($sql_kind === 'change') {
            if (isset($_POST['status']) === TRUE) {
                $status = trim($_POST['status']);
            }
            if (isset($_POST['id']) === TRUE) {
                $id = trim($_POST['id']);
            }
            if ($status === '') {
                $err_msg[] = 'ステータスを選択してください';
            } else if (preg_match('/^[01]$/', $status) !== 1) {
                $err_msg[] = 'ステータスを入力できませんでした';
            }
            if ($id === '') {
                $err_msg[] = '商品を選択してください';
            } else if (preg_match('/^[1-9][0-9]*$/', $id) !== 1) {
                $err_msg[] = '商品が見つかりません';
            }
            if (count ($err_msg) === 0) {
                try {
                    $sql = 'UPDATE items
                            SET status = ?,
                                updatedate = ?
                            WHERE id = ?';
                            
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $status,        PDO::PARAM_INT);
                    $stmt->bindValue(2, $date,          PDO::PARAM_STR);
                    $stmt->bindValue(3, $id,            PDO::PARAM_INT);
    
                    $stmt ->execute();
                    $scs_msg[] = 'ステータス変更成功';
    
                } catch (PDOException $e) {
                    $err_msg[] = '更新できませんでした　理由：'.$e->getMessage();
                }
            } // エラーが０の時終了
        } // ステータス変更の終了
        
        if ($sql_kind === 'change_age') {
            if (isset($_POST['age']) === TRUE) {
                $age = trim($_POST['age']);
            }
            if (isset($_POST['id']) === TRUE) {
                $id = trim($_POST['id']);
            }
            if ($age === '') {
                $err_msg[] = '月齢を選択してください';
            } else if (preg_match('/^[012]$/', $age) !== 1) {
                $err_msg[] = '月齢を入力できませんでした';
            }
            if ($id === '') {
                $err_msg[] = '商品を選択してください';
            } else if (preg_match('/^[1-9][0-9]*$/', $id) !== 1) {
                $err_msg[] = '商品が見つかりません';
            }
            if (count ($err_msg) === 0) {
                try {
                    $sql = 'UPDATE items
                            SET age = ?,
                                updatedate = ?
                            WHERE id = ?';
                            
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $age,           PDO::PARAM_INT);
                    $stmt->bindValue(2, $date,          PDO::PARAM_STR);
                    $stmt->bindValue(3, $id,            PDO::PARAM_INT);
    
                    $stmt ->execute();
                    $scs_msg[] = '月齢変更成功';
    
                } catch (PDOException $e) {
                    $err_msg[] = '更新できませんでした　理由：'.$e->getMessage();
                }
            } // エラーが０の時終了
        } // ステータス変更の終了
        
        if ($sql_kind === 'delete') {
            if (isset($_POST['id']) === TRUE) {
                $id = trim($_POST['id']);
            }
            if (count ($err_msg) === 0) {
                try {
                    $sql = 'DELETE
                            FROM items
                            WHERE id = ?';
                            
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $id,            PDO::PARAM_INT);
    
                    $stmt ->execute();
                    $scs_msg[] = '削除しました';
                } catch (PDOException $e) {
                    $err_msg[] = '更新できませんでした　理由：'.$e->getMessage();
                }
            } // エラーが０の時終了
        } // 削除の終了
    } // POSTの終了

    $sql = 'SELECT id, name, comment, price, img, status, stock, age
            FROM items';
    $stmt = $dbh->prepare($sql);
    $stmt ->execute();
    $data = $stmt->fetchAll();
    
} catch (PDOException $e) {
  $err_msg[] = '接続できませんでした。理由：'.$e->getMessage();
}

?>