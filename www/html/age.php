<?php
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

$age = get_get('age');
$items = get_open_age_items($db, $age);

$sql_kind = get_post('sql_kind');
$id = get_post('id');

if ($sql_kind === 'insert') {
    if(add_cart($db, $user['id'], $id)){
        set_message('カートに商品を追加しました。');
    }else {
        set_error('カートの追加に失敗しました。');
    }
}


include_once VIEW_PATH . 'age_view.php';