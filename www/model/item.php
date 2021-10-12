<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

function get_item($db, $item_id){
  $sql = "
    SELECT
      id, 
      name,
      stock,
      price,
      img,
      status
    FROM
      items
    WHERE
      id = :id
  ";
  $params = array(':id' => $id);
  return fetch_query($db, $sql, $params);
}

function get_items($db, $is_open = false){
  $sql = '
    SELECT
      id, 
      name,
      comment,
      stock,
      price,
      img,
      status,
      age
    FROM
      items
  ';
  if($is_open === true){
    $sql .= '
      WHERE status = 1
    ';
  }

  return fetch_all_query($db, $sql);
}

function get_all_items($db){
  return get_items($db);
}

function get_open_items($db){
  return get_items($db, true);
}

function regist_item($db, $name, $comment, $price, $stock, $status, $image, $age){
  $filename = get_upload_filename($image);
  if(validate_item($name, $comment, $price, $stock, $filename, $status, $age) === false){
    return false;
  }
  return regist_item_transaction($db, $name, $comment, $price, $stock, $status, $image, $filename, $age);
}

function regist_item_transaction($db, $name, $comment, $price, $stock, $status, $image, $filename, $age){
  $db->beginTransaction();
  if(insert_item($db, $name, $comment, $price, $stock, $filename, $status, $age) 
    && save_image($image, $filename)){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
  
}

function insert_item($db, $name, $comment, $price, $stock, $filename, $status, $age){
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  $sql = "
    INSERT INTO
      items(
        name,
        comment,
        price,
        stock,
        img,
        status,
        age
      )
    VALUES(:name, :comment, :price, :stock, :filename, :status_value, :age);
  ";
  $params = array(':name' => $name, ':comment' => $comment, ':price' => $price, ':stock' => $stock, ':filename' => $filename, ':status_value' => $status_value, ':age' => $age);
  return execute_query($db, $sql, $params);
}

function update_item_status($db, $id, $status){
  $sql = "
    UPDATE
      items
    SET
      status = :status
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':status' => $status, ':id' => $id);
  return execute_query($db, $sql, $params);
}

function update_item_stock($db, $id, $stock){
  $sql = "
    UPDATE
      items
    SET
      stock = :stock
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':stock' => $stock, ':id' => $id);
  return execute_query($db, $sql, $params);
}

function update_item_age($db, $id, $age){
  $sql = "
    UPDATE
      items
    SET
      age = :age
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':age' => $age, ':id' => $id);
  return execute_query($db, $sql, $params);
}

function destroy_item($db, $id){
  $item = get_item($db, $id);
  if($item === false){
    return false;
  }
  $db->beginTransaction();
  if(delete_item($db, $item['id'])
    && delete_image($item['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

function delete_item($db, $id){
  $sql = "
    DELETE FROM
      items
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':id' => $id);
  return execute_query($db, $sql, $params);
}

function get_ranking($db){
  $sql = "
    SELECT 
      items.id,
      items.name,
      items.img
    FROM   
      order_details
    JOIN   
      items
    ON     
      order_details.item_id = items.id
    GROUP BY
      item_id
    ORDER BY
      SUM(order_details.amount) desc
    LIMIT 3
  ";
  return fetch_all_query($db, $sql);
}


// 非DB

function is_open($item){
  return $item['status'] === 1;
}

function validate_item($name, $price, $stock, $filename, $status){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);

  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}

function is_valid_item_name($name){
  $is_valid = true;
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_price($price){
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_stock($stock){
  $is_valid = true;
  if(is_positive_integer($stock) === false){
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_filename($filename){
  $is_valid = true;
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_status($status){
  $is_valid = true;
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}