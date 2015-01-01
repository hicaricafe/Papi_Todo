<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
connectDb();

$id = $_POST['id'];
$title = $_POST['title'];

$rs = mysql_query(sprintf("update tasks set title='%s' where id=%d", r($title), r($id)));

