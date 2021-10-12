<?php
// 商品管理ページ

require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

$sql_kind = get_post('sql_kind');
$name = get_post('name');
$comment = get_post('comment');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
$age = get_post('age');
// $token = get_post('token');

$image = get_file('image');

// if (is_valid_csrf_token($token) === false) {
//     set_error('トークンが不正です');
//     redirect_to(MANAGE_URL);
// }
 
if ($sql_kind === 'insert') {
    if(regist_item($db, $name, $comment, $price, $stock, $status, $image, $age)){
    set_message('商品を登録しました。');
    }else {
    set_error('商品の登録に失敗しました。');
    }
}
                    
if ($sql_kind === 'update') {
    $stock = get_post('stock');
    $id = get_post('id');

    if(update_item_stock($db, $id, $stock)){
        set_message('在庫数を変更しました。');
      } else {
        set_error('在庫数の変更に失敗しました。');
      }      
}

if ($sql_kind === 'change') {
    $status = get_post('status');
    $id = get_post('id');

    update_item_status($db, $id, $status);
    set_message('ステータスを変更しました。');
  }
        
if ($sql_kind === 'change_age') {
    $age = get_post('age');
    $id = get_post('id');

    update_item_age($db, $id, $age);
    set_message('月齢を変更しました。');
}
        
if ($sql_kind === 'delete') {
    $id = get_post('id');

    if(destroy_item($db, $id) === true){
        set_message('商品を削除しました。');
      } else {
        set_error('商品削除に失敗しました。');
      }      
}

$items = get_all_items($db);   
    
include_once VIEW_PATH . '/manage_view.php';