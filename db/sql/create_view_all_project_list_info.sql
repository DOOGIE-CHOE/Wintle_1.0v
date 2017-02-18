CREATE VIEW `view_all_project_list_info` AS
select 
plist.project_id,
plist.start_point, 
plist.volume, 
plist.sequence, 
cinfo.*
from project_list as plist
left join view_all_content_info as cinfo 
on (plist.content_id) = (cinfo.content_id);