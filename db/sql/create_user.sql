create table user(
user_email varchar(40) primary key,
name varchar(20) not null,
password varchar(70) not null,
authority_id int default '0',
user_delete boolean default '0',
sign_up_date timestamp default current_timestamp, 
last_login_date timestamp default '0000-00-00 00:00:00',
login_count int default '0',
foreign key(authority_id) references authority(authority_id)
);