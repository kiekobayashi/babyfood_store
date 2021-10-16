<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'order.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$order_id = get_post('order_id');

// ユーザーは識別せずに読み込み
$order = get_order($db, $order_id);

if (empty($order) === true){
  set_message('このページは表示できません');
  redirect_to(ORDER_URL);
}
// ユーザーが不正の場合リダイレクト
if(is_admin($user) === false && $order['user_id'] !== $user['id']){
  set_message('このページは表示できません');
  redirect_to(ORDER_URL); 
}

$order_details = get_order_detail($db, $order_id);

include_once VIEW_PATH . 'order_detail_view.php';