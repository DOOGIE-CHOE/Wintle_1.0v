
create table user_info_total(
user_email varchar(40) primary key,
like_total int default '0',
follower_total int default '0',
following_total int default '0',
money_total int default '0',
foreign key(user_email) references user_profile(user_email)
);