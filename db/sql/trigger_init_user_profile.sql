delimiter /
create trigger init_user_profile after insert on user
for each row
begin

insert into user_profile(user_email) values(NEW.user_email);

insert into user_info_total(user_email) values(NEW.user_email);

END/


