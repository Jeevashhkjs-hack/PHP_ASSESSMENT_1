drop database new_audio_musics;
create database new_audio_musics;
use new_audio_musics;
create table users (
id int auto_increment,
name varchar(255),
user_name varchar(255),
password varchar(255),
is_premium int,
is_admin int,
created_at timestamp ,
updated_at timestamp,
primary key (id)
);

create table songs (
id int auto_increment,
name varchar(255),
song_path varchar (255),
playlist_id int null,
artists_id int,
created_at timestamp ,
updated_at timestamp ,
primary key(id)
);

create table artists(
id int auto_increment,
name varchar(255),
song_id int,
primary key (id),
foreign key (song_id) references songs(id)
);

create table playList(
id int auto_increment,
name varchar(255),
primary key (id)
)

create table listWithSong(
id int AUTO_INCREMENT,
user_id int,
song_id int,
playList_id int,
PRIMARY key (id),
foreign key (user_id) references users(id),
FOREIGN key (song_id) references songs(id),
foreign key (playList_id) references playList(id)
);

create table request_premium(
id int auto_increment,
userName varchar(255),
is_done int,
user_id int,
created_at timestamp ,
updated_at timestamp,
primary key (id)
);

create table images(
id int auto_increment,
img_path varchar(255),
model_name varchar(255),
model_no varchar(255),
created_at timestamp,
updated_at timestamp,
primary key (id)
)