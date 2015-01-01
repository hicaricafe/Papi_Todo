<?php

require_once('config.php');
require_once('functions.php');

// DBに接続
connectDb();

$rs = mysql_query("update tasks set type='deleted' where id = ".r($_POST['id']));

