<?php
// カート画面

require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$token = get_csrf_token();

$carts = get_user_carts($db, $user['id']);

$total_price = sum_carts($carts);


$sql_kind = get_post('sql_kind');
$item_id = get_post('item_id');
$amount = get_post('amount');

if ($sql_kind === 'delete_cart') {
  if(delete_cart($db, $item_id)){
      set_message('商品を削除しました。');
  }else {
      set_error('商品の削除に失敗しました。');
  }
  redirect_to(CART_URL);
}

if ($sql_kind === 'change_cart') {
  if(update_cart_amount($db, $item_id, $amount)){
      set_message('数量を変更しました。');
  }else {
      set_error('数量の変更に失敗しました。');
  }
  redirect_to(CART_URL);
}


include_once VIEW_PATH . 'cart_view.php';
