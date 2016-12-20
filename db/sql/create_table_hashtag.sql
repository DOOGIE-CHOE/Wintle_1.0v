create table hashtag(
	hashtag_id int primary key,
    tag_name varchar(255) not null,
    use_count int default 1,
    upload_date timestamp default current_timestamp,
    lastest_used_date timestamp
);