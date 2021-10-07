<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user($db, $user_id){
  $sql = "
    SELECT
      id, 
      user_name,
      password
    FROM
      users
    WHERE
      id = :user_id
    LIMIT 1
  ";
  $params = array(':user_id' => $user_id);
  return fetch_query($db, $sql, $params);
}

function get_user_by_name($db, $user_name){
  $sql = "
    SELECT
      id, 
      user_name,
      password
    FROM
      users
    WHERE
      user_name = :user_name
    LIMIT 1
  ";
  $params = array(':user_name' => $user_name);
  return fetch_query($db, $sql, $params);
}

function login_as($db, $user_name, $password){
  $user = get_user_by_name($db, $user_name);
  if($user === false || $user['password'] !== $password){
    return false;
  }
  set_session('user_id', $user['user_id']);
  return $user;
}

function get_login_user($db){
  $login_user_id = get_session('user_id');

  return get_user($db, $login_user_id);
}

function regist_user($db, $name, $password, $password_confirmation) {
  if( is_valid_user($name, $password, $password_confirmation) === false){
    return false;
  }
  
  return insert_user($db, $name, $password);
}

function is_admin($user){
  return $user['type'] === USER_TYPE_ADMIN;
}

function is_valid_user($name, $password, $password_confirmation){
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($name);
  $is_valid_password = is_valid_password($password, $password_confirmation);
  return $is_valid_user_name && $is_valid_password ;
}

function is_valid_user_name($name) {
  $is_valid = true;
  if(is_valid_length($name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false){
    set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  if(is_alphanumeric($name) === false){
    set_error('ユーザー名は半角英数字で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_password($password, $password_confirmation){
  $is_valid = true;
  if(is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false){
    set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  if(is_alphanumeric($password) === false){
    set_error('パスワードは半角英数字で入力してください。');
    $is_valid = false;
  }
  if($password !== $password_confirmation){
    set_error('パスワードがパスワード(確認用)と一致しません。');
    $is_valid = false;
  }
  return $is_valid;
}

function insert_user($db, $user_name, $password){
  $sql = "
    INSERT INTO
      users(user_name, password)
    VALUES (:user_name, :password);
  ";
  $params = array(':user_name' => $user_name, ':password' => $password);
  return execute_query($db, $sql, $params);
}
