<?php

function connectDb() {
    mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("can't connect to DB: ".mysql_error());
    mysql_select_db(DB_NAME) or die("can't select DB: ".mysql_error());
}

function r($s) {
    return mysql_real_escape_string($s);
}

function h($s) {
    return htmlspecialchars($s);
}