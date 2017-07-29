CREATE VIEW `view_content_comment` AS
select 
 usr_prf.user_id,
 usr_prf.profile_photo_path,
 usr_prf.profile_url,
 c_comment.content_id,
 c_comment.comment,
 c_comment.upload_date 
from 
content_comment as c_comment 
left join user_profile as usr_prf 
on usr_prf.user_id = c_comment.user_id