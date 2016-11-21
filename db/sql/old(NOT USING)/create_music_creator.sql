create table music_creator(
music_id varchar(50),
user_email varchar(40),
likes int,
primary key(music_id, user_email),
foreign key(music_id) references music(music_id)
);