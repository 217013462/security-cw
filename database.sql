CREATE TABLE IF NOT EXISTS users (
user_id int(11) NOT NULL AUTO_INCREMENT,
user_name_e varchar(100) NOT NULL,
user_name_c varchar(100) NOT NULL,
user_gender varchar(10) NOT NULL,
user_date_birth datetime NOT NULL,
user_place_birth varchar(100) NOT NULL,
user_address varchar(500) NOT NULL,
user_occupation varchar(100) NOT NULL,
user_hkid varchar(512) NOT NULL,
user_email varchar(100) NOT NULL,
user_salt varchar(128) NOT NULL,
user_pwd varchar(512) NOT NULL,
create_time datetime DEFAULT CURRENT_TIMESTAMP,
last_update_time datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (user_id),
UNIQUE (user_id, user_hkid, user_email)
);