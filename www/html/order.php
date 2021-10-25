<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'order.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$token = get_csrf_token();

$order_id = get_post('order_id');

if (is_valid_csrf_token($token) === false) {
  set_error('トークンが不正です');
  redirect_to(TOP_URL);
}  

if(is_admin($user) === false){
    $orders = get_orders($db, $user['id']);
} else {
    $orders = get_admin_orders($db);
}

include_once VIEW_PATH . 'order_view.php';