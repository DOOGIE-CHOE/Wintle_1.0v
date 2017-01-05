/*create table message_type(
	msg_type int primary key,
    msg_type_name varchar(50) not null
);

create table message_group(
	msg_group_id int primary key,
    msg_type int,
    msg_group_name varchar(50), 
    foreign key(msg_type) references message_type(msg_type)
);
not using anymore 2017 01 05

create table message_list(
	user_id int,
    msg_group_id int,
    foreign key(user_id) references user(user_id),
	foreign key(msg_group_id) references message_group(msg_group_id),
    primary key(user_id,msg_group_id)
);
*/

create table message_list(
	user_id int,
    msg_group_id int,
    foreign key(user_id) references user(user_id),
    primary key(user_id,msg_group_id)
);

create table user_message(
	user_id int not null,
    msg_group_id int not null,
    message varchar(1000) not null,
    is_read boolean not null default 0,
    sent_on timestamp default current_timestamp,
    foreign key(user_id) references message_list(user_id),
    foreign key(msg_group_id) references message_list(msg_group_id)
);