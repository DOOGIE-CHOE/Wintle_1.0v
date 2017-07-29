CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_User_Follow`(
in _user_id_1 int, /* 팔로잉 USER ID */
in _user_id_2 int, /* 팔오우 USER ID */
out _return int
)
this:BEGIN

	declare _user_id int default 0;
	declare _user_cnt int default 0;
    declare _follow_cnt int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;
    
	/* 팔로우 하는 사람이 회원인지 확인한다. */
	select count(*)
      into _user_cnt
      from user
     where user_id = _user_id_1;
	
    /* 본인을 팔로우 할 수 없다. */
    if _user_id_1 = _user_id_2 then
		set _return = -2;
        leave this;
	end if;
    
    /* 유저가 아닐 경우 리턴값 -1 */
	if _user_cnt <= 0 then
		set _return = -1;
        leave this;
	end if;

	/* 팔로잉 하고 있는지 체크 한다. */
	select count(*)
      into _follow_cnt
      from follow_list 
	 where user_id_1 = _user_id_1
	   and user_id_2 = _user_id_2;
	
    /* 빈값일 경우 insert, 그렇지 않으면 팔오우 삭제 */
    /* 팔로우면 1, 팔오우 취소면 2 반환 */
    if _follow_cnt <= 0 then
		insert into follow_list(user_id_1, user_id_2) 
             values (_user_id_1, _user_id_2);
		set _return = 1;
	else
		delete from follow_list 
			  where user_id_1 = _user_id_1
				and user_id_2 = _user_id_2;
        set _return = 2;
	end if;
END