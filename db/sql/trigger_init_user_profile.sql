delimiter /
create trigger init_user_profile after insert on user
for each row
begin

set @tmp = concat(NEW.name,"-",FLOOR(RAND() *90000000) + 10000000);

insert into user_profile(user_email, profile_url) values(NEW.user_email, @tmp);

insert into user_info_total(user_email) values(NEW.user_email);

END/


