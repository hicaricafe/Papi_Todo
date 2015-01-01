<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
connectDb();

// var_dump($_POST['task']);

parse_str($_POST['task']);

// var_dump($task);

foreach ($task as $key => $val) {
    mysql_query(sprintf("update tasks set seq=%d where id=%d",r($key),r($val)));
}

