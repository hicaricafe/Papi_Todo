
create database printer;
grant all on printer.* to dbuser@localhost identified by "password";

use printer;

create table tasks(
	id int not null auto_increment primary key,
	seq int not null,
	type enum('notyet', 'done', 'deleted') default 'notyet',
	title text,
	created datetime,
	modified datetime,
	KEY type(type),
	KEY seq(seq)
);

insert into tasks (seq, type, title, created, modified) values
(1, 'notyet', '京セラよぶ', now(), now()),
(2, 'notyet', '京セラダンディよぶ', now(), now()),
(3, 'done', '映画見る', now(), now());




