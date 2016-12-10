create table content (
	content_id int primary key,
    content_title varchar(255) not null,
    comments varchar(1000),
    upload_date  timestamp default current_timestamp,
    modified_date timestamp  default 0,
    view_count int
);