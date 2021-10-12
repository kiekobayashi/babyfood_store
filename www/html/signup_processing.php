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

$db = get_db_connect();

// $token = get_post('token');

// if (is_valid_csrf_token($token) === false) {
//   set_error('トークンが不正です');
//   redirect_to(SIGNUP_URL);
// }

try{
  $result = regist_user($db, $name, $password);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(TOP_URL);