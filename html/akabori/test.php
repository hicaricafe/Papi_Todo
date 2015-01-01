<?php

try {
$dbh = new PDO('mysql:host=localhost;dbname=blog_app', 'dbuser', 'password');
} catch (PDOException $e) {
	var_dump($e->getMessage());
	exit;
}

echo "success";

$stmt = $dbh->prepare("update users set email = :email where name like :name");
$stmt->execute(array(":email"=>"dummy", ":name"=>"n%"));

$stmt = $dbh->prepare("delete from users where password = :password");
$stmt -> execute(array(":password"=>"p10"));

echo $stmt->rowCount() . "record deleted";

echo "done";



$dbh = null;