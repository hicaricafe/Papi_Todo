<?php

/*

create database dotinstall_todo_app;
grant all privileges on dotinstall_todo_app.* to dbuser@localhost identified by '********';

create table tasks (
    id int not null auto_increment primary key,
    seq int not null,
    type enum('notyet', 'done', 'deleted') default 'notyet',
    title text,
    created datetime,
    modified datetime,
    KEY type(type),
    KEY seq(seq)
);

insert into tasks (seq, type, title, created, modified) values (1, 'notyet', 'test 1', now(), now());
insert into tasks (seq, type, title, created, modified) values (2, 'notyet', 'test 2', now(), now());
insert into tasks (seq, type, title, created, modified) values (3, 'done', 'test 3', now(), now());


*/

// DB関連設定

define('DB_HOST', 'localhost');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'dotinstall_todo_app');

// エラー表示

error_reporting(E_ALL & ~E_NOTICE);
