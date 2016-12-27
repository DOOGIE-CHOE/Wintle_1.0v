create table content (
	content_id int primary key,
    content_title varchar(255) not null,
    content_path varchar(255) not null,
    comments varchar(255),
    upload_date  timestamp default current_timestamp,
    modified_date timestamp  default current_timestamp,
    view_count int default 0
);