select  cntlist.*, prf.profile_url, prf.profile_photo_path, usr.user_name  from
(select con.*, hashs.hashtags from

(select cntlst.user_id, c.content_id, ctype.content_type_name, c.content_title, c.content_path, c.comments, c.upload_date, c.modified_date, c.view_count 
from content c, content_list cntlst, content_type ctype
where c.content_id = cntlst.content_id and
cntlst.content_type_id = ctype.content_type_id
) con

left join 
(select hlist.content_id, hlist.hashtag_id, group_concat(htag.tag_name) as hashtags
from hashtag_list hlist, hashtag htag 
where hlist.hashtag_id = htag.hashtag_id
group by hlist.content_id) hashs 
on con.content_id = hashs.content_id) cntlist, user_profile prf, user usr
where cntlist.user_id = prf.user_id and
cntlist.user_id = usr.user_id
order by cntlist.upload_date desc;