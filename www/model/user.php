<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user($db, $id){
  $sql = "
    SELECT
      id, 
      name,
      password,
      type
    FROM
      users
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':id' => $id);
  return fetch_query($db, $sql, $params);
}

function get_all_users($db){
  $sql = "
    SELECT
      id, 
      name,
      createdate
    FROM
      users
  ";
  return fetch_all_query($db, $sql);
}


function get_user_by_name($db, $name){
  $sql = "
    SELECT
      id, 
      name,
      password,
      type
    FROM
      users
    WHERE
      name = :name
    LIMIT 1
  ";
  $params = array(':name' => $name);
  return fetch_query($db, $sql, $params);
}

function login_as($db, $name, $password){
  $user = get_user_by_name($db, $name);
  if($user === false || $user['password'] !== $password){
    return false;
  }
  set_session('id', $user['id']);
  return $user;
}

function get_login_user($db){
  $login_user_id = get_session('id');

  return get_user($db, $login_user_id);
}

function regist_user($db, $name, $password) {
  if( is_valid_user($name, $password) === false){
    return false;
  }
  
  return insert_user($db, $name, $password);
}

function is_admin($user){
  return $user['type'] === USER_TYPE_ADMIN;
}

function is_valid_user($name, $password){
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($name);
  $is_valid_password = is_valid_password($password);
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

function is_valid_password($password){
  $is_valid = true;
  if(is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false){
    set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  if(is_alphanumeric($password) === false){
    set_error('パスワードは半角英数字で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function insert_user($db, $name, $password){
  $sql = "
    INSERT INTO
      users(name, password)
    VALUES (:name, :password);
  ";
  $params = array(':name' => $name, ':password' => $password);
  return execute_query($db, $sql, $params);
}
