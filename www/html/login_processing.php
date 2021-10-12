<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){
  redirect_to(TOP_URL);
}

$name = get_post('name');
$password = get_post('password');
$token = get_post('token');

if (is_valid_csrf_token($token) === false) {
  set_error('トークンが不正です');
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = login_as($db, $name, $password);
if($user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

set_message('ログインしました。');
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(MANAGE_URL);
}
redirect_to(TOP_URL);