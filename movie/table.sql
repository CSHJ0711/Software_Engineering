create table customer (
id char(6) primary key,
pw varchar(30),
name char(4),
tel varchar(12)
);

create table theater (
theater_ID tinyint(3) primary key,
seat_amount int(3) unsigned
);

create table seat (
theater_ID tinyint(3) NOT NULL,
seat_ID varchar(4) primary key,
issue int(6) DEFAULT '0',
FOREIGN KEY(theater_ID) REFERENCES theater(theater_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

create table movie (
title VARCHAR(20) primary key,
runtime char(8),
genre char(10),
dirctor char(10),
actor char(20),
agelimit char(10)
);

create table schedule (
schedule_ID tinyint(3) primary key,
schedule_date date,
movie_title VARCHAR(20),
theater_ID tinyint(3),
FOREIGN KEY(movie_title) REFERENCES movie(title)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY(theater_ID) REFERENCES theater(theater_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

create table ticket (
customer_ID char(6),
ticket_ID tinyint(3) primary key,
movie_title VARCHAR(20),
schedule_ID tinyint(3),
theater_ID tinyint(3),
seat_ID varchar(4),
price mediumint(6) unsigned,
FOREIGN key(customer_ID) REFERENCES customer(id)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN key(movie_title) REFERENCES movie(title)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN key(schedule_ID) REFERENCES schedule(schedule_ID)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN key(theater_ID) REFERENCES theater(theater_ID)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN key(seat_ID) REFERENCES seat(seat_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);



https://www.slideshare.net/_ce/db-42499372

