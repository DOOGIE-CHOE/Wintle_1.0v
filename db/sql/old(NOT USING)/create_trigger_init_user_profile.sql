create trigger init_user_profile after insert on user
for each row
insert into user_profile(user_email) values(NEW.user_email);