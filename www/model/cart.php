<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.img,
      carts.id,
      carts.user_id,
      carts.item_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.id
    WHERE
      carts.user_id = :user_id
  ";
  $params = array(':user_id' => $user_id);
  return fetch_all_query($db, $sql, $params);
}

function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.img,
      carts.id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.id
    WHERE
      carts.user_id = :user_id
    AND
      items.id = :item_id
  ";
  $params = array(':user_id' => $user_id, ':item_id' => $item_id);
  return fetch_query($db, $sql, $params);

}

function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['id'], $cart['amount'] + 1);
}

function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(:item_id, :user_id, :amount)
  ";
  $params = array(':item_id' => $item_id, ':user_id' => $user_id, ':amount' => $amount);
  return execute_query($db, $sql, $params);
}

function update_cart_amount($db, $id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = :amount
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':id' => $id, ':amount' => $amount);
  return execute_query($db, $sql, $params);
}

function delete_cart($db, $id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      id = :id
    LIMIT 1
  ";
  $params = array(':id' => $id);
  return execute_query($db, $sql, $params);
}

function purchase_carts($db, $carts){
  if(validate_cart_purchase($carts) === false){
    return false;
  }

  $db->beginTransaction();

  insert_orders($db, $carts[0]['user_id']);
  $order_id = $db->lastInsertId();
  
  foreach($carts as $cart){
    insert_order_details($db, $order_id, $cart['item_id'], $cart['price'], $cart['amount']);
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . '?????????????????????????????????');
    }
  }

  delete_user_carts($db, $carts[0]['user_id']);

  if(has_error() === false) {
    $db->commit();
    return true;
  } else {
    $db->rollback();
    return false;
  }
}

function insert_orders($db, $user_id) {
  $sql = "
    INSERT INTO
      orders(
        user_id
      )
    VALUES (:user_id)
    ";
    $params = array(':user_id' => $user_id);
    return execute_query($db, $sql, $params);
  
}

function insert_order_details($db, $order_id, $item_id, $price, $amount) {
  $sql = "
    INSERT INTO
      order_details(
        order_id,
        item_id,
        price,
        amount
      )
    VALUES (:order_id, :item_id, :price, :amount)
    ";
    $params = array(':order_id' => $order_id, ':item_id' => $item_id, ':price' => $price, ':amount' => $amount);
    return execute_query($db, $sql, $params);  
}

function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = :user_id
  ";
  $params = array(':user_id' => $user_id);
  execute_query($db, $sql, $params);
}


function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts){
  if(count($carts) === 0){
    set_error('?????????????????????????????????????????????');
    return false;
  }
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . '?????????????????????????????????');
    }
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . '?????????????????????????????????????????????:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}