DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Set_Cover_Position`(
in _profile_id int,
in _top_position int,
out _return int
)
this:BEGIN

    declare _profile_cnt int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;
    
    select count(*)
      into _profile_cnt
      from user
	 where user_id = _profile_id;
     
	/* 유저가 아닐 경우 리턴값 -1 */
	if _profile_cnt <= 0 then
		set _return = -1;
        leave this;
	end if;
    
    /* 배경사진 위치(Top 높이만) Update */
    update user_profile
       set cover_photo_position = _top_position
     where user_id = _profile_id;
     
	set _return = 1;
    
END