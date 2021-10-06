<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_orders($db, $user_id){
    $sql = "
      SELECT
        orders.order_id,
        orders.created,
        SUM(order_details.price * order_details.amount) AS total
      FROM
        orders
      JOIN
        order_details
      ON
        orders.order_id = order_details.order_id
      WHERE
        user_id = :user_id
      GROUP BY
        order_id
      ORDER BY
        created desc
    ";
    $params = array(':user_id' => $user_id);
    return fetch_all_query($db, $sql, $params);
  }

  function get_admin_orders($db){
    $sql = "
      SELECT
        orders.order_id,
        orders.created,
        SUM(order_details.price * order_details.amount) AS total
      FROM
        orders
      JOIN
        order_details
      ON
        orders.order_id = order_details.order_id
      GROUP BY
        order_id
      ORDER BY
        created desc
    ";
    return fetch_all_query($db, $sql);
  }

  function get_order_detail($db, $order_id){
    $sql = "
      SELECT
        order_details.price,
        order_details.amount,
        SUM(order_details.price * order_details.amount) AS subtotal,
        items.name
      FROM
        order_details
      JOIN
        items
      ON
        order_details.item_id = items.id
      WHERE
        order_details.order_id = :order_id
      GROUP BY
        order_details.price, order_details.amount, items.name
    ";
    $params = array(':order_id' => $order_id);
    return fetch_all_query($db, $sql, $params);
  }

  function get_order($db, $order_id){
    $sql = "
      SELECT
        orders.order_id,
        orders.user_id,
        orders.created,
        SUM(order_details.price * order_details.amount) AS total
      FROM
        orders
      JOIN
        order_details
      ON
        orders.order_id = order_details.order_id
      WHERE
        orders.order_id = :order_id
      GROUP BY
        orders.order_id
    ";
    $params = array(':order_id' => $order_id);
    return fetch_query($db, $sql, $params);
  }