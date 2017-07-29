CREATE VIEW `view_all_project_info` AS

select 
p.project_id, p.project_creator, p.upload_date, p.view_count, p.shared_count, p.project_status_id,
plist.start_point, plist.volume, plist.sequence, plist.user_id, plist.content_id, plist.content_type_name,
plist.content_title, plist.content_path, plist.comments, plist.hashtags, plist.profile_url, plist.profile_photo_path, plist.user_name

 from project p left join view_all_project_list_info plist on p.project_id = plist.project_id;