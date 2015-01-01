<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
connectDb();

// データをつっこむ

// $title

$title = $_POST['title'];

// $seqを作る

$rs = mysql_query("select max(seq)+1 as c from tasks");
$row = mysql_fetch_assoc($rs);
$seq = $row['c'];

$rs = mysql_query(sprintf("insert into tasks (seq, title, created, modified) values (%d, '%s', now(), now())",$seq, r($title)));

echo mysql_insert_id();

