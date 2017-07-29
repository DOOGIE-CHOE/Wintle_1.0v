create table content (
    content_id int primary key,
    content_title varchar(255) not null,
    content_path varchar(3000) not null,
    comments varchar(3000),
    upload_date  timestamp default current_timestamp,
    modified_date timestamp  default current_timestamp,
    view_count int default 0,
    shared_count int default 0,
);